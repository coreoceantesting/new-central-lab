<x-admin.layout>
    <x-slot name="title">Sub Category</x-slot>
    <x-slot name="heading">Sub Category</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}


        <!-- Add Form -->
        <div class="row" id="addContainer" style="display:none;">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h4 class="card-title">Add Sub Category</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="sub_category_name">Sub Category Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="sub_category_name" name="sub_category_name" type="text" placeholder="Enter Sub Category Name">
                                    <span class="text-danger is-invalid sub_category_name_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="method">Method Name<span class="text-danger">*</span></label>
                                    <select class="form-control" name="method" id="method">
                                        <option value="">Select Method</option>
                                        @foreach ($method_list as $list)
                                            <option value="{{ $list->id }}">{{ $list->method_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid method_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="units">Units <span class="text-danger">*</span></label>
                                    <input class="form-control" id="units" name="units" type="text" placeholder="Enter Units">
                                    <span class="text-danger is-invalid units_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="bioreferal">Biological Reference Interval <span class="text-danger">*</span></label>
                                    <input class="form-control" id="bioreferal" name="bioreferal" type="text" placeholder="Enter BIO.REF Interval">
                                    <span class="text-danger is-invalid bioreferal_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="main_category">Main Category<span class="text-danger">*</span></label>
                                    <select class="form-control" name="main_category" id="main_category">
                                        <option value="">Select Main Category</option>
                                        @foreach ($main_category as $list)
                                            <option value="{{ $list->id }}">{{ $list->main_category_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid main_category_err"></span>
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
                                    <label class="col-form-label" for="sub_category_name">Sub Category Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="sub_category_name" name="sub_category_name" type="text" placeholder="Enter Sub Category Name">
                                    <span class="text-danger is-invalid sub_category_name_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="method">Method Name<span class="text-danger">*</span></label>
                                    <select class="form-control" name="method" id="method">
                                        <option value="">Select Method</option>
                                        @foreach ($method_list as $list)
                                            <option value="{{ $list->id }}">{{ $list->method_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid method_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="units">Units <span class="text-danger">*</span></label>
                                    <input class="form-control" id="units" name="units" type="text" placeholder="Enter Units">
                                    <span class="text-danger is-invalid units_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="bioreferal">Biological Reference Interval <span class="text-danger">*</span></label>
                                    <input class="form-control" id="bioreferal" name="bioreferal" type="text" placeholder="Enter BIO.REF Interval">
                                    <span class="text-danger is-invalid bioreferal_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="main_category">Main Category<span class="text-danger">*</span></label>
                                    <select class="form-control" name="main_category" id="main_category">
                                        <option value="">Select Main Category</option>
                                        @foreach ($main_category as $list)
                                            <option value="{{ $list->id }}">{{ $list->main_category_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid main_category_err"></span>
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
                                        <th>Sub Category Name</th>
                                        <th>Main Category Name</th>
                                        <th>Method Name</th>
                                        <th>Units</th>
                                        <th>Biological Reference Interval</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category_list as $index => $category)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $category->sub_category_name }}</td>
                                            <td>{{ $category->main_category_name }}</td>
                                            <td>{{ $category->method_name }}</td>
                                            <td>{{ $category->units }}</td>
                                            <td>{{ $category->bioreferal }}</td>
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


{{-- Add --}}
<script>
    $("#addForm").submit(function(e) {
        e.preventDefault();
        $("#addSubmit").prop('disabled', true);

        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('subcategories.store') }}',
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
                            window.location.href = '{{ route('subcategories.index') }}';
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
        var url = "{{ route('subcategories.edit', ":model_id") }}";

        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'GET',
            data: {
                '_token': "{{ csrf_token() }}"
            },
            success: function(data, textStatus, jqXHR) {
                editFormBehaviour();
                console.log(data);
                if (!data.error)
                {
                    $("#editForm input[name='edit_model_id']").val(data.subcategory.id);
                    $("#editForm input[name='sub_category_name']").val(data.subcategory.sub_category_name);
                    $("#editForm input[name='units']").val(data.subcategory.units);
                    $("#editForm input[name='bioreferal']").val(data.subcategory.bioreferal);
                    $("#editForm select[name='main_category']").val(data.subcategory.main_category);
                    $("#editForm select[name='method']").val(data.subcategory.method);
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
            var url = "{{ route('subcategories.update', ":model_id") }}";
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
                                window.location.href = '{{ route('subcategories.index') }}';
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
                var url = "{{ route('subcategories.destroy', ":model_id") }}";

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
