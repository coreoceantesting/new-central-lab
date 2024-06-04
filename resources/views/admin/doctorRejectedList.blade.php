<x-admin.layout>
    <x-slot name="title">Patient Sample List</x-slot>
    <x-slot name="heading">Patient Sample List</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}

        {{-- Patient listing --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="">
                                    {{-- <button id="addToTable" class="btn btn-primary">Add <i class="fa fa-plus"></i></button> --}}
                                    <h4 class="card-title">Patient Sample List</h4>
                                    <button id="btnCancel" class="btn btn-danger" style="display:none;">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr.NO</th>
                                        <th>Patient Name</th>
                                        <th>Patient Mobile No</th>
                                        <th>Patient AadharCard No</th>
                                        <th>Patient Age</th>
                                        <th>Status</th>
                                        <th>Remark</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patient_list as $index => $list)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $list->first_name }} {{ $list->middle_name }} {{ $list->last_name }}</td>
                                            <td>{{ $list->mob_no }}</td>
                                            <td>{{ $list->aadhar_no }}</td>
                                            <td>{{ $list->age }}</td>
                                            <td>{{ $list->second_approval_status }}</td>
                                            <td>{{ $list->second_approval_remark }}</td>
                                            {{-- <td>
                                                <a href="{{ route('view.patientParameter', $list->patient_id) }}" class="btn btn-primary text-dark px-2 py-1" title="Test Parameter">View</a>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>




</x-admin.layout>




