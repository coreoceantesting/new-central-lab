<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; }
        .header-table td { vertical-align: top; padding: 10px; }
        .logo-left, .logo-center, .address-right { text-align: center; }
        .logo-left { text-align: center; }
        .address-right { text-align: left; }
        .address-right p { display: inline; vertical-align: middle; }

        /* Styles for the patient information table */
        .info-table { border: 1px solid black; width: 100%; }
        .info-table td { padding: 15px; vertical-align: top; }
        .nested-table { width: 100%; }
        .nested-table td { padding: 5px; }

        .test-result { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .test-result th, .test-result td { border: 1px solid black; padding: 8px; text-align: center; }
        .test-result th { background-color: #fffbfb; font-weight: lighter;}
        .test-result td { background-color: #047c82; }
        .test-result tr { border: 1px solid black; text-align: center; }

        .container { display: flex; }
        .left-side { flex: 1; }
        .right-side { flex: 1; }
        .signature { margin-bottom: 20px; }
        .name { font-weight: lighter; }
        .designation { font-weight: bold ; }
        .qr-code { text-align: right; }
        /* .qr-code img { min-width: 10px; } */
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="logo-left" style="border-right:2px solid black">
                <img src="{{ public_path('admin/images/Panvel_Municipal_Corporation.png') }}" alt="Left Logo" height="80" width="100">
            </td>
            <td class="logo-center" style="border-right:2px solid black">
                <img src="{{ public_path('admin/images/Panvel_Municipal_Corporation.png') }}" alt="Center Logo" height="80" width="100">
            </td>
            <td class="address-right">
                <p>&#xf276; Naagri Prathmik Aarogya<br>
                kendra 2, Abhideep Society<br>
                Koliwada, Old Panvel,<br>
                Panvel,Raigad - 410206</p>
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
                        <td>2456789</td>
                    </tr>
                    <tr>
                        <td><strong>Patient Name:</strong></td>
                        <td>Sameer Jadhav</td>
                    </tr>
                    <tr>
                        <td><strong>Age:</strong></td>
                        <td>28 Yrs</td>
                    </tr>
                    <tr>
                        <td><strong>Gender:</strong></td>
                        <td>MALE</td>
                    </tr>
                    <tr>
                        <td><strong>Ref. By Doctor:</strong></td>
                        <td>SELF</td>
                    </tr>
                    <tr>
                        <td><strong>Sample Collected At:</strong></td>
                        <td>2456789</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="nested-table">
                    <tr>
                        <td><strong>Registered On:</strong></td>
                        <td>28/3/2024, 02:22 PM</td>
                    </tr>
                    <tr>
                        <td><strong>Collected On:</strong></td>
                        <td>28/3/2024, 02:22 PM</td>
                    </tr>
                    <tr>
                        <td><strong>Reported On:</strong></td>
                        <td>28/3/2024, 02:22 PM</td>
                    </tr>
                    <tr>
                        <td><strong>Sample ID:</strong></td>
                        <td>Barcode</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Main Test Name Table -->
    <h2 style="text-align: center;background-color:#436ed9;color:white;padding:3px">Main Test Name</h2>

    {{-- sample method --}}

    <table>
        <tr>
            <td style="text-align: center">
                <table class="nested-table">
                    <tr>
                        <td style="text-align: right">Sample:</td>
                        <td style="text-align: left">Sample Name</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center">
                <table class="nested-table">
                    <tr>
                        <td style="text-align: right">Method:</td>
                        <td style="text-align: left">Method Name</td>
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
        </tr>
        <tr>
            <td><b>Desciption</b></td>
            <td><b>Negative</b></td>
        </tr>
    </table>
    <br>
    <strong>Kit used:</strong> Kit Name
    <hr>
    <strong>Note: The result relate only to the specimens tested and sholud be corelated with clinical finding. </strong>
    <strong>Indication</strong>
    <p style="padding: 0px;">This page has 9 different Microsoft Excel sample datasets that you can download, to use for testing, Excel training and demos, and other learning activities. See the data descriptions below, and choose the file that will work best for you This page has 9 different Microsoft Excel sample datasets that you can download, to use for testing, Excel training and demos, and other learning activities. See the data descriptions below, and choose the file that will work best for you.</p>
    <strong>Methodology</strong>
    <p style="padding: 0px;">This page has 9 different Microsoft Excel sample datasets that you can download, to use for testing, Excel training and demos, and other learning activities. See the data descriptions below, and choose the file that will work best for you.</p>
    <strong>Clinical Significance</strong>
    <p style="padding: 0px;">Detection Of COVID- 19 RNA in patients with COVID-19 infection.</p>
    <br>
    <strong style="text-decoration: underline">Interpretation Guidance :- </strong>
    <ul>
        <li>This page has 9 different Microsoft Excel sample datasets that you can download, to use for testing, Excel training and demos, and other learning activities. See the data descriptions below, and choose the file that will work best for you This page has 9 different Microsoft Excel sample datasets that you can download, to use for testing, Excel training and demos, and other learning activities. See the data descriptions below, and choose the file that will work best for you.</li>
        <li>This page has 9 different Microsoft Excel sample datasets that you can download, to use for testing, Excel training and demos, and other learning activities. See the data descriptions below, and choose the file that will work best for you.</li>
        <li>This page has 9 different Microsoft Excel sample datasets that you can download, to use for testing, Excel training and demos, and other learning activities. See the data descriptions below, and choose the file that will work best for you This page has 9 different Microsoft Excel sample datasets that you can download, to use for testing, Excel training and demos, and other learning activities. See the data descriptions below, and choose the file that will work best for you.</li>
        <li>This page has 9 different Microsoft Excel sample datasets that you can download, to use for testing, Excel training and demos, and other learning activities. See the data descriptions below, and choose the file that will work best for you.</li>
    </ul>

    <hr>
    <div class="container">
        <div class="left-side">
            <!-- Signature -->
            <div class="signature">
                <!-- Your signature content here -->
            </div>
            <!-- Name -->
            <div class="name">
                Dr.Rutuja Londhe
            </div>
            <!-- Designation -->
            <div class="designation">
                M.B.B.S, M.D(Pathology)
            </div>
        </div>
        <div class="right-side">
            <!-- QR Code -->
            <div class="qr-code">
                <img src="{{ public_path('admin/images/Panvel_Municipal_Corporation.png') }}" alt="QR Code" height="50px">
            </div>
        </div>
    </div>


</body>
</html>
