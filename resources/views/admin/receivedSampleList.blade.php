<x-admin.layout>
    <x-slot name="title">Received Sample List</x-slot>
    <x-slot name="heading">Received Sample List</x-slot>
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
                                        <th>Action</th>
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
                                            <td>{{ $list->status }}</td>
                                            <td>
                                                @if ($list->status == 'pending')
                                                <button class="received-element btn btn-primary text-dark px-2 py-1" title="Received" data-id="{{ $list->patient_id }}">Received</button>
                                                @endif
                                                @if ($list->status == 'received')
                                                    <button class="approved-element btn btn-success text-dark px-2 py-1" title="approve" data-id="{{ $list->patient_id }}">Approve</button>
                                                    <button class="rejected-element btn btn-danger text-dark px-2 py-1" title="reject" data-id="{{ $list->patient_id }}">Reject</button>
                                                @endif
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
                                    <textarea name="remark" id="remark" cols="30" rows="5"></textarea>
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

{{-- received update status --}}
<script>
    $("#buttons-datatables").on("click", ".received-element", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to Received this Patient Details?",
            // text: "Make sure if you have filled Vendor details before proceeding further",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((justTransfer) =>
        {
            if (justTransfer)
            {
                var model_id = $(this).attr("data-id");
                var url = "{{ route('received.patient', ":model_id") }}";

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
