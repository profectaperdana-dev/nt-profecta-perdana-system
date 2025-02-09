@extends('layouts.master')
@section('content')
    @push('css')
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="font-weight-bold">{{ $title }}</h3>
                    <h6 class="font-weight-normal mb-0 breadcrumb-item active">
                        {{ $title }}
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Create Data</h5>
                        <hr class="bg-primary">
                    </div>
                    <div class="card-body">
                        <form class="form-label-left input_mask" method="post" action="{{ url('/asset') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-md-12">

                                    <div class=" row">
                                        <div class="form-group col-md-4">
                                            <label class="font-weight-bold">Category of Asset</label>
                                            <select name="asset_category"
                                                class="form-control category-cust @error('asset_category') is-invalid @enderror"
                                                required>
                                                <option value="">Choose Category of Asset</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('asset_category')
                                                <small class="text-danger">{{ $message }}.</small>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="font-weight-bold">Name of Asset</label>
                                            <input type="text"
                                                class="form-control {{ $errors->first('asset_name') ? ' is-invalid' : '' }}"
                                                name="asset_name" placeholder="Enter Name of Asset" required>
                                            @error('asset_name')
                                                <small class="text-danger">{{ $message }}.</small>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="font-weight-bold">Amount</label>
                                            <input type="number"
                                                class="form-control {{ $errors->first('amount') ? ' is-invalid' : '' }}"
                                                name="amount" placeholder="Enter Amount of Asset" required>
                                            @error('amount')
                                                <small class="text-danger">{{ $message }}.</small>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class=" row">
                                        <div class="form-group col-md-4">
                                            <label class="font-weight-bold">Lifetime (In Month)</label>
                                            <input type="number"
                                                class="form-control {{ $errors->first('lifetime') ? ' is-invalid' : '' }}"
                                                name="lifetime" placeholder="Enter Lifetime of Asset" required>
                                            @error('lifetime')
                                                <small class="text-danger">{{ $message }}.</small>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="font-weight-bold">Year of Acquisition</label>
                                            <input type="date"
                                                class="form-control  {{ $errors->first('acquisition_year') ? ' is-invalid' : '' }}"
                                                name="acquisition_year" required>
                                            @error('acquisition_year')
                                                <small class="text-danger">{{ $message }}.</small>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="font-weight-bold">Cost of Acquisition</label>
                                            <input type="text"
                                                class="form-control  total {{ $errors->first('acquisition_cost') ? ' is-invalid' : '' }}"
                                                placeholder="Enter Cost of Acquisition">
                                            <input type="hidden" name="acquisition_cost">
                                            @error('acquisition_cost')
                                                <small class="text-danger">{{ $message }}.</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="font-weight-bold">Maintenance Last Date</label>
                                            <input type="date"
                                                class="form-control start_date {{ $errors->first('service_date') ? ' is-invalid' : '' }}"
                                                placeholder="" name="service_date">
                                            @error('service_date')
                                                <small class="text-danger">{{ $message }}.</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="font-weight-bold">Maintenance Distance</label>
                                            <input type="number"
                                                class="form-control days {{ $errors->first('range') ? ' is-invalid' : '' }}"
                                                placeholder="Enter Maintenance Distance" name="range">
                                            @error('range')
                                                <small class="text-danger">{{ $message }}.</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="font-weight-bold">Maintenance Next Date</label>
                                            <input type="text" readonly
                                                class="form-control end_date {{ $errors->first('next_service') ? ' is-invalid' : '' }}"
                                                placeholder="" name="next_service">
                                            @error('next_service')
                                                <small class="text-danger">{{ $message }}.</small>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <button type="reset" class="btn btn-warning"
                                                data-dismiss="modal">Reset</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->
    @push('scripts')
        <script src="{{ asset('js/date_convert.js') }}"></script>
        <script>
            $(document).ready(function() {
                $(document).on('submit', 'form', function() {
                    var form = $(this);
                    var button = form.find('button[type="submit"]');
                    // console.log(form.html());

                    if (form[0].checkValidity()) { // check if form has input values
                        button.prop('disabled', true);

                    }
                });
                $('.days').on('input', function() {
                    let start_date = $('.start_date').val();
                    let days = $(this).val();
                    let end_date = new Date(new Date(start_date).setDate(new Date(start_date)
                        .getDate() + parseInt(days)));
                    $('.end_date').val(convertDate(end_date));
                })
                $('.total').on('keyup', function() {
                    var selection = window.getSelection().toString();
                    if (selection !== '') {
                        return;
                    }
                    // When the arrow keys are pressed, abort.
                    if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
                        return;
                    }
                    var $this = $(this);
                    // Get the value.
                    var input = $this.val();
                    var input = input.replace(/[\D\s\._\-]+/g, "");
                    input = input ? parseInt(input, 10) : 0;
                    $this.val(function() {
                        return (input === 0) ? "" : input.toLocaleString("id-ID");
                    });
                    $this.next().val(input);
                });
            });
        </script>
    @endpush
@endsection
