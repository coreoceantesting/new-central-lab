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
                    </div>
                </div>
            </div>
        </div>




</x-admin.layout>
