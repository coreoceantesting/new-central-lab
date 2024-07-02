<x-admin.layout>
    <x-slot name="title">Health Post</x-slot>
    <x-slot name="heading">Health Post</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer" style="display:none;">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h4 class="card-title">Add Health Post</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="health_post_name">Health Post Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="health_post_name" name="health_post_name" type="text" placeholder="Enter Health Post Name">
                                    <span class="text-danger is-invalid health_post_name_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="initial">Initial <span class="text-danger">*</span></label>
                                    <input class="form-control" id="initial" name="initial" type="text" placeholder="Enter Health Post Initial">
                                    <span class="text-danger is-invalid initial_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="location">Location <span class="text-danger">*</span></label>
                                    <input class="form-control" id="location" name="location" type="text" placeholder="Enter Health Post Location">
                                    <span class="text-danger is-invalid location_err"></span>
                                </div>
                            </div>
                            <div class="row mt-3" id="reference-doctor-container"></div>

                            <!-- Add More button container -->
                            <div class="col-md-4 mt-3" id="add-reference-doctor-btn-container" style="display:none;">
                                <button type="button" class="btn btn-primary" id="add-reference-doctor-btn">Add More</button>
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
                            <h4 class="card-title">Edit Health Post</h4>
                        </div>
                        <div class="card-body py-2">
                            <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="health_post_name">Health Post Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="health_post_name" name="health_post_name" type="text" placeholder="Enter Health Post Name">
                                    <span class="text-danger is-invalid health_post_name_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="initial">Initial <span class="text-danger">*</span></label>
                                    <input class="form-control" id="initial" name="initial" type="text" placeholder="Enter Health Post Initial">
                                    <span class="text-danger is-invalid initial_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="location">Location <span class="text-danger">*</span></label>
                                    <input class="form-control" id="location" name="location" type="text" placeholder="Enter Health Post Location">
                                    <span class="text-danger is-invalid location_err"></span>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div id="edit-reference-doctor-container">
                                    <!-- Reference doctor fields will be appended here -->
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary mt-2" id="edit-add-reference-doctor-btn">Add More</button>

                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" id="editSubmit">Submit</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- listing --}}
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
                                        <th>Health Post Name</th>
                                        <th>Health Post Initial</th>
                                        <th>Health Post Location</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lists as $index => $list)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $list->health_post_name }}</td>
                                            <td>{{ $list->initial }}</td>
                                            <td>{{ $list->location }}</td>
                                            <td>
                                                <button class="edit-element btn text-secondary px-2 py-1" title="Edit ward" data-id="{{ $list->id }}"><i data-feather="edit"></i></button>
                                                <button class="btn text-danger rem-element px-2 py-1" title="Delete ward" data-id="{{ $list->id }}"><i data-feather="trash-2"></i> </button>
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


{{-- Add --}}
<script>
    $("#addForm").submit(function(e) {
        e.preventDefault();
        $("#addSubmit").prop('disabled', true);

        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('health-post.store') }}',
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
                            window.location.href = '{{ route('health-post.index') }}';
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


