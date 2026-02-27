<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCD SMS Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


    <style>
        * {
            box-sizing: border-box;
        }

        body,
        html {
            padding: 0px;
            margin: 0px;
            font-family: "Inter", sans-serif;
            width: 100%;
            height: 100%;
        }

        .dashboard {
            height: 100vh;
            display: flex;
            gap: 5px;
            overflow: hidden;

        }

        .sidebar {
            background-color: #0b355a;
            width: 150px;
            height: 100vh;
            flex-shrink: 0;
        }

        .main {

            flex: 1;
            /* take remaining space */
            min-width: 0;
            /* IMPORTANT: prevents overflow */
            overflow: hidden;
            /* OK na ito */
                display: flex;
    flex-direction: column;
        }

        .title-header {
            display: flex;
            justify-content: space-between;
            padding-left: 20px;
            padding-right: 20px;
            align-items: center;
            margin: 0px;
        }

        h4 {
            font-size: 15px;
            color: #333;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 5px;
            padding: 10px 20px;
        }

        .card {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            min-height: 100px;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }

        .number {
            font-size: 30px;
            font-weight: 1000;
            color: #0b4f8a;
        }

        .content {
            font-size: 15px;
        }

        p {
            margin: 0px;
            padding: 0px;
        }

        .titleleft {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }

        .left {
            font-size: 15px;
            font-weight: 400;
        }

        .logo {
            height: 30px;
        }

        .db-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;


        }

        .table-scroll {
            margin-top: 10px;
            overflow-y: auto;
            overflow-x: auto;
            border-radius: 5px;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);

        }

        .db-table thead th {
            padding: 7px 10px;
            text-align: left;
            font-size: 11px;
            border-bottom: 1px solid rgb(197, 197, 197);
        }

        .db-table th:nth-child(2) {
            width: 550px;
        }

        .db-table th:nth-child(3) {
            width: 200px;
        }
        
        .db-table th:nth-child(4) {
        width: 100px;
        }

         .db-table th:nth-child(5) {
        width: 140px;
        }

        .db-table tbody tr {
            padding: 20px 15px;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0, 0.5);
            font-size: 11px;
        }

        .db-table tbody td {
            padding: 7px 10px;
            text-align: left;
            border-bottom: 1px solid rgb(246, 238, 238);
        }

        .db-table tbody td:last-child {
            border-right: 3px solid #0D5EA6;
            text-align: right;

        }

        .db-table tbody td:first-child {
            border-left: 5px solid #fc6634;
            text-align: right;

        }

        .bar {
            padding-left: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .button {
            background: #fc6634;
            height: 35px;
            /* OCD blue */
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
        }

        .button:hover {
            background: #0b4f8a;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .button:active {
            transform: translateY(1px);
        }

        .button:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(13, 94, 166, 0.3);
        }

        .nav-month {
            list-style: none;
            display: flex;
            gap: 6px;
            padding: 0;
            margin: 0;
        }

        .nav-month li a {
            display: inline-block;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 300;
            color: #4b4b4b;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        /* Hover */
        .nav-month li a:hover {
            background: rgba(252, 102, 52, 0.1);
            color: #fc6634;
        }

        /* Active month */
        .nav-month li a.active {
            background: #2c2c2c;
            color: #ffffff;
        }

        /* MODAL OVERLAY */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999;
        }

        /* MODAL BOX */
        .modal {
            background: #ffffff;
            width: 420px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            animation: fadeIn 0.2s ease;
        }

        /* HEADER */
        .modal-header {
            padding: 14px 16px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 15px;
            color: #333;
        }

        /* CLOSE BUTTON */
        .close-btn {
            border: none;
            background: none;
            font-size: 20px;
            cursor: pointer;
            color: #999;
        }

        /* FORM */
        .modal form {
            padding: 16px;
        }

        .modal label {
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        .modal textarea {
            width: 100%;
            height: 120px;
            resize: none;
            padding: 10px;
            font-size: 13px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-family: "Inter", sans-serif;
        }

        /* ACTIONS */
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 14px;
        }

        .btn {
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            border: none;
        }

        .btn.cancel {
            background: #f0f0f0;
            color: #333;
        }

        .btn.save {
            background: #0D5EA6;
            color: #fff;
        }

        .btn.save:hover {
            background: #0b4f8a;
        }

        /* ANIMATION */
        @keyframes fadeIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .footer {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            color: rgb(31, 31, 31);
            height: 25px;
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            font-size: 12px;
            padding: 10px 30px;
        }

        .footer-logo {
            height: 15px;
        }

        .number {
            font-size: 2.2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #202020;
            /* number color */
        }

        .number i {
            font-size: 1.6rem;
            color: #fc6634;
            /* icon color */
        }

        .clock {
            font-weight: 300;
            font-size: 12px;
        }

        .modal {
            max-height: 85vh;
            overflow-y: auto;
        }

        .generating {
            font-size: 12px;
            color: #666;
            font-style: italic;
        }

        .circle-loader {
            width: 26px;
            height: 26px;
            border: 3px solid rgba(13, 110, 253, 0.25);
            border-top: 3px solid #c55900;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    @php
        $hazards = [
            'Tropical Cyclone',
            'Thunderstorm',
            'Rainfall Advisory',
            'Heavy Rainfall',
            'Public Weather Forecast',
            'Weather Advisory',
            'Earthquake',
            'Tsunami',
            'Flood Advisory',
            'Gale Warning',
            'Landslide',
            'Rainfall Forecast',
        ];

        $hazardIcons = [
            'Tropical Cyclone' => 'bi-wind',
            'Thunderstorm' => 'bi-cloud-lightning-rain',
            'Rainfall Advisory' => 'bi-cloud-drizzle',
            'Heavy Rainfall' => 'bi-cloud-rain-heavy',
            'Public Weather Forecast' => 'bi-broadcast',
            'Weather Advisory' => 'bi-exclamation-triangle',
            'Earthquake' => 'bi-activity',
            'Tsunami' => 'bi-tsunami',
            'Flood Advisory' => 'bi-water',
            'Gale Warning' => 'bi-wind',
            'Landslide' => 'bi-triangle-fill',
            'Rainfall Forecast' => 'bi-cloud-rain',
        ];
    @endphp


    <div class="dashboard">

        <div class="sidebar">
        </div>

        <div class="main">
            <div class="title-header">
                <div class="titleleft">
                    <img src="images/ocdlogo.png" alt="logo" class="logo">
                    <h4 class="left">OCD MIMAROPA Automated SMS Advisory</h4>
                </div>
                <h4 class="clock" id="liveClock"></h4>

            </div>

            <div class="grid-container">
                @foreach ($hazards as $hazard)
                    <div class="card">
                        <p class="number">
                            <i class="bi {{ $hazardIcons[$hazard] ?? 'bi-exclamation-circle' }}"></i>
                            {{ $hazardCounts[$hazard] ?? 0 }}
                        </p>

                        <p class="content" style="color: #191919;font-size: 12px; font-weight: 600">{{ $hazard }}
                        </p>
                    </div>
                @endforeach
            </div>


            <div class="bar">
                <button class="button">Publish Advisory</button>

                <!-- MODAL -->
                <div class="modal-overlay" id="smsModal">
                    <div class="modal">
                        <div class="modal-header">
                            <h3>Publish Advisory</h3>
                            <button class="close-btn" onclick="closeModal()">×</button>
                        </div>

                        <form method="POST" action="{{ route('sms.store') }}">
                            @csrf

                            <!-- SMS CONTENT -->
                            <label for="sms_content">SMS Content</label>
                            <textarea name="sms_content" id="sms_content" placeholder="Type SMS message here..." required></textarea>

                            <!-- ISSUES & CONCERNS -->
                            <label style="margin-top:12px;">Issues and Concerns</label>
                            <select name="issues_option" id="issues_option" onchange="toggleIssues()"
                                style="width:100%;padding:6px;">
                                <option value="none">None</option>
                                <option value="custom">Specify</option>
                            </select>

                            <textarea name="issues_concerns" id="issues_concerns" placeholder="Describe issues and concerns..."
                                style="display:none;"></textarea>

                            <!-- ACTIONS TAKEN -->
                            <label style="margin-top:12px;">Actions Taken</label>
                            <select name="actions_option" id="actions_option" onchange="toggleActions()"
                                style="width:100%;padding:6px;">
                                <option value="default">Default</option>
                                <option value="custom">Specify</option>
                            </select>

                            <textarea name="actions_taken" id="actions_taken" placeholder="Describe actions taken..." style="display:none;"></textarea>

                            <div id="imagePreviewBox" style="display:none;margin-top:12px;">
                                <label style="font-size:13px;">Selected Image Preview</label>

                                <div id="previewContainer"
                                    style="
                                    border:1px solid #ddd;
                                    padding:10px;
                                    text-align:center;
                                    background:#fafafa;
                                    border-radius:6px;
                                    position:relative;
                                ">

                                <!-- LOADING OVERLAY -->
                                <div id="loadingOverlay"
                                style="
                                        display:none;
                                        position:absolute;
                                        inset:0;
                                        background:rgba(13,110,253,0.08);
                                        backdrop-filter: blur(1px);
                                        border-radius:6px;
                                        align-items:center;
                                        justify-content:center;
                                        flex-direction:column;
                                        z-index:10;
                                    ">

                                <div class="circle-loader"></div>
                                <div style="margin-top:8px;font-size:12px;color:#0d6efd;">
                                     Generating image…
                                </div>
                                    </div>

                                    <!-- IMAGE -->
                                    <img id="previewImage" src="" alt="Preview"
                                        style="
                                            max-width:100%;
                                            max-height:150px;
                                            object-fit:contain;
                                            display:none;
                                            margin:0 auto;
                                        ">

                                    <div id="previewLabel" style="margin-top:6px;font-size:12px;font-weight:600;">
                                    </div>
                                </div>
                            </div>



                            <div class="modal-actions">
                                <button type="button" class="btn cancel" onclick="closeModal()">Cancel</button>
                                <button type="submit" class="btn save">Publish</button>
                            </div>
                        </form>


                    </div>
                </div>


                <ul class="nav-month">
                    <li><a href="#">Jan</a></li>
                    <li><a href="#">Feb</a></li>
                    <li><a href="#">Mar</a></li>
                    <li><a href="#">Apr</a></li>
                    <li><a href="#">May</a></li>
                    <li><a href="#">Jun</a></li>
                    <li><a href="#">Jul</a></li>
                    <li><a href="#">Aug</a></li>
                    <li><a href="#">Sep</a></li>
                    <li><a href="#">Oct</a></li>
                    <li><a href="#">Nov</a></li>
                    <li><a href="#">Dec</a></li>
                    <li><a href="#">Weekly Report</a></li>
                    <li><a href="#">Monthly Report</a></li>
                </ul>

            </div>




            <div class="table-scroll">
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>SMS Content</th>
                            <th>Hazards</th>
                            <th>Prepared By</th>
                            <th>Issues and Concerns</th>
                            <th>Actions Taken</th>
                            <th>Posting Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($records as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->sms_content }}</td>
                                <td>{{ $row->hazard }}</td>
                                <td>{{ $row->prepared_by ?? '—' }}</td>
                                <td>{{ $row->issues_concerns ?? '—' }}</td>
                                <td>{{ $row->actions_taken ?? '—' }}</td>
                                <td><a href="https://www.facebook.com/civildefense4b/"
                                        style="color: #fc6634;font-weight:700;text-decoration:none;">{{ strtoupper($row->posting_status) }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="footer">
                <img src="{{ asset('images/ocdlogo.png') }}" alt="logo" class="footer-logo">
                <p class="p-footer">Designed and Developed by ICTU MIMAROPA, Office of Civil Defense MIMAROPA © 2025
                </p>
            </div>
        </div>
    </div>

</body>

<script>
    const modal = document.getElementById('smsModal');

    document.querySelector('.button').addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    function closeModal() {
        modal.style.display = 'none';
    }

    // Close when clicking outside modal
    modal.addEventListener('click', e => {
        if (e.target === modal) closeModal();
    });
</script>

<script>
    function updateClock() {
        const now = new Date();

        const datePart = now.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        const timePart = now.toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        });

        document.getElementById('liveClock').innerText =
            `${datePart} ${timePart}`;
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>

