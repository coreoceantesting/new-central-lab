<x-admin.layout>
    <x-slot name="title">Main Category</x-slot>
    <x-slot name="heading">Main Category</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer" style="display:none;">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h4 class="card-title">Add Main Category</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="main_category_name">Main Category Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="main_category_name" name="main_category_name" type="text" placeholder="Enter Main Category Name">
                                    <span class="text-danger is-invalid main_category_name_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="initial">Initial <span class="text-danger">*</span></label>
                                    <input class="form-control" id="initial" name="initial" type="text" placeholder="Enter Lab Initial">
                                    <span class="text-danger is-invalid initial_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="type">Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="">Select Type</option>
                                        <option value="Quantitative">Quantitative</option>
                                        <option value="Cumulative">Cumulative</option>
                                    </select>
                                    <span class="text-danger is-invalid type_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="lab_id">Lab<span class="text-danger">*</span></label>
                                    <select class="form-control" name="lab_id" id="lab_id">
                                        <option value="">Select Lab</option>
                                        @foreach ($lab_list as $list)
                                            <option value="{{ $list->id }}">{{ $list->lab_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid lab_id_err"></span>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label" for="interpretation">Interpretation<span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="interpretation" name="interpretation"></textarea>
                                    <span class="text-danger is-invalid interpretation_err"></span>
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
                            <h4 class="card-title">Edit Main Category</h4>
                        </div>
                        <div class="card-body py-2">
                            <input type="hidden" id="edit_model_id" name="edit_model_id" value="">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="main_category_name">Main Category Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="main_category_name" name="main_category_name" type="text" placeholder="Enter Main Category Name">
                                    <span class="text-danger is-invalid main_category_name_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="initial">Initial <span class="text-danger">*</span></label>
                                    <input class="form-control" id="initial" name="initial" type="text" placeholder="Enter Lab Initial">
                                    <span class="text-danger is-invalid initial_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="type">Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="">Select Type</option>
                                        <option value="Quantitative">Quantitative</option>
                                        <option value="Cumulative">Cumulative</option>
                                    </select>
                                    <span class="text-danger is-invalid type_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="lab_id">Lab<span class="text-danger">*</span></label>
                                    <select class="form-control" name="lab_id" id="lab_id">
                                        <option value="">Select Lab</option>
                                        @foreach ($lab_list as $list)
                                            <option value="{{ $list->id }}">{{ $list->lab_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid lab_id_err"></span>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label" for="interpretation">Interpretation<span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="interpretation" name="interpretation"></textarea>
                                    <span class="text-danger is-invalid interpretation_err"></span>
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
                                        <th>Category Name</th>
                                        <th>Lab Name</th>
                                        <th>Category Initial</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($main_category as $index => $category)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $category->main_category_name }}</td>
                                            <td>{{ $category->lab_name }}</td>
                                            <td>{{ $category->initial }}</td>
                                            <td>{{ $category->type }}</td>
                                            <td>
                                                <button class="edit-element btn text-secondary px-2 py-1" title="Edit ward" data-id="{{ $category->id }}"><i data-feather="edit"></i></button>
                                                <button class="btn text-danger rem-element px-2 py-1" title="Delete ward" data-id="{{ $category->id }}"><i data-feather="trash-2"></i> </button>
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


{{-- ckeditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#interpretation' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );


</script>

{{-- Add --}}
<script>
    $("#addForm").submit(function(e) {
        e.preventDefault();
        $("#addSubmit").prop('disabled', true);

        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('maincategories.store') }}',
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
                            window.location.href = '{{ route('maincategories.index') }}';
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
        var url = "{{ route('maincategories.edit', ":model_id") }}";

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
                    $("#editForm input[name='edit_model_id']").val(data.maincategory.id);
                    $("#editForm input[name='main_category_name']").val(data.maincategory.main_category_name);
                    $("#editForm select[name='type']").val(data.maincategory.type);
                    $("#editForm select[name='lab_id']").val(data.maincategory.lab_id);
                    // Initialize CKEditor for interpretation textarea
                    ClassicEditor
                        .create(document.querySelector('#editForm #interpretation'), {
                            // CKEditor configuration options
                        })
                        .then(editor => {
                            editor.setData(data.maincategory.interpretation); // Set initial data
                        })
                        .catch(error => {
                            console.error(error);
                        });
                    $("#editForm input[name='initial']").val(data.maincategory.initial);
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
            var url = "{{ route('maincategories.update', ":model_id") }}";
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
                                window.location.href = '{{ route('maincategories.index') }}';
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
            title: "Are you sure to delete this Category?",
            // text: "Make sure if you have filled Vendor details before proceeding further",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((justTransfer) =>
        {
            if (justTransfer)
            {
                var model_id = $(this).attr("data-id");
                var url = "{{ route('maincategories.destroy', ":model_id") }}";

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
    $(document).ready(function() {
        $('#main_category_name').blur(function() {
            var main_category_name = $(this).val().trim();
            if (main_category_name !== '') {
                // Send AJAX request to check if lab name already exists
                $.ajax({
                    url: '{{ route('checkMainCategoryName') }}', // Laravel route to handle the check
                    type: 'POST',
                    data: {
                        '_token': $('input[name="_token"]').val(),
                        'main_category_name': main_category_name
                    },
                    success: function(response) {
                        if (response.exists) {
                            alert('Main Category Name already exists!');
                            // Optionally, you can clear or reset the input field here
                            $('#main_category_name').val('').focus();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Error occurred while checking method name.');
                    }
                });
            }
        });
    });
</script>
