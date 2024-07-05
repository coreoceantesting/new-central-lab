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

        .address-icon-new {
            width: 300px;
            height: 50px;
            vertical-align: middle;
        }

        .address-icon-new2 {
            width: 100px;
            height: 100px;
        }


        /* Styles for the patient information table */
        .info-table { border: 1px solid black; width: 100%; }
        .info-table td { padding: 1px; vertical-align: top; }
        .nested-table { width: 100%; }
        .nested-table td {padding-left: 2px;}

        .test-result { width: 100%; border-collapse: collapse; margin-top: 4px; margin-bottom: 2px; }
        .test-result th, .test-result td { border: 1px solid black; padding: 4px; text-align: center; }
        .test-result th { background-color: #fffbfb; font-weight: lighter;}
        /* .test-result td { background-color: #38b4d6; } */
        .test-result tr { border: 1px solid black; text-align: center; }

        .container {
            margin-top: 20px; /* Adjust the top margin as needed */
            overflow: hidden; /* Clear floats */
        }

        .left-side {
            float: left;
            width: calc(100% - 120px); /* Adjust the width to leave space for QR Code */
            padding-left: 25px;
        }

        .right-side {
            padding-bottom: 100px;
            float: right;
            width: 200px; /* Width of the QR Code section */
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
                <img src="{{ public_path('admin/images/PMC LOGO.png') }}" alt="Left Logo" height="80">
            </td>
            <td class="logo-center" style="border-right: 2px solid black;padding-top:2%">
                <img src="{{ public_path('admin/images/MOLXPERT Infectious disease and Molecular Laboratory.png') }}" alt="Center Logo" height="55">
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
            <td style="text-align: center"><h3><b>Patient Details</b></h3></td>
        </tr>
    </table>
    <table class="info-table">
        <tr>
            <td><strong>Patient Name:</strong></td>
            <td style="padding-right:62%;">{{ $patient_details->first_name ." ".$patient_details->middle_name." ".$patient_details->last_name }}</td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td style="border-right: 2px solid black;">
                <table class="nested-table">
                    <tr>
                        <td style="border-bottom: 1px solid black;"><strong>Report ID:</strong></td>
                        <td style="border-bottom: 1px solid black;">{{ $patient_details->patient_uniqe_id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Age:</strong></td>
                        <td>{{ $patient_details->age }} Yrs</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="nested-table">
                    <tr>
                        <td style="padding-left: 10px; border-bottom: 1px solid black;"><strong>Patient ID:</strong></td>
                        <td style="border-bottom: 1px solid black;">{{ $patient_details->patient_uniqe_id }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 10px;"><strong>Gender:</strong></td>
                        <td>{{ $patient_details->gender }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table class="info-table">
        <tr>
            <td><strong>Sample ID:</strong></td>
            <td style="padding-right:42%;"><img class="address-icon-new" src="data:image/png;base64,{{ $barcode }}"></td>
        </tr>
    </table>
    <table class="info-table">
        <tr>
            <td style="border-right: 2px solid black;">
                <table class="nested-table">
                    <tr>
                        <td style="border-bottom: 1px solid black;"><strong>Sample Collected At:</strong></td>
                        <td style="border-bottom: 1px solid black;">{{ $patient_details->health_post_name }}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;"><strong>Receive Lab:</strong></td>
                        <td style="border-bottom: 1px solid black;">{{ $patient_details?->labName?->lab_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Report On:</strong></td>
                        <td>{{ $patient_details?->second_approval_at }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="nested-table">
                    <tr>
                        <td style="padding-left: 10px; border-bottom: 1px solid black;"><strong>Collected On:</strong></td>
                        <td style="border-bottom: 1px solid black;">{{ $patient_details->created_at }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 10px;border-bottom: 1px solid black;"><strong>Received On:</strong></td>
                        <td style="border-bottom: 1px solid black;">{{ $patient_details->received_at }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 10px;"><strong>Medical Officer Name:</strong></td>
                        <td>{{ $patient_details->refering_doctor_name }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    {{-- patient information table  --}}

        <!-- Main Test Name Table -->
        <h2 style="text-align: center;border:1px solid black;color:black;padding:3px;margin-bottom:1px;">{{ $main_category_name }}</h2>
        {{-- sample method --}}
        @foreach ($test_details as $test_detail)
        <table>
            <tr>
                <td style="text-align: left">
                    <table class="nested-table">
                        <tr>
                            <td style="text-align: left;width:10px">Method:</td>
                            <td style="text-align: left">{{ $test_detail?->method?->method_name }}</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: left">
                    <table class="nested-table">
                        <tr>
                            <td style="text-align: right">Method Type:</td>
                            <td style="text-align: left">{{ $test_detail?->type }}</td>
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
                {{-- <th>Type</th> --}}
            </tr>
            <tr>
                <td>{{ $test_detail?->test_name?->sub_category_name }}</td>
                <td>
                    @if ($test_detail?->type == "Quantitative")
                        @if ($test_detail?->result < $test_detail?->test_name?->from_range || $test_detail?->result > $test_detail?->test_name?->to_range)
                            <b>{{ $test_detail?->result }}</b>
                        @else
                            {{ $test_detail?->result }}
                        @endif
                    @endif
                    @if ($test_detail?->type == "Cumulative")
                        {{ $test_detail?->result }}
                    @endif
                </td>
                <td>{{ $test_detail?->test_name?->units }}</td>
                <td>
                    @if ($test_detail?->type == "Quantitative")
                    {{ $test_detail?->test_name?->from_range }} - {{ $test_detail?->test_name?->to_range }}
                    @else
                    {{ $test_detail?->test_name?->bioreferal }}
                    @endif
                </td>
                {{-- <td>{{ $test_detail?->type }}</td> --}}
            </tr>
        </table>
        @endforeach
        <br>

        <p style="margin-top: 2px;margin-bottom:2px;margin-left:8px"><strong>Kit used:</strong> Kit Name</p>
        <hr style="margin-top:1px;">
        <strong>Note: The result relate only to the specimens tested and sholud be corelated with clinical finding. </strong><br>
        <strong style="text-decoration: underline">Interpretation Guidance :- </strong>
        <ul>
            <li style="font-size:12px">
                {{-- {{  $test_detail?->test_name?->MainCategory?->interpretation }} --}}
                {!! $test_detail?->test_name?->MainCategory?->interpretation !!}
            </li>
            {{-- <li style="font-size:12px">This page has 9 different Microsoft Excel sample datasets that you can download, to use for testing, Excel training and demos, and other learning activities. See the data descriptions below, and choose the file that will work best for you.</li> --}}
        </ul>

        <hr>

        {{-- footer section --}}
        <table>
            <tr>
                <td>
                    <!-- Signature -->
                    <div class="signature">
                        <!-- Your signature content here -->
                        <!-- <img src="{{ public_path('admin/images/Panvel_Municipal_Corporation.png') }}" alt="QR Code" height="50"> -->
                        Signature
                    </div>
                    <!-- Name -->
                    <div class="name">
                        Dr. Rutuja Londhe
                    </div>
                    <!-- Designation -->
                    <div class="designation">
                        M.B.B.S, M.D(Pathology)
                    </div>
                </td>
                <td>
                    <!-- QR Code -->
                    <div class="qr-code">
                        <img class="address-icon-new2" src="{{ public_path('admin/images/qr.jpg') }}" alt="QR Code">
                        {{-- {!! $qr_code !!} --}}
                        <!-- QR CODE -->
                    </div>
                </td>
            </tr>
        </table>
        
        

        {{-- <div class="page-break"></div> --}}
    @endforeach

</body>
</html>
