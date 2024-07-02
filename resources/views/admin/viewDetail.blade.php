<x-admin.layout>
    <x-slot name="title">View Patient Detail</x-slot>
    <x-slot name="heading">View Patient Detail</x-slot>

    <div class="row" id="viewContainer">
        <div class="col">
            <form class="form-horizontal form-bordered" method="post" id="editForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">View Patient Details</h4>
                    </div>
                    <div class="card-body py-2">
                        <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                        <div class="mb-3 row">

                            <div class="col-md-4">
                                <label class="col-form-label" for="first_name">First Name <span class="text-danger">*</span></label>
                                <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Enter Patient First Name" value="{{ $details->first_name }}" readonly>
                                <span class="text-danger is-invalid first_name_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="middle_name">Middle Name <span class="text-danger">*</span></label>
                                <input class="form-control" id="middle_name" name="middle_name" type="text" placeholder="Enter Patient Middle Name" value="{{ $details->middle_name }}" readonly>
                                <span class="text-danger is-invalid middle_name_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="last_name">Last Name <span class="text-danger">*</span></label>
                                <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Enter Patient Last Name" value="{{ $details->last_name }}" readonly>
                                <span class="text-danger is-invalid last_name_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="mob_no">Mobile No <span class="text-danger">*</span></label>
                                <input class="form-control" id="mob_no" name="mob_no" type="number" placeholder="Enter Mobile No" value="{{ $details->mob_no }}" readonly>
                                <span class="text-danger is-invalid mob_no_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="aadhar_no">Aadhar Card Number <span class="text-danger">*</span></label>
                                <input class="form-control" id="aadhar_no" name="aadhar_no" type="number" placeholder="Enter Aadhar Card No" value="{{ $details->aadhar_no }}" readonly>
                                <span class="text-danger is-invalid aadhar_no_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="age">Age <span class="text-danger">*</span></label>
                                <input class="form-control" id="age" name="age" type="number" placeholder="Enter Age" value="{{ $details->age }}" readonly>
                                <span class="text-danger is-invalid age_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="gender">Select Gender <span class="text-danger">*</span></label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="" disabled>Select Gender</option>
                                    <option value="Male" @if($details->gender == "Male") selected  @endif disabled>Male</option>
                                    <option value="Female" @if($details->gender == "Female") selected  @endif disabled>Female</option>
                                </select>
                                <span class="text-danger is-invalid gender_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="address">Address</label>
                                <textarea class="form-control" name="address" id="address" cols="30" rows="2" placeholder="Enter Address" readonly>{{ $details->address }}</textarea>
                                <span class="text-danger is-invalid address_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="tests">Select Test <span class="text-danger">*</span></label>
                                <select class="form-control multiple-select new" name="tests[]" id="tests" multiple>
                                    @foreach($mainCategories as $mainCategory)
                                        <optgroup label="{{$mainCategory->main_category_name}}">
                                            @foreach($subCategories as $subCategory)
                                                @if($subCategory->main_category === $mainCategory->id)
                                                    <option value="{{ $subCategory->id }}" @if(in_array($subCategory->id, $selected_tests)) selected @endif disabled>{{ $subCategory->sub_category_name }}</option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid gender_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="lab">Select Lab <span class="text-danger">*</span></label>
                                <select class="form-control" name="lab" id="lab">
                                    <option value="" disabled>Select Lab</option>
                                    @foreach ($lab_list as $list)
                                        <option value="{{ $list->id}}" @if($details->lab == $list->id) selected  @endif disabled>{{ $list->lab_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger is-invalid gender_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="refering_doctor_name">MO(Medical Officer) Name <span class="text-danger">*</span></label>
                                <input class="form-control" id="refering_doctor_name" name="refering_doctor_name" type="text" placeholder="Enter Doctor Name" value="{{ $details->refering_doctor_name }}" readonly>
                                <span class="text-danger is-invalid refering_doctor_name_err"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="date">Date <span class="text-danger">*</span></label>
                                <input class="form-control" id="date" name="date" type="datetime-local" value="{{ $details->date }}" readonly>
                                <span class="text-danger is-invalid date_err"></span>
                            </div>

                        </div>

                    </div>
                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-warning">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>




</x-admin.layout>

<!-- Latest compiled and minified JavaScript -->
<script src="https://unpkg.com/multiple-select@1.7.0/dist/multiple-select.min.js"></script>

<script>
    $(function () {
      $('.multiple-select').multipleSelect()
    })
</script>