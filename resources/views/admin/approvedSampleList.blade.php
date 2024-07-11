<x-admin.layout>
    <x-slot name="title">Approved Sample List</x-slot>
    <x-slot name="heading">Approved Sample List</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}

        {{-- Patient listing --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-end">
                            <div class="col-md-12">
                                <form id="searchForm" class="row" method="GET" action="{{ route('approved_sample_list') }}">
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
                                        <a href="{{ route('approved_sample_list') }}" class="btn btn-primary ms-2">cancel</a>
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
                                        <th>Collection Details</th>
                                        <th>Received Details</th>
                                        <th>Approval At</th>
                                        <th>Approval By</th>
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
                                            <td>
                                                @php
                                                    $mainCategoryIds = explode(',', $list->main_category_id);
                                                    $mainCategories = \App\Models\MainCategory::whereIn('id', $mainCategoryIds)->pluck('main_category_name')->toArray();
                                                @endphp
                                                @foreach ($mainCategories as $mainCategory)
                                                    {{ $mainCategory }}<br>
                                                @endforeach
                                            </td>
                                            <td>{{ $list->date }}</td>
                                            <td>{{ $list->received_at }}</td>
                                            <td>{{ $list->patient_approval_at }}</td>
                                            <td>{{ $list->patient_approval_by }}</td>
                                            <td>
                                                <a href="{{ route('enter.patientParameter', $list->patient_id) }}" class="btn btn-primary text-dark px-2 py-1" title="Test Parameter">Enter Test Parameter</a>
                                                <button class="resampling-element btn btn-success text-dark px-2 py-1" title="ReSampling" data-id="{{ $list->patient_id }}">ReSampling</button>
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

{{-- received update status --}}
<script>
    $("#buttons-datatables").on("click", ".resampling-element", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to ReSampling this Patient Details?",
            // text: "Make sure if you have filled Vendor details before proceeding further",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((justTransfer) =>
        {
            if (justTransfer)
            {
                var model_id = $(this).attr("data-id");
                var url = "{{ route('resampling.patient', ":model_id") }}";

                $.ajax({
                    url: url.replace(':model_id', model_id),
                    type: 'POST',
                    data: {
                        '_method': "PUT",
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data, textStatus, jqXHR) {
                        if (!data.error && !data.error2) {
                            swal("Success!", data.success, "success")
                                .then((action) => {
                                    window.location.reload();
                                });
                        } else {
                            if (data.error) {
                                swal("Error!", data.error, "error");
                            } else {
                                swal("Error!", data.error2, "error");
                            }
                        }
                    },
                    error: function(error, jqXHR, textStatus, errorThrown) {
                        swal("Error!", "Something went wrong", "error");
                    },
                });
            }
        });
    });
</script>





