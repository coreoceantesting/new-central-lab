<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-...SHA256-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body { font-family: DejaVu serif Condensed; }
        table { width: 100%; }
        .header-table td { vertical-align: top; padding: 7px; }
        .logo-left, .logo-center, .address-right { text-align: center; }
        .logo-left { text-align: center; }
        .address-right {
            text-align: left;
        }

        .address-text {
            font-size: 11px;
            display: inline-block;
            vertical-align: middle;
            text-align: left;
            margin-left: 10px; /* Adjust margin as needed */
        }

        .address-icon {
            width: 15px;
            height: 15px;
            vertical-align: middle;
        }


        /* Styles for the patient information table */
        .info-table { border: 1px solid black; width: 100%; }
        .info-table td { padding: 1px; vertical-align: top; }
        .nested-table { width: 100%; }
        .nested-table td {padding-left: 2px;}

        .test-result { width: 100%; border-collapse: collapse; margin-top: 4px; margin-bottom: 2px; }
        .test-result th, .test-result td { border: 1px solid black; padding: 4px; text-align: center; }
        .test-result th { background-color: #fffbfb; font-weight: lighter;}
        .test-result td { background-color: #38b4d6; }
        .test-result tr { border: 1px solid black; text-align: center; }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px; /* Adjust the top margin as needed */
        }
        .left-side {
            flex: 1;
            text-align: left;
            padding-left: 25px;
        }
        .right-side {
            flex: 1;
            text-align: right;
        }
        .signature {
            margin-bottom: 20px;
            height: 50px; /* Adjust the height as needed for the signature */
        }
        .name {
            font-weight: lighter;
        }
        .designation {
            font-weight: bold;
        }
        .qr-code img {
            max-width: 100px;
            height: auto;
        }

        .page-break {
            page-break-before: always;
        }

    </style>
</head>
<body>
    @php
        $firstCategory = true;
    @endphp
    @foreach ($patient_report as $main_category_name => $test_details)
        @if (!$firstCategory)
            <div class="page-break"></div>
        @endif

        @php
            $firstCategory = false;
        @endphp
    <table class="header-table">
        <tr>
            <td class="logo-left" style="border-right: 2px solid black;">
                <img src="{{ public_path('admin/images/PMC LOGO.png') }}" alt="Left Logo" height="60">
            </td>
            <td class="logo-center" style="border-right: 2px solid black;">
                <img src="{{ public_path('admin/images/MOLXPERT Infectious disease and Molecular Laboratory.png') }}" alt="Center Logo" height="60">
            </td>
            <td class="address-right">
                <p>
                    <img class="address-icon" src="{{ public_path('admin/images/location.png') }}">
                    <strong>
                        <span class="address-text">
                            Naagri Prathmik Aarogya<br>
                            &nbsp; &nbsp; &nbsp; kendra 2, Abhideep Society<br>
                            &nbsp; &nbsp; &nbsp;&nbsp;Koliwada, Old Panvel,<br>
                            &nbsp; &nbsp; &nbsp;&nbsp;Panvel,Raigad - 410206
                        </span>
                    </strong>
                </p>
            </td>
        </tr>
    </table>

    <hr style="color: black">

    <!-- Patient Information Table -->
    <table class="info-table">
        <tr>
            <td style="border-right:1px solid black">
                <table class="nested-table">
                    <tr>
                        <td><strong>Patient ID:</strong></td>
                        <td>{{ $patient_details->patient_uniqe_id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Patient Name:</strong></td>
                        <td>{{ $patient_details->first_name ." ".$patient_details->middle_name." ".$patient_details->last_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Age:</strong></td>
                        <td>{{ $patient_details->age }} Yrs</td>
                    </tr>
                    <tr>
                        <td><strong>Gender:</strong></td>
                        <td>{{ $patient_details->gender }}</td>
                    </tr>
                    <tr>
                        <td><strong>Ref. By Doctor:</strong></td>
                        <td>{{ $patient_details->refering_doctor_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Sample Collected At:</strong></td>
                        <td>{{ $patient_details?->labName?->lab_name }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="nested-table">
                    <tr>
                        <td style="padding-left: 10px;"><strong>Registered On:</strong></td>
                        <td>{{ $patient_details?->created_at  }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 10px;"><strong>Collected On:</strong></td>
                        <td>{{ $patient_details?->received_at }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 10px;"><strong>Reported On:</strong></td>
                        <td>{{ $patient_details?->first_approval_at }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 10px;"><strong>Sample ID:</strong></td>
                        <td>Barcode</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

        <!-- Main Test Name Table -->
        <h2 style="text-align: center;background-color:#1a75bc;color:white;padding:3px;margin-bottom:1px;">{{ $main_category_name }}</h2>
        {{-- sample method --}}
        @foreach ($test_details as $test_detail)
        <table>
            <tr>
                <td style="text-align: left">
                    <table class="nested-table">
                        <tr>
                            <td style="text-align: left;width:10px">Sample:</td>
                            <td style="text-align: left">Sample Name</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: left">
                    <table class="nested-table">
                        <tr>
                            <td style="text-align: right">Method:</td>
                            <td style="text-align: left">{{ $test_detail?->method?->method_name }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- test result --}}
        <table class="test-result">
            <tr>
                <th>Test Description</th>
                <th>Result</th>
                <th>Unit</th>
                <th>Biological Refereance Interval</th>
                <th>Type</th>
            </tr>
            <tr>
                <td><b>{{ $test_detail?->test_name?->sub_category_name }}</b></td>
                <td><b>{{ $test_detail?->result }}</b></td>
                <td><b>{{ $test_detail?->test_name?->units }}</b></td>
                <td><b>{{ $test_detail?->test_name?->bioreferal }}</b></td>
                <td><b>{{ $test_detail?->type }}</b></td>
            </tr>
        </table>
        @endforeach
        <br>

        <p style="margin-top: 2px;margin-bottom:2px;margin-left:8px"><strong>Kit used:</strong> Kit Name</p>
        <hr style="margin-top:1px;">
        <strong>Note: The result relate only to the specimens tested and sholud be corelated with clinical finding. </strong><br>
        {{-- <strong>Indications</strong>
        <p style="margin-top: 2px;margin-bottom:2px;font-size:12px">This page has 9 different Microsoft Excel sample datasets that you can download, to use for testing, Excel training and demos, and other learning activities. See the data descriptions below, and choose the file that will work best for you This page has 9 different Microsoft Excel sample datasets that you can download, to use for testing, Excel training and demos, and other learning activities. See the data descriptions below, and choose the file that will work best for you.</p>
        <strong>Methodology</strong>
        <p style="margin-top: 2px;margin-bottom:2px;font-size:12px">This page has 9 different Microsoft Excel sample datasets that you can download, to use for testing, Excel training and demos, and other learning activities. See the data descriptions below, and choose the file that will work best for you.</p>
        <strong>Clinical Significance</strong>
        <p style="margin-top: 2px;margin-bottom:2px;font-size:12px">Detection Of COVID- 19 RNA in patients with COVID-19 infection.</p>
        <br> --}}
        <strong style="text-decoration: underline">Interpretation Guidance :- </strong>
        <ul>
            <li style="font-size:12px">
                {{-- {{  $test_detail?->test_name?->MainCategory?->interpretation }} --}}
                {!! $test_detail?->test_name?->MainCategory?->interpretation !!}
            </li>
            {{-- <li style="font-size:12px">This page has 9 different Microsoft Excel sample datasets that you can download, to use for testing, Excel training and demos, and other learning activities. See the data descriptions below, and choose the file that will work best for you.</li> --}}
        </ul>

        <hr>
        <div class="container">
            <div class="left-side">
                <!-- Signature -->
                <div class="signature">
                    <!-- Your signature content here -->
                    {{-- <img src="{{ public_path('admin/images/Panvel_Municipal_Corporation.png') }}" alt="QR Code" height="50"> --}}
                    signature image
                </div>
                <!-- Name -->
                <div class="name">
                    Dr. Rutuja Londhe
                </div>
                <!-- Designation -->
                <div class="designation">
                    M.B.B.S, M.D(Pathology)
                </div>
            </div>
            <div class="right-side">
                <!-- QR Code -->
                <div class="qr-code">
                    {{-- <img src="{{ public_path('admin/images/Panvel_Municipal_Corporation.png') }}" alt="QR Code"> --}}
                    QR CODE
                </div>
            </div>
        </div>

        {{-- <div class="page-break"></div> --}}
    @endforeach

</body>
</html>