<!-- Edit -->
<script>
    $("#buttons-datatables").on("click", ".edit-element", function(e) {
        e.preventDefault();
        var model_id = $(this).attr("data-id");
        var url = "{{ route('health-post.edit', ":model_id") }}";

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
                    $("#editForm input[name='edit_model_id']").val(data.list.id);
                    $("#editForm input[name='health_post_name']").val(data.list.health_post_name);
                    $("#editForm input[name='initial']").val(data.list.initial);
                    $("#editForm input[name='location']").val(data.list.location);
                    // Populate existing reference doctor names
                    if (data.medical_officer_list.length > 0) {
                        $.each(data.medical_officer_list, function(index, doctor) {
                            var fieldHTML = `
                                <div class="row reference-doctor-fields mt-3">
                                    <div class="col-md-4">
                                        <label class="col-form-label" for="medical_officer_name_${index}">MO (Medical Officer) Name<span class="text-danger">*</span></label>
                                        <input class="form-control" name="medical_officer_name[]" type="text" placeholder="Enter Reference Doctor Name" value="${doctor.medical_officer_name}" required>
                                        <span class="text-danger is-invalid medical_officer_name_err"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-form-label" for="contact_no_${index}">Contact No<span class="text-danger">*</span></label>
                                        <input class="form-control" name="contact_no[]" type="number" value="${doctor.contact_no}" placeholder="Enter Contact No" required>
                                        <span class="text-danger is-invalid contact_no_err"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-form-label" for="email_id_${index}">Email Id</label>
                                        <input class="form-control" name="email_id[]" type="text" value="${doctor.email_id}" placeholder="Enter Email Id">
                                        <span class="text-danger is-invalid email_id_err"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-danger remove-reference-doctor-btn mt-2">Remove</button>
                                    </div>
                                </div>
                            `;
                            $("#edit-reference-doctor-container").append(fieldHTML);
                        });
                    }
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

    // Add More Reference Doctor Button Click Handler
    $(document).on('click', '#edit-add-reference-doctor-btn', function() {
        var fieldHTML = `
                <div class="row reference-doctor-fields mt-3">
                    <div class="col-md-4">
                        <label class="col-form-label" for="medical_officer_name">MO (Medical Officer) Name<span class="text-danger">*</span></label>
                        <input class="form-control" name="medical_officer_name[]" type="text" placeholder="Enter Reference Doctor Name" required>
                        <span class="text-danger is-invalid medical_officer_name_err"></span>
                    </div>
                    <div class="col-md-4">
                        <label class="col-form-label" for="contact_no">Contact No<span class="text-danger">*</span></label>
                        <input class="form-control" name="contact_no[]" type="number" placeholder="Enter Contact No" required>
                        <span class="text-danger is-invalid contact_no_err"></span>
                    </div>
                    <div class="col-md-4">
                        <label class="col-form-label" for="email_id">Email Id</label>
                        <input class="form-control" name="email_id[]" type="text" placeholder="Enter Email Id">
                        <span class="text-danger is-invalid email_id_err"></span>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-danger remove-reference-doctor-btn mt-2">Remove</button>
                    </div>
                </div>
            `;
            $('#edit-reference-doctor-container').append(fieldHTML);
    });

    // Remove Reference Doctor Button Click Handler
    $(document).on('click', '.remove-reference-doctor-btn', function() {
        $(this).closest('.form-group').remove();
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
            var url = "{{ route('health-post.update', ":model_id") }}";
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
                                window.location.href = '{{ route('health-post.index') }}';
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
            title: "Are you sure to delete this Health Post?",
            // text: "Make sure if you have filled Vendor details before proceeding further",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((justTransfer) =>
        {
            if (justTransfer)
            {
                var model_id = $(this).attr("data-id");
                var url = "{{ route('health-post.destroy', ":model_id") }}";

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

{{-- add more functionlity for add form --}}
<script>
    $(document).ready(function() {
        // Function to add a reference doctor's name input field
        function addReferenceDoctorField() {
            var fieldHTML = `
                <div class="row reference-doctor-fields mt-3">
                    <div class="col-md-4">
                        <label class="col-form-label" for="medical_officer_name">MO (Medical Officer) Name<span class="text-danger">*</span></label>
                        <input class="form-control" name="medical_officer_name[]" type="text" placeholder="Enter Reference Doctor Name" required>
                        <span class="text-danger is-invalid medical_officer_name_err"></span>
                    </div>
                    <div class="col-md-4">
                        <label class="col-form-label" for="contact_no">Contact No<span class="text-danger">*</span></label>
                        <input class="form-control" name="contact_no[]" type="number" placeholder="Enter Contact No" required>
                        <span class="text-danger is-invalid contact_no_err"></span>
                    </div>
                    <div class="col-md-4">
                        <label class="col-form-label" for="email_id">Email Id</label>
                        <input class="form-control" name="email_id[]" type="text" placeholder="Enter Email Id">
                        <span class="text-danger is-invalid email_id_err"></span>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-danger remove-reference-doctor-btn mt-2">Remove</button>
                    </div>
                </div>
            `;
            $('#reference-doctor-container').append(fieldHTML);
        }
    
        addReferenceDoctorField(); 
        $('#add-reference-doctor-btn-container').show();
    
        // Handle click event on 'Add More' button
        $('#add-reference-doctor-btn').click(function() {
            addReferenceDoctorField();
        });
    
        // Handle click event on 'Remove' button
        $(document).on('click', '.remove-reference-doctor-btn', function() {
            $(this).closest('.reference-doctor-fields').remove();
        });
    
    });
</script>
