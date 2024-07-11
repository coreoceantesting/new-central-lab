<x-admin.layout>
    <x-slot name="title">Rejected Sample List</x-slot>
    <x-slot name="heading">Rejected Sample List</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}

        <style>
            .ms-choice>span{
                position: relative !important;
            }
        </style>

        {{-- Patient listing --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-end">
                            <div class="col-md-12">
                                <form id="searchForm" class="row" method="GET" action="{{ route('patient_rejected_list') }}">
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
                                        <a href="{{ route('patient_rejected_list') }}" class="btn btn-primary ms-2">cancel</a>
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
                                        <th>Sample Collection Details</th>
                                        <th>Received Details</th>
                                        <th>Approval Date & Time</th>
                                        <th>Approval By</th>
                                        <th>Rejected Remark</th>
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
                                            <td>{{ \Carbon\Carbon::parse($list->received_at)->format('Y-m-d H:i:s') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($list->patient_approval_at)->format('Y-m-d H:i:s') }}</td>
                                            <td>{{ $list->patient_approval_by }}</td>
                                            <td>{{ $list->remark }}</td>
                                            <td>
                                                <a href="{{ route('view.details', $list->patient_id) }}" class="edit-element btn btn-primary btn-sm text-dark px-2 py-1" title="View Details"><i data-feather="eye"></i></a>
                                                {{-- @if ($list->status == 'received')
                                                    <button class="approved-element btn btn-success text-dark px-2 py-1" title="approve" data-id="{{ $list->patient_id }}">Approve</button>
                                                    <button class="rejected-element btn btn-danger text-dark px-2 py-1" title="reject" data-id="{{ $list->patient_id }}">Reject</button>
                                                @endif --}}
                                            </td>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- reject model --}}
        <div class="modal fade" id="reject-status-modal" role="dialog">
            <div class="modal-dialog" role="document">
                <form action="" id="statusRejectForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Reject</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <input type="hidden" id="patient_id" name="patient_id" value="">

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label" for="name">Remark : </label>
                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="check1" name="remark[]" value="Incomplete TRF">
                                        <label class="form-check-label" for="check1">Incomplete TRF</label>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="check2" name="remark[]" value="Wrong Tube Collection">
                                        <label class="form-check-label" for="check2">Wrong Tube Collection</label>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="check3" name="remark[]" value="Insuffient Sample">
                                        <label class="form-check-label" for="check3">Insuffient Sample</label>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="check4" name="remark[]" value="Clot Sample">
                                        <label class="form-check-label" for="check4">Clot Sample</label>
                                      </div>
                                    {{-- <textarea name="remark" id="remark" cols="30" rows="5"></textarea> --}}
                                    <span class="text-danger is-invalid remark_err"></span>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" id="updateStatus" type="submit">Reject</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>




</x-admin.layout>

<!-- Latest compiled and minified JavaScript -->
<script src="https://unpkg.com/multiple-select@1.7.0/dist/multiple-select.min.js"></script>

{{-- approved status --}}
<script>
    $("#buttons-datatables").on("click", ".approved-element", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to approve this Patient Details?",
            // text: "Make sure if you have filled Vendor details before proceeding further",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((justTransfer) =>
        {
            if (justTransfer)
            {
                var model_id = $(this).attr("data-id");
                var url = "{{ route('approve.status', ":model_id") }}";

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

<!-- Open reject status Modal-->
<script>
    $("#buttons-datatables").on("click", ".rejected-element", function(e) {
        e.preventDefault();
        var model_id = $(this).attr("data-id");
        $('#patient_id').val(model_id);

        $('#reject-status-modal').modal('show');
    });
</script>

<!-- Update reject status -->
<script>
    $("#statusRejectForm").submit(function(e) {
        e.preventDefault();
        $("#updateStatus").prop('disabled', true);

        var formdata = new FormData(this);
        formdata.append('_method', 'PUT');
        var model_id = $('#patient_id').val();
        var url = "{{ route('reject.status', ':model_id') }}";

        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            success: function(data) {
                $("#updateStatus").prop('disabled', false);
                if (!data.error2)
                    swal("Successful!", data.success, "success")
                    .then((action) => {
                        $("#reject-status-modal").modal('hide');
                        window.location.reload();
                    });
                else
                    swal("Error!", data.error2, "error");
            },
            statusCode: {
                422: function(responseObject, textStatus, jqXHR) {
                    $("#updateStatus").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                },
                500: function(responseObject, textStatus, errorThrown) {
                    $("#updateStatus").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                }
            }
        });

        function resetErrors() {
            var form = document.getElementById('statusRejectForm');
            var data = new FormData(form);
            for (var [key, value] of data) {
                $('.' + key + '_err').text('');
                $('#' + key).removeClass('is-invalid');
                $('#' + key).addClass('is-valid');
            }
        }

        function printErrMsg(msg) {
            $.each(msg, function(key, value) {
                $('.' + key + '_err').text(value);
                $('#' + key).addClass('is-invalid');
                $('#' + key).removeClass('is-valid');
            });
        }

    });
</script>
