<?php

namespace App\Http\Controllers;

use App\Models\SmsAdvisory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SmsAdvisoryController extends Controller
{
    public function index()
{
    // Get all records
    $records = SmsAdvisory::latest()->get();

    // Count per hazard
    $hazardCounts = SmsAdvisory::selectRaw('hazard, COUNT(*) as total')
        ->groupBy('hazard')
        ->pluck('total', 'hazard'); 
        // result: ['Thunderstorm' => 15, 'Earthquake' => 3]

    return view('sms.index', [
        'records' => $records,
        'hazardCounts' => $hazardCounts
    ]);
}


    public function store(Request $request)
    {
        $request->validate([
            'sms_content'     => 'required|string',
            'prepared_by'     => 'nullable|string',
            'issues_concerns' => 'nullable|string',
            'actions_taken'   => 'nullable|string',
        ]);

        // ================================
        // 1️⃣ NORMALIZE CONTENT
        // ================================
        $content = trim($request->sms_content);

        // ================================
        // 2️⃣ SPLIT CONTENT INTO LINES
        // ================================
        $lines = preg_split("/\r\n|\n|\r/", $content);
        $titleLine = strtolower(trim($lines[0] ?? ''));

        // ================================
        // 3️⃣ HANDLE GENERIC FIRST LINE
        // ================================
        if (
            $titleLine === 'for widest dissemination' ||
            str_contains($titleLine, 'widest dissemination')
        ) {
            $titleLine = strtolower(trim($lines[1] ?? $titleLine));
        }

        // ================================
        // 4️⃣ IMAGE / HAZARD MAP (TITLE ONLY)
        // ================================
       $imageMap = [

    'Earthquake' => [
        'file' => 'earthquake.png',
        'keywords' => ['earthquake', 'eq info', 'eq '],
    ],

    'Thunderstorm' => [
        'file' => 'thunderstorm.png',
        'keywords' => ['thunderstorm advisory', 'thunderstorm'],
    ],

    'Heavy Rainfall' => [
        'file' => 'heavyrainfall.png',
        'keywords' => [
            'heavy rainfall warning',
            'heavy rainfall advisory',
            'heavy rainfall',
        ],
    ],

    'Rainfall Advisory' => [
        'file' => 'rainfall_advisory.png',
        'keywords' => ['rainfall advisory'],
    ],

    'Tropical Cyclone' => [
        'file' => 'tropical_cyclone.png',
        'keywords' => ['tropical cyclone', 'tcb'],
    ],

    'Flood Advisory' => [
        'file' => 'flood_advisory.png',
        'keywords' => ['general flood advisory', 'gfa', 'flood'],
    ],

    'Gale Warning' => [
        'file' => 'galewarning.png',
        'keywords' => ['gale warning'],
    ],

    'Weather Advisory' => [
        'file' => 'weather_advisory.png',
        'keywords' => ['weather advisory'],
    ],

    'Public Weather Forecast' => [
        'file' => 'weather_forecast.png',
        'keywords' => ['public weather forecast', 'pwf'],
    ],

    'Tsunami' => [
        'file' => 'tsunami_information.png',
        'keywords' => ['tsunami'],
    ],

    'Landslide' => [
        'file' => 'landslide.png',
        'keywords' => ['landslide'],
    ],
];


        // ================================
        // 5️⃣ DEFAULT IMAGE + HAZARD
        // ================================
        $image  = 'images/default.png';
        $hazard = 'Unknown';

        // ================================
        // 6️⃣ MATCH IMAGE & HAZARD
        // ================================
foreach ($imageMap as $label => $data) {
    foreach ($data['keywords'] as $keyword) {
        if ($titleLine !== '' && str_contains($titleLine, $keyword)) {
            $image  = 'images/' . $data['file'];
            $hazard = $label; // ✅ EXACT MATCH WITH DASHBOARD
            break 2;
        }
    }
}


        // ================================
        // 7️⃣ SAFETY CHECK IMAGE
        // ================================
        if (!file_exists(public_path($image))) {
            logger()->warning('Hazard image not found, using default', [
                'image' => $image
            ]);

            $image = 'images/default.png';
            $hazard = 'Unknown';
        }

        // ================================
// 🔟 RESOLVE ISSUES & ACTIONS
// ================================
$issues = $request->issues_option === 'custom'
    ? $request->issues_concerns
    : 'None';

$actions = $request->actions_option === 'custom'
    ? $request->actions_taken
    : 'Posted to OCD MIMAROPA Facebook page and sent thru mobile phone and Messenger';


        // ================================
        // 8️⃣ SAVE SMS ADVISORY (DRAFT)
        // ================================
        $sms = SmsAdvisory::create([
    'sms_content'     => $content,
    'hazard'          => $hazard,
    'prepared_by'     => $request->prepared_by,
    'issues_concerns' => $issues,
    'actions_taken'   => $actions,
    'posting_status'  => 'draft',
]);


        // ================================
        // 9️⃣ POST TO FACEBOOK PAGE
        // ================================
        $pageId    = config('services.facebook.page_id');
        $pageToken = config('services.facebook.page_token');

        if (!$pageId || !$pageToken) {
            logger()->error('Facebook Page ID or Token missing');
            $sms->update(['posting_status' => 'failed']);
            return back()->with('error', 'Facebook configuration missing.');
        }

        try {
            $response = Http::asMultipart()
                ->attach(
                    'source',
                    fopen(public_path($image), 'r'),
                    basename($image)
                )
                ->post(
                    "https://graph.facebook.com/v24.0/{$pageId}/photos",
                    [
                        'caption' => $content,
                        'access_token' => $pageToken,
                        'published' => true,
                    ]
                );

            if ($response->successful()) {
                $sms->update(['posting_status' => 'posted']);
            } else {
                logger()->error('Facebook posting failed', [
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);

                $sms->update(['posting_status' => 'failed']);
            }

        } catch (\Throwable $e) {
            logger()->error('Facebook post exception', [
                'message' => $e->getMessage()
            ]);

            $sms->update(['posting_status' => 'failed']);
        }

        return back()->with('success', 'SMS Advisory processed successfully.');
    }
}
