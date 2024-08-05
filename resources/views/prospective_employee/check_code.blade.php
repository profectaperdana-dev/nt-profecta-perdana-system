@extends('prospective_employee.master')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="font-weight-bold"> </h3>
                    <h6 class="font-weight-normal mb-0 breadcrumb-item active">
                    </h6>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>{{ $title }}</h5>
                        <hr class="bg-primary">
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="post"
                            action="{{ url('prospective_employees/verification_code') }}" enctype="multipart/form-data"
                            id="">
                            @csrf
                            <div class="form-group">
                                <label for="validationCustom01">Kode Verifikasi</label>
                                <input class="form-control" data-v-min-length="6" data-v-max-length="6"
                                    id="validationCustom01" type="text" name="code" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary form-control text-white">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid Ends-->
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>
        <script>
            $(function() {

                let validator = $('form.needs-validation').jbvalidator({
                    errorMessage: true,
                    successClass: true,
                    language: "https://emretulek.github.io/jbvalidator/dist/lang/en.json"
                });
                //reload instance after dynamic element is added
                validator.reload();
            })
        </script>
    @endpush
@endsection
