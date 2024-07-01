<x-admin.layout>
    <x-slot name="title">Register Patient</x-slot>
    <x-slot name="heading">Register Patient</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}

        <style>
            .ms-choice>span{
                position: relative !important;
            }
        </style>
        <!-- Add Form -->
        <div class="row" id="addContainer">
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
                                    <label class="col-form-label" for="lab">Labs <span class="text-danger">*</span></label>
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
                                    <label class="col-form-label" for="refering_doctor_name">Health Post MO Name</label>
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
                            window.location.href = '{{ route('register.patient.list') }}';
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

<script>
    $(function () {
      $('.multiple-select').multipleSelect()
    })
</script>