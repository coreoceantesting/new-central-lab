<x-admin.layout>
    <x-slot name="title">Edit Patient</x-slot>
    <x-slot name="heading">Edit Patient</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}

    {{-- Edit Form --}}
    <div class="row" id="editContainer">
        <div class="col">
            <form class="form-horizontal form-bordered" method="post" id="editForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Patient Details</h4>
                    </div>
                    <div class="card-body py-2">
                        <input type="hidden" id="edit_model_id" name="edit_model_id" value="{{ $details->patient_id }}">
                        <div class="mb-3 row">

                            <div class="col-md-4">
                                <label class="col-form-label" for="first_name">First Name <span class="text-danger">*</span></label>
                                <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Enter Patient First Name" value="{{ $details->first_name }}">
                                <span class="text-danger is-invalid first_name_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="middle_name">Middle Name </label>
                                <input class="form-control" id="middle_name" name="middle_name" type="text" placeholder="Enter Patient Middle Name" value="{{ $details->middle_name }}">
                                <span class="text-danger is-invalid middle_name_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="last_name">Last Name <span class="text-danger">*</span></label>
                                <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Enter Patient Last Name" value="{{ $details->last_name }}">
                                <span class="text-danger is-invalid last_name_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="mob_no">Mobile No <span class="text-danger">*</span></label>
                                <input class="form-control" id="mob_no" name="mob_no" type="number" placeholder="Enter Mobile No" value="{{ $details->mob_no }}">
                                <span class="text-danger is-invalid mob_no_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="aadhar_no">Aadhar Card Number </label>
                                <input class="form-control" id="aadhar_no" name="aadhar_no" type="number" placeholder="Enter Aadhar Card No" value="{{ $details->aadhar_no }}">
                                <span class="text-danger is-invalid aadhar_no_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="age">Age <span class="text-danger">*</span></label>
                                <input class="form-control" id="age" name="age" type="number" placeholder="Enter Age" value="{{ $details->age }}">
                                <span class="text-danger is-invalid age_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="gender">Select Gender <span class="text-danger">*</span></label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male" @if($details->gender == 'Male') selected @endif>Male</option>
                                    <option value="Female" @if($details->gender == 'Female') selected @endif>Female</option>
                                </select>
                                <span class="text-danger is-invalid gender_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="address">Address</label>
                                <textarea class="form-control" name="address" id="address" cols="30" rows="2" placeholder="Enter Address">{{ $details->address }}</textarea>
                                <span class="text-danger is-invalid address_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="tests">Select Test <span class="text-danger">*</span></label>
                                <select class="form-control multiple-select new" name="tests[]" id="tests" multiple>
                                    @foreach($mainCategories as $mainCategory)
                                        <optgroup label="{{ $mainCategory->main_category_name }}">
                                            @foreach($subCategories as $subCategory)
                                                @if($subCategory->main_category === $mainCategory->id)
                                                    <option value="{{ $subCategory->id }}" @if(in_array($subCategory->id, $selected_tests)) selected @endif>
                                                        {{ $subCategory->sub_category_name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid gender_err"></span>

                            </div>

                            {{-- <div class="col-md-4">
                                <label class="col-form-label" for="lab">Labs <span class="text-danger">*</span></label>
                                <div id='labnames'>

                                </div>
                                <span class="text-danger is-invalid lab_err"></span>
                            </div> --}}

                            <div class="col-md-4">
                                <label class="col-form-label" for="lab">Select Lab <span class="text-danger">*</span></label>
                                <select class="form-control" name="lab" id="lab" disabled>
                                    <option value="">Select Lab</option>
                                    @foreach ($lab_list as $list)
                                        <option value="{{ $list->id }}" @if($details->lab == $list->id) selected @endif>{{ $list->lab_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid gender_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="refering_doctor_name">Health Post MO Name</label>
                                <select class="form-control multiple-select" name="refering_doctor_name[]" id="refering_doctor_name" multiple>
                                    @foreach($referance_doc_list as $list)
                                        <option value="{{ $list->medical_officer_name }}" @if(in_array($list->medical_officer_name, $selected_doc)) selected @endif>
                                            {{ $list->medical_officer_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid refering_doctor_name_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="date">Sample Collection Date & Time <span class="text-danger">*</span></label>
                                <input class="form-control" id="date" name="date" type="datetime-local" value="{{ $details->date }}">
                                <span class="text-danger is-invalid date_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="date">Health Post Name <span class="text-danger">*</span></label>
                                <input class="form-control" id="health_post_name" value="{{ $details->health_post_name }}" name="health_post_name" type="text" readonly>
                                <span class="text-danger is-invalid date_err"></span>
                            </div>

                        </div>

                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" id="editSubmit">Submit</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                        <a href="{{ route('register.patient.list') }}" class="btn btn-warning">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-admin.layout>

<!-- Latest compiled and minified JavaScript -->
<script src="https://unpkg.com/multiple-select@1.7.0/dist/multiple-select.min.js"></script>

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
                                window.location.href = '{{ route('register.patient.list') }}';
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

{{-- multiselect --}}
<script>
    $(function () {
      $('.multiple-select').multipleSelect()
    })
</script>

{{-- on change of test fetch lab name --}}
<script>
    $(document).ready(function() {

            var selectedTests = $('#tests').val();
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