<script>
    function toggleIssues() {
        const select = document.getElementById('issues_option');
        const textarea = document.getElementById('issues_concerns');
        textarea.style.display = select.value === 'custom' ? 'block' : 'none';
    }

    function toggleActions() {
        const select = document.getElementById('actions_option');
        const textarea = document.getElementById('actions_taken');
        textarea.style.display = select.value === 'custom' ? 'block' : 'none';
    }
</script>

<script>
    const imageRules = [{
            key: 'earthquake',
            img: 'earthquake.png',
            label: 'Earthquake'
        },
        {
            key: 'eq info',
            img: 'earthquake.png',
            label: 'Earthquake'
        },

        {
            key: 'thunderstorm advisory',
            img: 'thunderstorm.png',
            label: 'Thunderstorm'
        },
        {
            key: 'thunderstorm',
            img: 'thunderstorm.png',
            label: 'Thunderstorm'
        },

        {
            key: 'heavy rainfall warning',
            img: 'heavyrainfall.png',
            label: 'Heavy Rainfall'
        },
        {
            key: 'heavy rainfall advisory',
            img: 'heavyrainfall.png',
            label: 'Heavy Rainfall'
        },
        {
            key: 'heavy rainfall',
            img: 'heavyrainfall.png',
            label: 'Heavy Rainfall'
        },

        {
            key: 'rainfall advisory',
            img: 'rainfall_advisory.png',
            label: 'Rainfall Advisory'
        },

        {
            key: 'tropical cyclone',
            img: 'tropical_cyclone.png',
            label: 'Tropical Cyclone'
        },
        {
            key: 'tcb',
            img: 'tropical_cyclone.png',
            label: 'Tropical Cyclone'
        },

        {
            key: 'general flood advisory',
            img: 'flood_advisory.png',
            label: 'Flood Advisory'
        },
        {
            key: 'gfa',
            img: 'flood_advisory.png',
            label: 'Flood Advisory'
        },

        {
            key: 'gale warning',
            img: 'galewarning.png',
            label: 'Gale Warning'
        },

        {
            key: 'weather advisory',
            img: 'weather_advisory.png',
            label: 'Weather Advisory'
        },
        {
            key: 'public weather forecast',
            img: 'weather_forecast.png',
            label: 'Public Weather Forecast'
        },
        {
            key: 'pwf',
            img: 'weather_forecast.png',
            label: 'Public Weather Forecast'
        },

        {
            key: 'tsunami',
            img: 'tsunami_information.png',
            label: 'Tsunami'
        },
    ];

    const textarea = document.getElementById('sms_content');
    const previewBox = document.getElementById('imagePreviewBox');
    const previewImg = document.getElementById('previewImage');
    const previewLabel = document.getElementById('previewLabel');
    const loadingOverlay = document.getElementById('loadingOverlay');

    let timer = null;

    textarea.addEventListener('input', detectImage);

    function extractTitle(text) {
        const lines = text.split(/\r?\n/).map(l => l.trim()).filter(Boolean);
        if (!lines.length) return '';

        let title = lines[0].toLowerCase();

        if (title.includes('widest dissemination') && lines[1]) {
            title = lines[1].toLowerCase();
        }
        return title;
    }

    function detectImage() {
        if (timer) clearTimeout(timer);

        const titleLine = extractTitle(textarea.value);

        previewBox.style.display = 'block';
        previewImg.style.display = 'none';
        previewLabel.textContent = '';
        loadingOverlay.style.display = 'flex';

        timer = setTimeout(() => {
            let matched = false;

            for (const rule of imageRules) {
                if (titleLine.includes(rule.key)) {
                    previewImg.src = `/images/${rule.img}`;
                    previewImg.style.display = 'block';
                    previewLabel.textContent = rule.label;
                    loadingOverlay.style.display = 'none';
                    matched = true;
                    break;
                }
            }

            if (!matched) {
                loadingOverlay.style.display = 'none';
                previewBox.style.display = 'none';
            }
        }, 600);
    }
</script>



</html>
