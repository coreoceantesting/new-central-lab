<x-admin.layout>
    <x-slot name="title">View Patient Details</x-slot>
    <x-slot name="heading">View Patient Details</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}

        {{-- Patient listing --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center"><strong>Patient Details</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <td>{{$patient_detail->first_name}} {{$patient_detail->middle_name}} {{$patient_detail->last_name}}</td>
                                    <th>Mobile Number</th>
                                    <td>{{$patient_detail->mob_no}}</td>
                                </tr>
                                <tr>
                                    <th>Adharcard No</th>
                                    <td>{{$patient_detail->aadhar_no}}</td>
                                    <th>Age</th>
                                    <td>{{$patient_detail->age}}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{$patient_detail->gender}}</td>
                                    <th>Refer Doctor Name</th>
                                    <td>{{$patient_detail->refering_doctor_name}}</td>
                                </tr>
                            </thead>
                        </table>
                        <div class="table-responsive">
                            @foreach ($organizedTests as $mainCategory => $subTests)
                                <h3 style="text-align: center; padding-top: 15px; text-decoration: underline;">{{ $mainCategory }}</h3>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>TEST NAME</th>
                                            <th>Method</th>
                                            <th>Type</th>
                                            <th>RESULT</th>
                                            <th>UNITS</th>
                                            <th>BIOLOGICAL REFERANCE INTERVAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subTests['tests'] as $test)
                                            <tr>
                                                <td>{{ $test->sub_category_name }}</td>
                                                <td>{{ $test->method_name }}</td>
                                                <td>{{ $test->type }}</td>
                                                <td>{{ $test->result }}</td>
                                                <td>{{ $test->units }}</td>
                                                <td>{{ $test->bioreferal }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {!! $subTests['interpretation'] !!}
                            @endforeach
                        </div>
                        <div class="card-footer text-center">
                            <a class="btn btn-primary" href="{{ route('first_verification_list') }}">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>




</x-admin.layout>
