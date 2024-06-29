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
                                                @if ($test->type == "Quantitative")
                                                <td>{{ $test->from_range }} - {{ $test->to_range }}</td>
                                                @else
                                                <td>{{ $test->bioreferal }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {!! $subTests['interpretation'] !!}
                            @endforeach
                        </div>
                        <div class="card-footer text-center">
                            @if ($patient_detail->first_approval_status == 'pending')
                                <a class="btn btn-primary text-dark px-2 py-1" href="{{ route('first_verification_list') }}">Back</a>
                                <button class="approved-element btn btn-success text-dark px-2 py-1" title="approve" data-id="{{ $patient_detail->patient_id }}">Approve</button>
                                <button class="rejected-element btn btn-danger text-dark px-2 py-1" title="reject" data-id="{{ $patient_detail->patient_id }}">Reject</button>
                            @endif

                            @if ($patient_detail->first_approval_status == 'approved' && $patient_detail->second_approval_status == 'pending')
                                <a class="btn btn-primary text-dark px-2 py-1" href="{{ route('second_verification_list') }}">Back</a>
                                <button class="approved-element-new btn btn-success text-dark px-2 py-1" title="approve" data-id="{{ $patient_detail->patient_id }}">Approve</button>
                                <button class="rejected-element-new btn btn-danger text-dark px-2 py-1" title="reject" data-id="{{ $patient_detail->patient_id }}">Reject</button>
                            @endif
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

        {{-- reject model 2 --}}
        <div class="modal fade" id="reject-status-modal-new" role="dialog">
            <div class="modal-dialog" role="document">
                <form action="" id="statusRejectFormNew">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Reject</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <input type="hidden" id="patient_id_new" name="patient_id_new" value="">

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label" for="name">Remark : </label>
                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="check1" name="remarkNew[]" value="Incomplete TRF">
                                        <label class="form-check-label" for="check1">Incomplete TRF</label>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="check2" name="remarkNew[]" value="Wrong Tube Collection">
                                        <label class="form-check-label" for="check2">Wrong Tube Collection</label>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="check3" name="remarkNew[]" value="Insuffient Sample">
                                        <label class="form-check-label" for="check3">Insuffient Sample</label>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="check4" name="remarkNew[]" value="Clot Sample">
                                        <label class="form-check-label" for="check4">Clot Sample</label>
                                      </div>
                                    {{-- <textarea name="remarkNew" id="remarkNew" cols="30" rows="5"></textarea> --}}
                                    <span class="text-danger is-invalid remarkNew_err"></span>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" id="updateStatusNew" type="submit">Reject</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



</x-admin.layout>

{{-- approved status --}}

<script>
    $(".approved-element").on("click", function(e) {
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
                var url = "{{ route('firstDoctor.approve.status', ":model_id") }}";

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
                                    window.location.href = '{{ route('first_verification_list') }}';
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
    $(".rejected-element").on("click", function(e) {
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
        var url = "{{ route('firstDoctor.reject.status', ':model_id') }}";

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
                        window.location.href = '{{ route('first_verification_list') }}';
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


{{-- approved status 2 --}}

<script>
    $(".approved-element-new").on("click", function(e) {
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
                var url = "{{ route('secondDoctor.approve.status', ":model_id") }}";

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
                                    window.location.href = '{{ route('second_verification_list') }}';
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

<!-- Open reject status Modal 2-->
<script>
    $(".rejected-element-new").on("click", function(e) {
        e.preventDefault();
        var model_id = $(this).attr("data-id");
        $('#patient_id_new').val(model_id);

        $('#reject-status-modal-new').modal('show');
    });
</script>

<!-- Update reject status 2-->
<script>
    $("#statusRejectFormNew").submit(function(e) {
        e.preventDefault();
        $("#updateStatusNew").prop('disabled', true);

        var formdata = new FormData(this);
        formdata.append('_method', 'PUT');
        var model_id = $('#patient_id_new').val();
        var url = "{{ route('secondDoctor.reject.status', ':model_id') }}";

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
                        window.location.href = '{{ route('second_verification_list') }}';
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
