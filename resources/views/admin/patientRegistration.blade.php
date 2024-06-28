<x-admin.layout>
    <x-slot name="title">Patient Registration</x-slot>
    <x-slot name="heading">Patient Registration</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}

        <style>
            .ms-choice>span{
                position: relative !important;
            }
        </style>
        <!-- Add Form -->
        <div class="row" id="addContainer" style="display:none;">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h4 class="card-title">Add Patient Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">

                                <div class="col-md-4">
                                    <label class="col-form-label" for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Enter Patient First Name">
                                    <span class="text-danger is-invalid first_name_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="middle_name">Middle Name </label>
                                    <input class="form-control" id="middle_name" name="middle_name" type="text" placeholder="Enter Patient Middle Name">
                                    <span class="text-danger is-invalid middle_name_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="last_name">Last Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Enter Patient Last Name">
                                    <span class="text-danger is-invalid last_name_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="mob_no">Mobile No <span class="text-danger">*</span></label>
                                    <input class="form-control" id="mob_no" name="mob_no" type="number" placeholder="Enter Mobile No">
                                    <span class="text-danger is-invalid mob_no_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="aadhar_no">Aadhar Card Number </label>
                                    <input class="form-control" id="aadhar_no" name="aadhar_no" type="number" placeholder="Enter Aadhar Card No">
                                    <span class="text-danger is-invalid aadhar_no_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="age">Age <span class="text-danger">*</span></label>
                                    <input class="form-control" id="age" name="age" type="number" placeholder="Enter Age">
                                    <span class="text-danger is-invalid age_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="gender">Select Gender <span class="text-danger">*</span></label>
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <span class="text-danger is-invalid gender_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="address">Address</label>
                                    <textarea class="form-control" name="address" id="address" cols="30" rows="2" placeholder="Enter Address"></textarea>
                                    <span class="text-danger is-invalid address_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="tests">Select Test <span class="text-danger">*</span></label>
                                    <select class="form-control multiple-select" name="tests[]" id="tests" multiple>
                                        {{-- <option value="">Select Tests</option> --}}
                                        @foreach($mainCategories as $mainCategory)
                                            <optgroup label="{{ $mainCategory->main_category_name }}">
                                                @foreach($subCategories as $subCategory)
                                                    @if($subCategory->main_category === $mainCategory->id)
                                                        <option value="{{ $subCategory->id }}">{{ $subCategory->sub_category_name }}</option>
                                                    @endif
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid tests_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="lab">Select Lab <span class="text-danger">*</span></label>
                                    <div id='labnames'>

                                    </div>
                                    <span class="text-danger is-invalid lab_err"></span>
                                </div>

                                {{-- <div class="col-md-4">
                                    <label class="col-form-label" for="refering_doctor_name">Refering Doctor Name </label>
                                    <input class="form-control" id="refering_doctor_name" name="refering_doctor_name" type="text" placeholder="Enter Doctor Name">
                                    <span class="text-danger is-invalid refering_doctor_name_err"></span>
                                </div> --}}

                                <div class="col-md-4">
                                    <label class="col-form-label" for="refering_doctor_name">Refering Doctor Name </label>
                                    {{-- <input class="form-control" id="refering_doctor_name" name="refering_doctor_name" type="text" placeholder="Enter Doctor Name"> --}}
                                    <select class="form-control multiple-select" name="refering_doctor_name[]" id="refering_doctor_name" multiple>
                                        @foreach ($referance_doc_list as $item)
                                            <option value="{{ $item->reference_doctor_name }}">{{ $item->reference_doctor_name }}</option>    
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid refering_doctor_name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="date">Sample Collection Date & Time <span class="text-danger">*</span></label>
                                    <input class="form-control" id="date" name="date" type="datetime-local">
                                    <span class="text-danger is-invalid date_err"></span>
                                </div>

                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="addSubmit">Submit</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        {{-- Edit Form --}}
        <div class="row" id="editContainer" style="display:none;">
            <div class="col">
                <form class="form-horizontal form-bordered" method="post" id="editForm">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Patient Details</h4>
                        </div>
                        <div class="card-body py-2">
                            <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                            <div class="mb-3 row">

                                <div class="col-md-4">
                                    <label class="col-form-label" for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Enter Patient First Name">
                                    <span class="text-danger is-invalid first_name_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="middle_name">Middle Name </label>
                                    <input class="form-control" id="middle_name" name="middle_name" type="text" placeholder="Enter Patient Middle Name">
                                    <span class="text-danger is-invalid middle_name_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="last_name">Last Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Enter Patient Last Name">
                                    <span class="text-danger is-invalid last_name_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="mob_no">Mobile No <span class="text-danger">*</span></label>
                                    <input class="form-control" id="mob_no" name="mob_no" type="number" placeholder="Enter Mobile No">
                                    <span class="text-danger is-invalid mob_no_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="aadhar_no">Aadhar Card Number </label>
                                    <input class="form-control" id="aadhar_no" name="aadhar_no" type="number" placeholder="Enter Aadhar Card No">
                                    <span class="text-danger is-invalid aadhar_no_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="age">Age <span class="text-danger">*</span></label>
                                    <input class="form-control" id="age" name="age" type="number" placeholder="Enter Age">
                                    <span class="text-danger is-invalid age_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="gender">Select Gender <span class="text-danger">*</span></label>
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <span class="text-danger is-invalid gender_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="address">Address</label>
                                    <textarea class="form-control" name="address" id="address" cols="30" rows="2" placeholder="Enter Address"></textarea>
                                    <span class="text-danger is-invalid address_err"></span>
                                </div>
                                <div class="col-md-4 edit_test">

                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="lab">Select Lab <span class="text-danger">*</span></label>
                                    <select class="form-control" name="lab" id="lab" disabled>
                                        <option value="">Select Lab</option>
                                        @foreach ($lab_list as $list)
                                            <option value="{{ $list->id}}">{{ $list->lab_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid gender_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="refering_doctor_name">Refering Doctor Name </label>
                                    <input class="form-control" id="refering_doctor_name" name="refering_doctor_name" type="text" placeholder="Enter Doctor Name">
                                    <span class="text-danger is-invalid refering_doctor_name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="date">Sample Collection Date & Time <span class="text-danger">*</span></label>
                                    <input class="form-control" id="date" name="date" type="datetime-local">
                                    <span class="text-danger is-invalid date_err"></span>
                                </div>

                            </div>

                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" id="editSubmit">Submit</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Patient listing --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="">
                                    <button id="addToTable" class="btn btn-primary">Add <i class="fa fa-plus"></i></button>
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
                                            <td>
                                                <button class="edit-element btn text-secondary px-2 py-1" title="Edit ward" data-id="{{ $list->patient_id }}"><i data-feather="edit"></i></button>
                                                <button class="btn text-danger rem-element px-2 py-1" title="Delete ward" data-id="{{ $list->patient_id }}"><i data-feather="trash-2"></i> </button>
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

<!-- Latest compiled and minified JavaScript -->
<script src="https://unpkg.com/multiple-select@1.7.0/dist/multiple-select.min.js"></script>

{{-- Current Date & Time --}}
<script>
    const now = new Date();
    const year = now.getFullYear();
    const month = (now.getMonth() + 1).toString().padStart(2, '0');
    const day = now.getDate().toString().padStart(2, '0');
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');

    const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
    document.getElementById('date').value = formattedDateTime;
</script>

{{-- Add --}}
<script>
    $("#addForm").submit(function(e) {
        e.preventDefault();
        $("#addSubmit").prop('disabled', true);

        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('store.patient') }}',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            success: function(data)
            {
                $("#addSubmit").prop('disabled', false);
                if (!data.error2)
                    swal("Successful!", data.success, "success")
                        .then((action) => {
                            window.location.href = '{{ route('register.patient') }}';
                        });
                else
                    swal("Error!", data.error2, "error");
            },
            statusCode: {
                422: function(responseObject, textStatus, jqXHR) {
                    $("#addSubmit").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                },
                500: function(responseObject, textStatus, errorThrown) {
                    $("#addSubmit").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                }
            }
        });

    });
