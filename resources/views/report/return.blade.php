@extends('layouts.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/date-picker.css') }}">
        @include('report.style')
        <style>
            table.dataTable thead tr>.dtfc-fixed-left,
            table.dataTable thead tr>.dtfc-fixed-right,
            table.dataTable tfoot tr>.dtfc-fixed-left,
            table.dataTable tfoot tr>.dtfc-fixed-right {
                background-color: #c0deef !important;
            }
        </style>
    @endpush
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="font-weight-bold">{{ $title }}</h3>

                </div>
            </div>
        </div>
    </div>
    <div></div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12 xl-100">
                <div class="card">
                    {{-- <div class="card-header pb-0">
                        <h5></h5>
                    </div> --}}
                    <div class="card-body">
                        @php
                            $now = date('Y-m-d');
                        @endphp
                        <div class="form-group row col-12">
                            <div class="col-lg-6 col-12">
                                <label class="col-form-label text-end">Start Date</label>
                                <div class="input-group">
                                    <input class="datepicker-here form-control digits" data-position="bottom left"
                                        type="text" data-language="en" id="from_date" data-value="{{ date('d-m-Y') }}"
                                        name="from_date" autocomplete="off">

                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <label class="col-form-label text-end">End Date</label>
                                <div class="input-group">
                                    <input class="datepicker-here form-control digits" data-position="bottom left"
                                        type="text" data-language="en" id="to_date" data-value="{{ date('d-m-Y') }}"
                                        name="to_date" autocomplete="on">
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4 form-group">
                                <label class="col-form-label text-end">
                                    Sub Material</label>
                                <select name="" id="material" required class="form-control multiSelect" multiple>
                                    @foreach ($material_group as $row)
                                        <option value="{{ $row->id }}">{{ $row->nama_sub_material }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 col-lg-4 form-group">
                                <label class="col-form-label text-end">
                                    Material Type</label>

                                <select name="" id="type" required class="form-control" multiple>
                                </select>
                            </div>
                            <div class=" col-md-12 col-lg-4 form-group">
                                <label class="col-form-label text-end">Product</label>
                                <select name="" id="product" class="form-control" multiple>

                                </select>
                            </div>
                            <div class="col-lg-4 col-12 mb-2">
                                <label class="col-form-label text-end">Warehouse</label>
                                <div class="input-group">
                                    <select name="" id="warehouse" multiple class="form-control selectMulti">
                                        @foreach ($warehouse as $row)
                                            <option value="{{ $row->id }}">{{ $row->warehouses }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2">
                                <label class="col-form-label text-end">&nbsp;</label>
                                <div class="input-group">
                                    <button class="btn btn-primary form-control text-white" name="filter"
                                        id="filter">Filter</button>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2">
                                <label class="col-form-label text-end">&nbsp;</label>
                                <div class="input-group">
                                    <button class="btn btn-warning form-control text-white" name="refresh"
                                        id="refresh">Refresh</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table style="font-size: 10pt" id="dataTable" class="stripe row-border order-column table-sm"
                                style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Return Number</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 0px; margin-right: 0px;">Invoice Number</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 0px; margin-right: 0px;">Invoice Created By</span>
                                            </div>
                                        </th>
                                         <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Return Date</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Customer</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Area</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">District</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Return Reason</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Material</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Type</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Product</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Qty</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Discount (%)</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Discount (Rp)</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Price</span>
                                            </div>
                                        </th>
                                         <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Price Excl.</span>
                                            </div>
                                        </th>
                                         <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Total Excl.</span>
                                            </div>
                                        </th>
                                         <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">PPN</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Total</span>
                                            </div>
                                        </th>
                                        <th style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <span class="fw-bold"
                                                    style="margin-left: 10px; margin-right: 10px;">Created By</span>
                                            </div>
                                        </th>
                                        
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="text-align:right">Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                                                                <th></th>

                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <input type="text" hidden value="{{ $ }}"> --}}
    <!-- Container-fluid Ends-->
    @push('scripts')
        <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
        {{-- <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script> --}}
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
        <script
            src="https://cdn.jsdelivr.net/gh/ashl1/datatables-rowsgroup@fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js">
        </script>
        <script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
        <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
        <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
        <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
        @include('layouts.partials.multi-select')

        <script>
            $(document).ready(function() {
                $('.selectMulti').select2({
                    placeholder: 'Select an option',
                    allowClear: true,
                    maximumSelectionLength: 1,
                    width: '100%',
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('.datepicker-here').datepicker({
                    onSelect: function(formattedDate, date, inst) {
                        inst.hide();
                    },
                });

                function parseDate(date) {
                    let now = date;
                    // Format the date as "dd-mm-yyyy"
                    let day = now.getDate().toString().padStart(2, '0');
                    let month = (now.getMonth() + 1).toString().padStart(2, '0');
                    let year = now.getFullYear();
                    let formattedDate = `${day}-${month}-${year}`;
                    return formattedDate;
                }
                // Get the current date


                // Set the value of the input element
                document.querySelector('input[name="from_date"]').value = parseDate(new Date());
                document.querySelector('input[name="to_date"]').value = parseDate(new Date());

                load_data();

                function load_data(from_date = '', to_date = '', material = '', product = '', type = '', warehouse='') {

                    var table = $('#dataTable').DataTable({
                        "language": {
                            "processing": `<i class="fa text-success fa-refresh fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>`,
                        },
                        "lengthChange": false,
                        "bPaginate": false, // disable pagination
                        "bLengthChange": false, // disable show entries dropdown
                        "searching": true,
                        "ordering": true,
                        "info": false,
                        "autoWidth": true,
                        fixedColumns: {
                            leftColumns: 0,
                            rightColumns: 0
                        },
                        scrollY: 400,
                        scrollX: true,
                        scrollCollapse: true,
                        paging: false,
                        "fixedHeader": true,
                        processing: true,
                        serverSide: true,
                        pageLength: -1,
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ url('/report_return_invoice') }}",
                            data: {
                                from_date: from_date,
                                to_date: to_date,
                                material: material,
                                product: product,
                                type: type,
                                warehouse: warehouse
                            }
                        },
                        columns: [{
                                className: 'fw-bold text-nowrap',
                                data: 'return_number',
                                name: 'return_number'

                            },
                            {
                                className: 'fw-bold text-nowrap text-center',
                                data: 'sales_order_id',
                                name: 'sales_order_id'

                            },
                            {
                                className: 'fw-bold text-nowrap text-center',
                                data: 'sales_order_created',
                                name: 'sales_order_created'

                            },
                            {
                                data: 'return_date',
                                name: 'return_date'

                            },
                             {
                                data: 'customer',
                                name: 'customer'

                            },
                            {
                                data: 'area',
                                name: 'area'

                            },
                            {
                                data: 'district',
                                name: 'district'

                            },
                            {
                                data: 'return_reason',
                                name: 'return_reason'

                            },

                            {
                                data: 'sub_material',
                                name: 'sub_material'

                            },
                            {
                                className: 'text-nowrap text-center',
                                data: 'sub_type',
                                name: 'sub_type'

                            },
                            {
                                className: 'text-nowrap text-center',
                                data: 'product',
                                name: 'product'

                            },
                            
                            {
                                className: 'text-end',
                                data: 'qty',
                                name: 'qty'

                            },
                            {
                                className: 'text-end',
                                data: 'discount',
                                name: 'discount'

                            },
                            {
                                className: 'text-end',
                                data: 'discount_rp',
                                name: 'discount_rp'

                            },
                            {
                                className: 'text-nowrap text-center',
                                data: 'price',
                                name: 'price'

                            },
                            {
                                className: 'text-nowrap text-center',
                                data: 'price_excl',
                                name: 'price_excl'

                            },
                             {
                                className: 'text-end',
                                data: 'total_excl',
                                name: 'total_excl',
                                 render: function(data, type, row, meta) {
                                    if (meta.row > 0 && row['return_number'] === meta.settings.aoData[
                                            meta.row - 1]._aData['return_number']) {
                                        return '';
                                    }
                                    return data;
                                }

                            },
                             {
                                className: 'text-end',
                                data: 'ppn',
                                name: 'ppn',
                                render: function(data, type, row, meta) {
                                    if (meta.row > 0 && row['return_number'] === meta.settings.aoData[
                                            meta.row - 1]._aData['return_number']) {
                                        return '';
                                    }
                                    return data;
                                }

                            },
                            {
                                className: 'text-end',
                                data: 'total',
                                name: 'total',
                               render: function(data, type, row, meta) {
                                    if (meta.row > 0 && row['return_number'] === meta.settings.aoData[
                                            meta.row - 1]._aData['return_number']) {
                                        return '';
                                    }
                                    return data;
                                }
                            },
                            {
                                data: 'created_by',
                                name: 'created_by'

                            },

                        ],

                        order: [],
                        dom: 'Bfrtip',

                        buttons: [{
                                text: '<i class="fa-solid fa-arrows-turn-right"></i>',
                                attr: {
                                    id: 'increaseLeft'
                                },

                            },
                            {
                                text: '<i class="fa-solid fa-clock-rotate-left"></i>',
                                attr: {
                                    id: 'decreaseLeft'
                                },

                            },
                            {
                                text: '<i class="fa fa-print"></i>',

                                title: 'Data Return Invoice',
                                messageTop: '<h5>{{ $title }} ({{ date('l H:i A, d F Y ') }})</h5><br>',
                                messageBottom: '<strong style="color:red;">*Please select only the type of column needed when printing so that the print is neater</strong>',
                                extend: 'print',
                                customize: function(win) {
                                    $(win.document.body)
                                        .css('font-size', '10pt')
                                        .prepend(
                                            '<img src="{{ asset('images/logo.png') }}" style="position:absolute; top:300; left:150; bottom:; opacity: 0.2;"/>'
                                        );
                                    $(win.document.body)
                                        .find('thead')
                                        .css('background-color', 'rgba(211,225,222,255)')
                                        .css('font-size', '8pt')
                                    $(win.document.body)
                                        .find('tbody')
                                        .css('background-color', 'rgba(211,225,222,255)')
                                        .css('font-size', '8pt')
                                    $(win.document.body)
                                        .find('table')
                                        .css('width', '100%')
                                },
                                orientation: 'landscape',
                                pageSize: 'legal',
                                rowsGroup: [0],
                                exportOptions: {


                                    columns: ':visible'
                                },
                            },
                            {
                                text: '<i class="fa fa-download"></i>',

                                extend: 'excel',
                                exportOptions: {
                                    columns: ':visible'
                                },
                                customize: function(xlsx) {
                                    var sheet = xlsx.xl.worksheets['sheet1.xml'];

                                    // Get the table footer values
                                    var footerValues = [];
                                    $('#dataTable tfoot th').each(function() {
                                        footerValues.push($(this).text());
                                    });

                                    // Add the footer row to the sheet data
                                    var footerRow = sheet.getElementsByTagName('sheetData')[0]
                                        .appendChild(sheet.createElement('row'));
                                    footerRow.setAttribute('r', sheet.getElementsByTagName('row')
                                        .length + 1);

                                    // Add cells to the footer row
                                    for (var i = 0; i < footerValues.length; i++) {
                                        var cell = footerRow.appendChild(sheet.createElement('c'));
                                        cell.setAttribute('r', String.fromCharCode(65 + i) + footerRow
                                            .getAttribute('r'));
                                        cell.setAttribute('t', 'inlineStr');
                                        var inlineStr = cell.appendChild(sheet.createElement('is'));
                                        var textNode = inlineStr.appendChild(sheet.createElement('t'));
                                        textNode.appendChild(sheet.createTextNode(footerValues[i]));
                                    }
                                }
                            },
                            'colvis'
                        ],
                         footerCallback: function(row, data, start, end, display) {
                            var api = this.api();
                            // TOTAL INCL
                            var visibleData_ = api.column(13).nodes().to$().map(function() {
                                return $(this).text();
                            }).toArray();
                            var visibleColumns_ = api.columns().visible();
                            var filteredData_ = visibleData_.filter(function(data) {
                                return data.trim() !== '';
                            });
                            var totalIncl = 0;
                            filteredData_.forEach(function(data) {
                                if (data != '') {
                                    let raw1 = data.split(",");
                                    raw2 = raw1.join('');
                                    totalIncl += parseInt(raw2);
                                }
                            });
                            $(api.column(13).footer()).html(totalIncl.toLocaleString('en', {}));
                            // TOTAL INCL
                            var visibleData_ = api.column(14).nodes().to$().map(function() {
                                return $(this).text();
                            }).toArray();
                            var visibleColumns_ = api.columns().visible();
                            var filteredData_ = visibleData_.filter(function(data) {
                                return data.trim() !== '';
                            });
                            var totalIncl = 0;
                            filteredData_.forEach(function(data) {
                                if (data != '') {
                                    let raw1 = data.split(",");
                                    raw2 = raw1.join('');
                                    totalIncl += parseInt(raw2);
                                }
                            });
                            $(api.column(14).footer()).html(totalIncl.toLocaleString('en', {}));
                            // PPN
                            var visibleData = api.column(15).nodes().to$().map(function() {
                                return $(this).text();
                            }).toArray();
                            var visibleColumns = api.columns().visible();
                            var filteredData = visibleData.filter(function(data) {
                                return data.trim() !== '';
                            });
                            var totalprice = 0;
                            filteredData.forEach(function(data) {
                                if (data != '') {
                                    let raw1 = data.split(",");
                                    raw2 = raw1.join('');
                                    totalprice += parseInt(raw2);
                                }
                            });
                            $(api.column(15).footer()).html(totalprice.toLocaleString('en', {}));


                            // PPN
                            var visibleData = api.column(16).nodes().to$().map(function() {
                                return $(this).text();
                            }).toArray();
                            var visibleColumns = api.columns().visible();
                            var filteredData = visibleData.filter(function(data) {
                                return data.trim() !== '';
                            });
                            var totalPPN = 0;
                            filteredData.forEach(function(data) {
                                if (data != '') {
                                    let raw1 = data.split(",");
                                    raw2 = raw1.join('');
                                    totalPPN += parseInt(raw2);
                                }
                            });
                            $(api.column(16).footer()).html(totalPPN.toLocaleString('en', {}));


                            // TOTAL INCL
                            var visibleData_ = api.column(17).nodes().to$().map(function() {
                                return $(this).text();
                            }).toArray();
                            var visibleColumns_ = api.columns().visible();
                            var filteredData_ = visibleData_.filter(function(data) {
                                return data.trim() !== '';
                            });
                            var totalIncl = 0;
                            filteredData_.forEach(function(data) {
                                if (data != '') {
                                    let raw1 = data.split(",");
                                    raw2 = raw1.join('');
                                    totalIncl += parseInt(raw2);
                                }
                            });
                            $(api.column(17).footer()).html(totalIncl.toLocaleString('en', {}));

                        },



                    });

                    $(document).find('#increaseLeft').on('click', function() {
                        // console.log('test');
                        var currLeft = table.fixedColumns().left();
                        if (currLeft < 9) {
                            table.fixedColumns().left(currLeft + 1);
                            $('#click-output').prepend(
                                '<div>New Left: ' + (+currLeft + 1) + '</div>'
                            );
                        }
                    })

                    $('button#decreaseLeft').on('click', function() {
                        var currLeft = table.fixedColumns().left();
                        if (currLeft > 0) {
                            table.fixedColumns().left(currLeft - 1);
                            $('#click-output').prepend(
                                '<div>New Left: ' + (+currLeft - 1) + '</div>'
                            );
                        }
                    })

                }
                $('#filter').click(function() {
                    function formatDate(date) {
                        // Split the date string into day, month, and year components
                        let dateParts = date.split('-');

                        // Create a new Date object using the year, month, and day components
                        let dateObject = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);

                        // Format the date as "yyyy-mm-dd"
                        let year = dateObject.getFullYear();
                        let month = (dateObject.getMonth() + 1).toString().padStart(2, '0');
                        let day = dateObject.getDate().toString().padStart(2, '0');
                        let formattedDate = `${year}-${month}-${day}`;

                        return formattedDate;
                    }

                    var from_date = formatDate($('#from_date').val());
                    var to_date = formatDate($('#to_date').val());
                    var material = $('#material').val();
                    var product = $('#product').val();
                    var type = $('#type').val();
                    var warehouse = $('#warehouse').val();
                    if (from_date != '' && to_date != '') {
                        $('#dataTable').DataTable().destroy();
                        load_data(from_date, to_date, material, product, type, warehouse);
                    } else {
                        $.notify({
                            title: 'Warning !',
                            message: 'Please Select Start Date & End Date'
                        }, {
                            type: 'warning',
                            allow_dismiss: true,
                            newest_on_top: true,
                            mouse_over: true,
                            showProgressbar: false,
                            spacing: 10,
                            timer: 3000,
                            placement: {
                                from: 'top',
                                align: 'right'
                            },
                            offset: {
                                x: 30,
                                y: 30
                            },
                            delay: 1000,
                            z_index: 3000,
                            animate: {
                                enter: 'animated swing',
                                exit: 'animated swing'
                            }
                        });
                    }
                });
                $('#refresh').click(function() {
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                    var yyyy = today.getFullYear();
                    today = yyyy + '-' + mm + '-' + dd;
                    $('#from_date').val(parseDate(new Date()));
                    $('#to_date').val(parseDate(new Date()));
                    $('#material').val(null).trigger('change');
                    $('#product').val(null).trigger('change');
                    $('#type').val(null).trigger('change');
                    $('#dataTable').DataTable().destroy();
                    load_data();
                });


            });
        </script>
    @endpush
@endsection
