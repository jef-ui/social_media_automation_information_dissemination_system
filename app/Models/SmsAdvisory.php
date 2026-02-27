<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsAdvisory extends Model
{
        protected $fillable = [
        'sms_content',
        'hazard',
        'prepared_by',
        'issues_concerns',
        'actions_taken',
        'posting_status',
    ];
}