</script>

<script>
    $(document).ready(function() {
        $('#tests').change(function() {
            var selectedTests = $(this).val();
            if (selectedTests.length > 0) {
                $.ajax({
                    url: '{{ route("get.labs") }}',
                    method: 'POST',
                    data: {
                        testIds: selectedTests,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var labDiv = $('#labnames');
                        labDiv.empty(); // Clear previous lab names

                        if (response.labs.length > 0) {
                            response.labs.forEach(function(lab) {
                                labDiv.append('<p>' + lab.lab_name + '</p>');
                            });
                        } else {
                            labDiv.append('<p>No labs found</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            } else {
                $('#labnames').empty();
            }
        });
    });
</script>


<!-- Edit -->
<script>
    $("#buttons-datatables").on("click", ".edit-element", function(e) {
        e.preventDefault();
        var model_id = $(this).attr("data-id");
        var url = "{{ route('edit.patient', ":model_id") }}";

        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'GET',
            data: {
                '_token': "{{ csrf_token() }}"
            },
            success: function(data, textStatus, jqXHR) {
                editFormBehaviour();
                if (!data.error)
                {
                    $("#editForm input[name='edit_model_id']").val(data.details.patient_id);
                    $("#editForm input[name='first_name']").val(data.details.first_name);
                    $("#editForm input[name='middle_name']").val(data.details.middle_name);
                    $("#editForm input[name='last_name']").val(data.details.last_name);
                    $("#editForm input[name='mob_no']").val(data.details.mob_no);
                    $("#editForm input[name='aadhar_no']").val(data.details.aadhar_no);
                    $("#editForm input[name='age']").val(data.details.age);
                    $("#editForm select[name='gender']").val(data.details.gender);
                    $("#editForm textarea[name='address']").val(data.details.address);
                    // $("#editForm select[name='tests']").val(data.details.tests);
                    $('.edit_test').html(data.html);
                    $('.multiple-select').multipleSelect()
                    $("#editForm select[name='lab']").val(data.details.lab);
                    $("#editForm input[name='refering_doctor_name']").val(data.details.refering_doctor_name);
                    $("#editForm input[name='date']").val(data.details.date);
                }
                else
                {
                    alert(data.error);
                }
            },
            error: function(error, jqXHR, textStatus, errorThrown) {
                alert("Some thing went wrong");
            },
        });
    });
</script>


<!-- Update -->
<script>
    $(document).ready(function() {
        $("#editForm").submit(function(e) {
            e.preventDefault();
            $("#editSubmit").prop('disabled', true);
            var formdata = new FormData(this);
            formdata.append('_method', 'PUT');
            var model_id = $('#edit_model_id').val();
            var url = "{{ route('update.patient', ":model_id") }}";
            //
            $.ajax({
                url: url.replace(':model_id', model_id),
                type: 'POST',
                data: formdata,
                contentType: false,
                processData: false,
                success: function(data)
                {
                    $("#editSubmit").prop('disabled', false);
                    if (!data.error2)
                        swal("Successful!", data.success, "success")
                            .then((action) => {
                                window.location.href = '{{ route('register.patient') }}';
                            });
                    else
                        swal("Error!", data.error2, "error");
                },
                statusCode: {
                    422: function(responseObject, textStatus, jqXHR) {
                        $("#editSubmit").prop('disabled', false);
                        resetErrors();
                        printErrMsg(responseObject.responseJSON.errors);
                    },
                    500: function(responseObject, textStatus, errorThrown) {
                        $("#editSubmit").prop('disabled', false);
                        swal("Error occured!", "Something went wrong please try again", "error");
                    }
                }
            });

        });
    });
</script>


<!-- Delete -->
<script>
    $("#buttons-datatables").on("click", ".rem-element", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to delete this Patient Details?",
            // text: "Make sure if you have filled Vendor details before proceeding further",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((justTransfer) =>
        {
            if (justTransfer)
            {
                var model_id = $(this).attr("data-id");
                var url = "{{ route('delete.patient', ":model_id") }}";

                $.ajax({
                    url: url.replace(':model_id', model_id),
                    type: 'POST',
                    data: {
                        '_method': "DELETE",
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
<script>
    $(function () {
      $('.multiple-select').multipleSelect()
    })
</script>
