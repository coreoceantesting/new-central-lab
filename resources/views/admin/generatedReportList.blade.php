<x-admin.layout>
    <x-slot name="title">Generated Report List</x-slot>
    <x-slot name="heading">Generated Report List</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}

        {{-- Patient listing --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-end">
                            <div class="col-md-12">
                                <form id="searchForm" class="row" method="GET" action="{{ route('generated_report_list') }}">
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
                                        <a href="{{ route('generated_report_list') }}" class="btn btn-primary ms-2">cancel</a>
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
                                        <th>PatientID</th>
                                        <th>Patient Name</th>
                                        <th>Patient Age</th>
                                        <th>Lab Name</th>
                                        <th>Test Name</th>
                                        <th>Sample Collection Detail</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patient_list as $index => $list)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $list->patient_uniqe_id }}</td>
                                            <td>{{ $list->first_name }} {{ $list->middle_name }} {{ $list->last_name }}</td>
                                            <td>{{ $list->age }}</td>
                                            <td>{{ $list->lab_name }}</td>
                                            <td>{{ $list->main_category_name }}</td>
                                            <td>{{ $list->date }}</td>
                                            <td>
                                                <a href="{{ url('/testreport',$list->patient_id) }}" target="blank" class="btn btn-primary text-dark px-2 py-1" title="Test Parameter">View Report</a>
                                                <button class="btn btn-warning text-dark px-2 py-1 sendsms" data-id="{{ $list->patient_id }}" title="Send SMS">Send SMS</button>
                                            </td>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>




</x-admin.layout>

<script>
    $(document).ready(function() {
        $('.sendsms').on('click', function() {
            var patientId = $(this).data('id');

            $.ajax({
                url: "{{ route('send.sms') }}", // Define this route in your web.php
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    patient_id: patientId
                },
                success: function(response) {
                    if (response.success) {
                        alert('SMS sent successfully!');
                    } else {
                        alert('Failed to send SMS.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('An error occurred while sending the SMS.');
                }
            });
        });
    });
</script>





