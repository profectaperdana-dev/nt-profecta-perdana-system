@extends('layouts.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/date-picker.css') }}">
        @include('report.style')

        <style>
            .table {
                background-color: rgba(211, 225, 222, 255);
                -webkit-print-color-adjust: exact;
            }
        </style>
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="font-weight-bold">{{ $title }}</h3>
                    {{-- <h6 class="font-weight-normal mb-0 breadcrumb-item active">Manage
                        {{ $title }} --}}
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basics"
                                class="table-sm table table-striped display expandable-table text-capitalize"
                                style="width:100%">
                                <thead>
                                    <tr class="text-center text-nowrap">
                                        <th>#</th>
                                        <th>PO Number</th>
                                        <th>Date</th>
                                        <th>Supplier</th>
                                        <th>Warehouse</th>
                                        
                                        <!--<th>Due Date</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchases as $value)
                                        <tr>
                                            <td class="text-center">

                                            </td>
                                            <td class="text-center"> <a type="button"
                                                    class="fw-bold text-success modal-btn2" href="javascript:void(0)"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#manageData{{ $value->id }}">{{ $value->order_number }}</a>
                                            </td>
                                                                                        <td class="text-center">{{ date('d F Y', strtotime($value->order_date)) }}</td>
                                            <td class="text-center text-nowrap">
                                                {{ $value->supplierBy->nama_supplier }}</td>
                                            <td class="text-center text-nowrap">
                                                {{ $value->warehouseBy->warehouses }}</td>
                                            
                                            <!--<td>{{ date('d F Y', strtotime($value->due_date)) }}</td>-->
                                            {{-- <td>{{ number_format($value->total) }}</td> --}}

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal PO --}}
    @foreach ($purchases as $item)
        {{-- PO Manage --}}
        <div class="modal fade" id="manageData{{ $item->id }}" tabindex="-1" role="dialog" data-bs-keyboard="false"
            data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Purchase Order
                            {{ $item->order_number }}</h6>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('purchase_orders/' . $item->id . '/validate') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="container-fluid">
                                <div class="col-md-12">
                                    <div class=" font-weight-bold">
                                        <div class="form-group row">
                                            <div class="col-md-4 form-group">
                                                <label>
                                                    Supplier</label>
                                                <input type="text" class="form-control" readonly
                                                    value="{{ $item->supplierBy->nama_supplier }}">
                                            </div>
                                            <div class="col-md-4 form-group mr-5">
                                                <label>Warehouse</label>
                                                <input type="text" id="warehouse" data-id="{{ $item->warehouseBy->id }}"
                                                    class="form-control" readonly
                                                    value="{{ $item->warehouseBy->warehouses }}">
                                            </div>
                                            <div class="col-md-4 form-group mr-5">
                                                <label>Order Date </label>
                                                <input class="form-control" type="text" readonly name="due_date"
                                                    value="{{ date('d F Y', strtotime($item->order_date)) }}" required>
                                                @error('due_date')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12 form-group mr-5">
                                                <label>Remarks</label>
                                                <textarea class="form-control" name="remark" id="" cols="30" rows="1" required>{{ $item->remark }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group formPo">
                                            @foreach ($item->purchaseOrderDetailsBy as $detail)
                                                <div class="form-group rounded row pt-2 mb-3 mx-auto"
                                                    style="background-color: #f0e194">
                                                    <input type="hidden" class="loop" value="{{ $loop->index }}">
                                                    <div class="form-group col-12 col-lg-5">
                                                        <label>Product</label>
                                                        <select multiple name="poFields[{{ $loop->index }}][product_id]"
                                                            class="form-control productPo" required>
                                                            @if ($detail->product_id != null)
                                                                <option value="{{ $detail->product_id }}" selected>
                                                                    {{ $detail->productBy->sub_materials->nama_sub_material . ' ' . $detail->productBy->sub_types->type_name . ' ' . $detail->productBy->nama_barang }}
                                                                </option>
                                                            @endif
                                                        </select>
                                                        @error('poFields[{{ $loop->index }}][product_id]')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6 col-md-3 form-group qtyParent">
                                                        <label>Qty</label>
                                                        <input type="number" class="form-control qtyPo" required
                                                            name="poFields[{{ $loop->index }}][qty]" id=""
                                                            value="{{ $detail->qty - $return_amount[$loop->index] }}">
                                                        @error('poFields[{{ $loop->index }}][qty]')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    @if ($loop->index == 0)
                                                        <div class="col-6 col-md-4 form-group">
                                                            <label for="">&nbsp;</label>
                                                            <a href="javascript:void(0)"
                                                                class="form-control text-white text-center addPo"
                                                                style="border:none; background-color:#276e61">+</a>
                                                        </div>
                                                    @else
                                                        <div class="col-3 col-md-2 form-group">
                                                            <label for="">&nbsp;</label>
                                                            <a href="javascript:void(0)"
                                                                class="form-control text-white text-center addPo"
                                                                style="border:none; background-color:#276e61">+</a>
                                                        </div>
                                                        <div class="col-3 col-md-2 form-group">
                                                            <label for="">&nbsp;</label>
                                                            <a href="javascript:void(0)"
                                                                class="form-control text-white text-center remPo"
                                                                style="border:none; background-color:#d94f5c">-</a>
                                                        </div>
                                                    @endif
                                                    <small class="text-danger dotDanger" hidden>Number of DOTs exceed the
                                                        item total</small>

                                                    @if ($detail->productBy->materials->nama_material == 'Tyre')
                                                        <div class="parentDot" data-index="{{ $loop->index }}">
                                                            <div class="row">
                                                                <label for="">DOT</label>
                                                                <div class="col-2 form-group">
                                                                    <input type="text"
                                                                        name="poFields[{{ $loop->index }}][0][week]"
                                                                        class="form-control text-center week"
                                                                        id="inputGroup-sizing-sm" placeholder="Week"
                                                                        aria-label="Week">
                                                                </div>
                                                                <div class="col-1 text-center form-group">
                                                                    <input type="text" class="form-control text-center"
                                                                        id="inputGroup-sizing-sm" placeholder="/"
                                                                        aria-label="/" readonly>
                                                                </div>
                                                                <div class="col-2 form-group">
                                                                    <input type="text"
                                                                        name="poFields[{{ $loop->index }}][0][year]"
                                                                        class="form-control text-center year"
                                                                        id="inputGroup-sizing-sm" placeholder="Year"
                                                                        aria-label="Year">
                                                                </div>
                                                                <div class="col-2 form-group">
                                                                    <input type="text"
                                                                        name="poFields[{{ $loop->index }}][0][qtyDot]"
                                                                        class="form-control text-center qtyDot"
                                                                        id="inputGroup-sizing-sm" value="0"
                                                                        data-product="{{ $detail->product_id }}"
                                                                        placeholder="Qty" aria-label="Qty">

                                                                </div>
                                                                <div class="col-1 form-group">
                                                                    <a href="javascript:void(0)"
                                                                        class="form-control text-white text-center addDot"
                                                                        style="border:none; background-color:#276e61">+</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Yes, Validate</button>
                            </div>
                        </form>


                    </div>

                </div>
            </div>
        </div>
        {{-- PO Manage End --}}

        {{-- PO Delete --}}
        <div class="modal fade" id="deleteData{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" action="{{ url('purchase_orders/' . $item->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('delete')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Data
                                {{ $item->order_number }}</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <h5>Are you sure delete this data ?</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit">Yes, delete
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- PO Delete End --}}
    @endforeach
    <!-- Container-fluid Ends-->
    @push('scripts')
        <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
        <script>
            $(document).ready(function() {
                var t = $('#basics').DataTable({
                    "language": {
                        "processing": `<i class="fa text-success fa-refresh fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>`,
                    },
                    "lengthChange": false,
                    "paging": false,
                    "bPaginate": false, // disable pagination
                    "bLengthChange": false, // disable show entries dropdown
                    "searching": true,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false,
                    columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: 0,
                    }, {
                        searchable: false,
                        orderable: false,
                        targets: 1,
                    }, ],
                });

                t.on('order.dt search.dt', function() {
                    let i = 1;

                    t.cells(null, 0, {
                        search: 'applied',
                        order: 'applied'
                    }).every(function(cell) {
                        this.data(i++);
                    });
                }).draw();
                $(document).on("click", ".modal-btn2", function(event) {
                    let csrf = $('meta[name="csrf-token"]').attr("content");

                    let modal_id = $(this).attr('data-bs-target');

                    $('form').submit(function(e) {
                        var form = $(this);
                        var button = form.find('button[type="submit"]');

                        if (form[0].checkValidity()) { // check if form has input values
                            button.prop('disabled', true);
                            // e.preventDefault(); // prevent form submission
                        }
                    });

                    $(modal_id).find(".supplier-select, .warehouse-select").select2({
                        width: "100%",
                    });

                    let selected_warehouse = $(modal_id).find('#warehouse').attr('data-id');
                    //Get Customer ID
                    $(modal_id).find(".productPo").select2({
                        width: "100%",
                        dropdownParent: modal_id,
                        placeholder: 'Select an option',
                        allowClear: true,
                        maximumSelectionLength: 1,
                        ajax: {
                            type: "GET",
                            url: "/products/selectByWarehouse",
                            data: function(params) {
                                return {
                                    _token: csrf,
                                    q: params.term, // search term
                                    c: selected_warehouse,
                                };
                            },
                            dataType: "json",
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(item) {
                                        return [{
                                            text: item.nama_sub_material + " " +
                                                item.type_name + " " + item
                                                .nama_barang,
                                            id: item.id,
                                        }, ];
                                    }),
                                };
                            },
                        },
                    });

                    let x = $(modal_id)
                        .find('.modal-body')
                        .find('.formPo')
                        .children('.form-group')
                        .last()
                        .find('.loop')
                        .val();
                    $(document).off("click", ".addPo");
                    $(document).on("click", ".addPo", function() {
                        ++x;
                        let form =
                            '<div class="form-group rounded row pt-2 mb-3 mx-auto" style="background-color: #f0e194">' +
                            '<div class="form-group col-12 col-lg-5">' +
                            "<label>Product</label>" +
                            '<select multiple name="poFields[' +
                            x +
                            '][product_id]" class="form-control productPo" required>' +

                            '</select>' +
                            '</div>' +
                            '<div class="col-6 col-md-3 form-group">' +
                            '<label> Qty </label> ' +
                            '<input class="form-control qtyPo" required name="poFields[' +
                            x +
                            '][qty]">' +
                            '</div>' +
                            '<div class="col-3 col-md-2 form-group">' +
                            '<label for=""> &nbsp; </label>' +
                            '<a class="form-control text-white addPo text-center"  style="border:none; background-color:#276e61">' +
                            '+ </a> ' +
                            '</div>' +
                            '<div class="col-3 col-md-2 form-group">' +
                            '<label for=""> &nbsp; </label>' +
                            '<a class="form-control text-white remPo text-center" style="border:none; background-color:#d94f5c">' +
                            '- </a> ' +
                            '</div>' +
                            ' </div>';
                        $(modal_id).find(".formPo").append(form);



                        $(modal_id).find(".productPo").select2({
                            width: "100%",
                            dropdownParent: modal_id,
                            placeholder: 'Select an option',
                            allowClear: true,
                            maximumSelectionLength: 1,
                            ajax: {
                                type: "GET",
                                url: "/products/selectByWarehouse",
                                data: function(params) {
                                    return {
                                        _token: csrf,
                                        q: params.term, // search term
                                        c: selected_warehouse,
                                    };
                                },
                                dataType: "json",
                                delay: 250,
                                processResults: function(data) {
                                    return {
                                        results: $.map(data, function(item) {
                                            return [{
                                                text: item
                                                    .nama_sub_material +
                                                    " " +
                                                    item.type_name + " " +
                                                    item
                                                    .nama_barang,
                                                id: item.id,
                                            }, ];
                                        }),
                                    };
                                },
                            },
                        });
                        $(modal_id).find('.productPo').last().select2('open');

                    });

                    //addDot
                    let y = 0;
                    $(document).off("click", ".addDot");
                    $(document).on("click", ".addDot", function() {
                        let idx = $(this).closest(".row").parent().attr('data-index');
                        ++y;
                        let formDot = `<div class="row">
                            <div class="col-2 form-group">
                                <input type="text" required name="poFields[${idx}][${y}][week]"
                                    class="form-control text-center week"
                                    id="inputGroup-sizing-sm" placeholder="Week"
                                    aria-label="Week">
                            </div>
                            <div class="col-1 text-center form-group">
                                <input type="text" class="form-control text-center"
                                    id="inputGroup-sizing-sm" placeholder="/"
                                    aria-label="/" readonly>
                            </div>
                            <div class="col-2 form-group">
                                <input type="text" required name="poFields[${idx}][${y}][year]"
                                    class="form-control text-center year"
                                    id="inputGroup-sizing-sm" placeholder="Year"
                                    aria-label="Year">
                            </div>
                            <div class="col-2 form-group">
                                <input type="text" required name="poFields[${idx}][${y}][qtyDot]"
                                    class="form-control text-center qtyDot"
                                    id="inputGroup-sizing-sm" value="0"
                                   
                                    placeholder="Qty" aria-label="Qty">
                                
                            </div>
                            <div class="col-1 form-group">
                                <a href="javascript:void(0)"
                                    class="form-control text-white text-center addDot"
                                    style="border:none; background-color:#276e61">+</a>
                            </div>
                            <div class="col-1 form-group">
                                <a href="javascript:void(0)"
                                    class="form-control text-white text-center removeDot bg-danger"
                                    style="border:none;">-</a>
                            </div>
                        </div>`;
                        $(this).closest(".row").parent().append(formDot);

                    });

                    //check QTY with DOT
                    $(modal_id).on("change", ".qtyDot", function() {
                        let qtyPo = $(this).closest(".row").parent().siblings('.qtyParent').find(
                            '.qtyPo').val();
                        let totalDot = parseInt(0);
                        $(this).closest(".row").parent().find('.qtyDot').each(function() {
                            totalDot += parseInt($(this).val());
                        });
                        if (totalDot == qtyPo) {
                            $(this).closest(".row").parent().find('.addDot').each(function() {
                                $(this).hide();
                            });

                            $(this).closest(".row").parent().siblings('.dotDanger').attr('hidden',
                                true);
                            $('button[type="submit"]').prop('disabled', false);
                        } else if (totalDot > qtyPo) {
                            $(this).closest(".row").parent().find('.addDot').each(function() {
                                $(this).hide();
                            });
                            $(this).closest(".row").parent().siblings('.dotDanger').attr('hidden',
                                false);
                            $('button[type="submit"]').prop('disabled', true);
                        } else {
                            $(this).closest(".row").parent().find('.addDot').each(function() {
                                $(this).show();
                            });
                            $(this).closest(".row").parent().siblings('.dotDanger').attr('hidden',
                                true);
                            $('button[type="submit"]').prop('disabled', false);
                        }
                    });

                    //remove Purchase Order fields
                    $(modal_id).on("click", ".remPo", function() {
                        $(this).closest(".row").remove();
                    });

                    //remove Dot
                    $(modal_id).on("click", ".removeDot", function() {
                        let thisrem = this;
                        let totalDot = parseInt(0);
                        let lastDot = $(thisrem).closest(".row").find('.qtyDot').val();
                        $(thisrem).closest(".row").parent().find('.qtyDot').each(function() {
                            totalDot += parseInt($(this).val());
                        });
                        let qtyPo = $(thisrem).closest(".row").parent().siblings('.qtyParent').find(
                            '.qtyPo').val();
                        // console.log(totalDot);
                        // console.log(qtyPo);
                        if ((totalDot - lastDot) == parseInt(qtyPo)) {
                            $(thisrem).closest(".row").parent().find('.addDot').each(function() {
                                $(this).hide();
                            });

                            $(thisrem).closest(".row").parent().siblings('.dotDanger').attr('hidden',
                                true);
                            $('button[type="submit"]').prop('disabled', false);
                        } else if ((totalDot - lastDot) > parseInt(qtyPo)) {
                            $(thisrem).closest(".row").parent().find('.addDot').each(function() {
                                $(this).hide();
                            });
                            $(thisrem).closest(".row").parent().siblings('.dotDanger').attr('hidden',
                                false);
                            $('button[type="submit"]').prop('disabled', true);
                        } else {
                            $(thisrem).closest(".row").parent().find('.addDot').each(function() {
                                $(this).show();
                            });
                            $(thisrem).closest(".row").parent().siblings('.dotDanger').attr('hidden',
                                true);
                            $('button[type="submit"]').prop('disabled', false);
                        }

                        $(thisrem).closest(".row").remove();

                    });

                    //reload total
                    $(modal_id).on('click', '.btn-reload', function() {
                        let total = 0;
                        $(modal_id).find('.productPo').each(function() {
                            let product_id = $(this).val();
                            let cost = function() {
                                let temp = 0;
                                $.ajax({
                                    async: false,
                                    context: this,
                                    type: "GET",
                                    url: "/products/selectCostDecrypted/" +
                                        product_id,
                                    dataType: "json",
                                    success: function(data) {
                                        temp = data
                                    },
                                });
                                return temp;
                            }();

                            let qty = $(this).parent().siblings().find('.qtyPo').val();
                            total = total + (cost * qty);
                            //   alert($(this).parent().siblings().find('.cekQty-edit').val());
                        });

                        $(this).closest('.row').siblings().find('.total').val('Rp. ' + Math.round(total)
                            .toLocaleString(
                                'us', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                }));

                    });
                    //   $(modal_id).on("hidden.bs.modal", function(event) {
                    //     $(modal_id).off(event);
                    //   });
                });
            });
        </script>
    @endpush
@endsection
