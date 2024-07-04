<x-admin.layout>
    <x-slot name="title">Rejected Sample List</x-slot>
    <x-slot name="heading">Rejected Sample List</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}

        {{-- Patient listing --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-end">
                            <div class="col-md-12">
                                <form id="searchForm" class="row" method="GET" action="{{ route('rejected_sample_list') }}">
                                    @csrf
                                    <div class="col-md-4">
                                        <label for="fromdate">From Date</label>
                                        <input class="form-control" type="date" name="fromdate" id="fromdate" value="{{ $fromDate ?? '' }}"> 
                                    </div>
                                    <div class="col-md-4">
                                        <label for="todate">To Date</label>
                                        <input class="form-control" type="date" name="todate" id="todate" value="{{ $toDate ?? '' }}">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary ms-2">Search</button>
                                        <a href="{{ route('rejected_sample_list') }}" class="btn btn-primary ms-2">cancel</a>
                                    </div>
                                </form>
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
                                        <th>Patient Age</th>
                                        <th>Lab Name</th>
                                        <th>Test Name</th>
                                        <th>Sample Collection Details</th>
                                        <th>Status</th>
                                        <th>Remark</th>
                                        <th>Rejected By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patient_list as $index => $list)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $list->first_name }} {{ $list->middle_name }} {{ $list->last_name }}</td>
                                            <td>{{ $list->age }}</td>
                                            <td>{{ $list->lab_name }}</td>
                                            <td>{{ $list->main_category_name }}</td>
                                            <td>{{ $list->date }}</td>
                                            <td>{{ $list->status }}</td>
                                            <td>{{ $list->remark }}</td>
                                            @if ($list->status == 'rejected' && $list->first_approval_status == 'pending')   
                                                <td>{{ $list->patient_approval_by }}</td>
                                            @endif
                                            @if ($list->status == 'rejected' && $list->first_approval_status == 'rejected')   
                                                <td>{{ $list->first_approval_by }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>




</x-admin.layout>





