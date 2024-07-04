<x-admin.layout>
    <x-slot name="title">Enter Parameter</x-slot>
    <x-slot name="heading">Enter Parameter</x-slot>
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
                            <th>Patient Name: {{$patient_detail->first_name}} {{$patient_detail->middle_name}} {{$patient_detail->last_name}}</th>
                        </table>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Report Id</th>
                                    <td>{{$patient_detail->patient_uniqe_id}}</td>
                                    <th>Patient Id</th>
                                    <td>{{$patient_detail->patient_uniqe_id}}</td>
                                </tr>
                                <tr>
                                    <th>Age</th>
                                    <td>{{$patient_detail->age}}</td>
                                    <th>Gender</th>
                                    <td>{{$patient_detail->gender}}</td>
                                </tr>
                            </thead>
                        </table>
                        <table class="table table-bordered">
                            <th>Sample Id: <img height="50" width="200" src="{{ asset('admin/images/barcodenew.jpg') }}"></th>
                        </table>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Collected At</th>
                                    <td>{{$patient_detail->health_post_name}}</td>
                                    <th>Collected On</th>
                                    <td>{{$patient_detail->date}}</td>
                                </tr>
                                <tr>
                                    <th>Received Lab</th>
                                    <td>{{$patient_detail?->labName?->lab_name}}</td>
                                    <th>Received On</th>
                                    <td>{{$patient_detail->received_at}}</td>
                                </tr>
                                <tr>
                                    <th>MO(Medical Officer) Name</th>
                                    <td>{{$patient_detail->refering_doctor_name}}</td>
                                </tr>
                            </thead>
                        </table>
                        <form id="resultsForm" action="{{ route('store.results', $patient_detail->patient_id) }}" method="POST">
                            @csrf
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
                                                    <td>
                                                        <select class="form-control" name="method_{{ $test->id }}" id="method_{{ $test->id }}" required>
                                                            <option value="">Select Method</option>
                                                            @foreach ($method_list as $list)
                                                                <option value="{{ $list->id }}" @if ($list->id == $test->method) selected @endif>
                                                                    {{ $list->method_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control type-select" name="type_{{ $test->id }}" id="type_{{ $test->id }}" required>
                                                            <option value="">Select Type</option>
                                                                <option value="Quantitative" @if ($test->type == "Quantitative") selected @endif>
                                                                    Quantitative
                                                                </option>
                                                                <option value="Cumulative" @if ($test->type == "Cumulative") selected @endif>
                                                                    Cumulative
                                                                </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="results[{{ $loop->parent->index }}][{{ $loop->index }}][test_id]" value="{{ $test->id }}">
                                                        <input type="{{ $test->type == 'Cumulative' ? 'text' : 'number' }}" class="form-control result-input" name="results[{{ $loop->parent->index }}][{{ $loop->index }}][result]" required>
                                                    </td>
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
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>




</x-admin.layout>
<script>
    document.querySelectorAll('.type-select').forEach(function(select) {
        select.addEventListener('change', function() {
            var inputField = this.closest('tr').querySelector('.result-input');
            inputField.type = this.value === 'Cumulative' ? 'text' : 'number';
        });
    });
</script>

<script>
    $("#resultsForm").submit(function(e) {
        e.preventDefault();
        // $("#submitResults").prop('disabled', true);

        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('store.results', $patient_detail->patient_id) }}',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            success: function(data)
            {
                $("#submitResults").prop('disabled', false);
                if (data.success) {
                    swal("Successful!", data.message, "success")
                        .then((action) => {
                            window.location.href = '{{ route('approved_sample_list') }}';
                        });
                } else {
                    swal("Error!", data.message, "error");
                }
            },
            statusCode: {
                422: function(responseObject, textStatus, jqXHR) {
                    $("#submitResults").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                },
                500: function(responseObject, textStatus, errorThrown) {
                    $("#submitResults").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                }
            }
        });
    });
</script>




