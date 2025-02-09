@extends('layouts.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
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
                <div class="col-sm-6">
                    <h3 class="font-weight-bold">{{ $title }}</h3>
                </div>
            </div>
        </div>
    </div>



    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-4 form-group">
                                <label class="col-form-label text-end">
                                    Status</label>
                                <select name="status" id="status" required class="form-control selectMulti" multiple>
                                    <option value="Not Proposed" selected>Not Proposed</option>
                                    <option value="In Progress">In Progress</option>
                                </select>

                            </div>
                            <div class="col-lg-4 col-12 start-date" hidden>
                                <label class="col-form-label text-end">Start Date</label>
                                <div class="input-group">
                                    <input class="datepicker-here form-control digits" data-position="bottom left"
                                        type="text" data-language="en" id="start-date" data-value="{{ date('d-m-Y') }}"
                                        name="start-date" autocomplete="off">

                                </div>
                            </div>
                            <div class="col-lg-4 col-12 end-date" hidden>
                                <label class="col-form-label text-end">End Date</label>
                                <div class="input-group">
                                    <input class="datepicker-here form-control digits" data-position="bottom left"
                                        type="text" data-language="en" id="end-date" data-value="{{ date('d-m-Y') }}"
                                        name="end-date" autocomplete="on">
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
                            <table id="outside"
                                class="dataTable display table table-striped row-border order-column table-sm"
                                style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th></th>
                                        <th>#</th>
                                        <th>Trip Number</th>
                                        <th>Name</th>
                                        <th>Departure - Return Date</th>
                                        <th>Departure - Destination</th>

                                    </tr>
                                </thead>
                            </table>
                            <div class="form-group">
                                <small> <span class="text-danger">*Note : </span><br>
                                    - BTRPP is Business Trip Profecta Perdana <br>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid Ends-->
    @push('scripts')
        <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>
        <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
        <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
        <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.datepicker-here').datepicker({
                    onSelect: function(formattedDate, date, inst) {
                        inst.hide();
                    },
                });

                $('.selectMulti').select2({
                    placeholder: 'Select an option',
                    allowClear: true,
                    maximumSelectionLength: 1,
                    width: '100%',
                });

                let status = '';
                $('#status').on('change', function(e) {
                    status = $(this).val();
                    if (status == 'Not Proposed' || status == '') {
                        $('#start-date').val('');
                        $('#end-date').val('');
                        $('.start-date').attr('hidden', true);
                        $('.end-date').attr('hidden', true);

                    } else {
                        $('.start-date').attr('hidden', false);
                        $('.end-date').attr('hidden', false);
                    }
                });

                $('#imageInput').on('change', function(e) {
                    var file = e.target.files[0];
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        var img = new Image();
                        img.onload = function() {
                            var canvas = document.getElementById('myCanvas');
                            var ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                        };
                        img.src = event.target.result;
                    };

                    reader.readAsDataURL(file);
                });

                var isDrawing = false;
                var lastX = 0;
                var lastY = 0;

                $('#myCanvas').on('mousedown', function(e) {
                    isDrawing = true;
                    lastX = e.offsetX;
                    lastY = e.offsetY;
                }).on('mousemove', function(e) {
                    if (isDrawing) {
                        var canvas = document.getElementById('myCanvas');
                        var ctx = canvas.getContext('2d');
                        ctx.beginPath();
                        ctx.moveTo(lastX, lastY);
                        ctx.lineTo(e.offsetX, e.offsetY);
                        ctx.strokeStyle = 'red';
                        ctx.lineWidth = 3;
                        ctx.stroke();
                        lastX = e.offsetX;
                        lastY = e.offsetY;
                    }
                }).on('mouseup mouseleave', function() {
                    isDrawing = false;
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                var x = 0;

                $(document).on('click', '.modalItem', function() {

                    let modal_id = $(this).attr('data-bs-target');
                    let item_id = $(modal_id).find('.id-item').val();
                    $(modal_id).find('.datepicker-here').datepicker({
                        onSelect: function(formattedDate, date, inst) {
                            inst.hide();
                        },
                    });

                    $(modal_id).find('.selectMulti, .vehicle, .transports').select2({
                        dropdownParent: modal_id,
                        placeholder: 'Select an option',
                        allowClear: true,
                        maximumSelectionLength: 1,
                        width: '100%',
                    });

                    $('form').submit(function(e) {
                        var form = $(this);
                        var button = form.find('button[type="submit"]');

                        if (form[0].checkValidity()) { // check if form has input values
                            button.prop('disabled', true);
                            // e.preventDefault(); // prevent form submission
                        }
                    });

                    let vehicle_id = $(modal_id).find('.id-vehicle').val();
                    if (vehicle_id == 'Operational Vehicle') {
                        var mobilGranmax = document.getElementById('mobil1' + item_id).value;
                        // console.log(mobilGranmax);
                        const canvasGranmax = new fabric.Canvas('canvas' + item_id);
                        fabric.Image.fromURL(mobilGranmax, function(img) {
                            canvasGranmax.setBackgroundImage(img, canvasGranmax.renderAll.bind(
                                canvasGranmax));
                        });

                        canvasGranmax.isDrawingMode = true;
                        canvasGranmax.freeDrawingBrush.width = 0;
                        const colorsGranmax = [

                            'blue' // Lime
                        ];
                        let currentColorIndexGranmax = 0;
                        // Buat elemen temporary canvas
                        let tempCanvasGranmax = document.createElement('canvas');
                        tempCanvasGranmax.width = canvasGranmax.width;
                        tempCanvasGranmax.height = canvasGranmax.height;
                        let tempContextGranmax = tempCanvasGranmax.getContext('2d');

                        canvasGranmax.on('path:created', function(e) {
                            const path = e.path;
                            const color = colorsGranmax[currentColorIndexGranmax];
                            const notes = prompt('Enter notes for this annotation (Color: ' + color +
                                '):');
                            path.set('notes', notes);
                            path.set('stroke', color);
                            currentColorIndexGranmax = (currentColorIndexGranmax + 1) % colorsGranmax
                                .length;
                            const annotations = canvasGranmax.getObjects();
                            let annotationsHTML = '';
                            let k = document.getElementById('annotationsList' + item_id).getAttribute(
                                'data-count');
                            annotations.forEach(function(annotation) {

                                const strokeColor = annotation.get('stroke');
                                const notes = annotation.get('notes');
                                if (notes != undefined) {
                                    const listItemHTML =
                                        `<li class="notesParent mb-2">
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text"
                                                        style="background: white !important">
                                                        <i class="fa fa-circle" style="color:${strokeColor}"></i>
                                                    </span>
                                                    <input type="text" class="form-control" name="formVehicle[${k}][notes]" value="${notes}">
                                                </div>
                                            <input type="hidden" name="formVehicle[${k}][color]" value="${strokeColor}">
                                        </li>`;
                                    annotationsHTML = listItemHTML;
                                    k++;
                                }

                            });
                            const centerX = (path.left + path.width / 2);
                            const centerY = (path.top + path.height / 2);
                            const circle = new fabric.Circle({
                                left: centerX - 15,
                                top: centerY - 15,
                                radius: 15, // Sesuaikan radius sesuai kebutuhan
                                fill: 'rgba(0, 0, 0, 0)', // Set fill ke transparan (alpha = 0)
                                stroke: color,
                                strokeWidth: 5, // Sesuaikan lebar garis sesuai kebutuhan
                                selectable: true
                            });

                            // Tambahkan lingkaran ke canvas dan hapus path
                            canvasGranmax.add(circle);
                            // canvasGranmax.remove(path);

                            // Render ulang canvas
                            canvasGranmax.renderAll();

                            // Render ulang path untuk menggambarnya dengan fill dan stroke yang sesuai
                            path.render(canvasGranmax.contextContainer);
                            canvasGranmax.requestRenderAll();
                            document.getElementById('annotationsList' + item_id).insertAdjacentHTML(
                                'beforeend', annotationsHTML);


                            // Bersihkan tempCanvasGranmax
                            tempContextGranmax.clearRect(0, 0, tempCanvasGranmax.width,
                                tempCanvasGranmax
                                .height);
                            tempContextGranmax.drawImage(canvasGranmax.getElement(), 0, 0, canvasGranmax
                                .width, canvasGranmax
                                .height);

                            // Gambar ulang semua annotasi ke tempCanvasGranmax
                            annotations.forEach(function(annotation) {
                                annotation.render(tempContextGranmax);
                            });

                            // Konversi seluruh canvas menjadi data URL
                            let canvasDataUrlGranmax = tempCanvasGranmax.toDataURL("image/png");

                            // Set data URL ke elemen input
                            let canvasDataInputGranmax = document.getElementById(
                                'canvasDataInputGranmax' +
                                item_id);
                            canvasDataInputGranmax.value = canvasDataUrlGranmax;
                        });



                        document.getElementById('undoButtonGranmax' + item_id).addEventListener('click',
                            function() {
                                const objects = canvasGranmax.getObjects();
                                // const lastObject = canvasGranmax.getObjects();
                                if (objects.length > 0) {
                                    const lastObject = objects[objects.length - 2];
                                    const lastObjectIndex = objects[objects.length - 1];
                                    canvasGranmax.remove(lastObject);
                                    canvasGranmax.remove(lastObjectIndex);
                                    canvasGranmax.renderAll();

                                    $('.notesParent').last().remove();
                                }
                            });

                    }


                    function parseDate(date) {
                        let now = date;
                        // Format the date as "dd-mm-yyyy"
                        let day = now.getDate().toString().padStart(2, '0');
                        let month = (now.getMonth() + 1).toString().padStart(2, '0');
                        let year = now.getFullYear();
                        let formattedDate = `${day}-${month}-${year}`;
                        return formattedDate;
                    }

                    // $(modal_id).find('.datepicker-here').val(parseDate(new Date()));
                    // console.log($(modal_id).find('tbody').find('.transport').html());
                    $(modal_id).find('.acomodation,.transport,.perDiem,.other').on('change', function() {
                        let hargaInput = $(this).val();
                        let hargaPisah = hargaInput.split('.');
                        let hargaAkhir = 0;
                        let hargaFinal = 0;
                        if (hargaPisah.length > 1) {
                            hargaPisah[0] = hargaPisah[0].replace(/,/g, '');
                            let hargaFloat = parseFloat(hargaPisah[0]).toLocaleString(
                                'en', {

                                });
                            hargaAkhir = hargaFloat + ',' + parseFloat(hargaPisah[1]);
                            hargaFinal = parseFloat(hargaPisah[0] + ',' + hargaPisah[1]);
                        } else {
                            hargaPisah[0] = hargaPisah[0].replace(/,/g, '');
                            let hargaFloat = parseFloat(hargaPisah).toLocaleString();
                            hargaAkhir = hargaFloat;
                            hargaFinal = hargaPisah[0];
                        }
                        $(this).val(hargaAkhir);
                        $(this).next().val(hargaFinal);
                    });

                    // transport
                    $(modal_id).find('.transport').on('focusout', function() {
                        let totalTransport = 0;
                        let hargaAkhir = 0;
                        $(modal_id).find('.realTransport').each(function() {
                            totalTransport += parseInt($(this).val());
                            // console.log('totalTransport: ' + totalTransport);
                        });
                        if (isNaN(totalTransport)) {
                            totalTransport = 0;
                        }
                        let hargaFloat = parseFloat(totalTransport).toLocaleString(
                            'en', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                        hargaAkhir = hargaFloat;
                        $(modal_id).find('.totalTransport').val(hargaAkhir);
                        $(modal_id).find('.totalTransport_').val(totalTransport);
                    });

                    // acomodation
                    $(modal_id).find('.acomodation').on('focusout', function() {
                        let totalTransport = 0;
                        $(modal_id).find('.realAcomodation').each(function() {
                            totalTransport += parseInt($(this).val());
                        });
                        if (isNaN(totalTransport)) {
                            totalTransport = 0;
                        }
                        let hargaFloat = parseFloat(totalTransport).toLocaleString(
                            'en', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                        hargaAkhir = hargaFloat;
                        $(modal_id).find('.totalAcomodation').val(hargaAkhir);
                        $(modal_id).find('.totalAcomodation_').val(totalTransport);
                    });

                    // per diem
                    $(modal_id).find('.perDiem').on('focusout', function() {
                        let totalTransport = 0;
                        $(modal_id).find('.realPerDiem').each(function() {
                            totalTransport += parseInt($(this).val());
                        });
                        if (isNaN(totalTransport)) {
                            totalTransport = 0;
                        }
                        let hargaFloat = parseFloat(totalTransport).toLocaleString(
                            'en', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                        hargaAkhir = hargaFloat;
                        $(modal_id).find('.totalPerDiem').val(hargaAkhir);
                        $(modal_id).find('.totalPerDiem_').val(totalTransport);
                    });

                    // per diem
                    // $(modal_id).find('.toll').on('focusout', function() {
                    //     let totalTransport = 0;
                    //     $(modal_id).find('.realToll').each(function() {
                    //         totalTransport += parseInt($(this).val());
                    //     });
                    //     if (isNaN(totalTransport)) {
                    //         totalTransport = 0;
                    //     }
                    //     let hargaFloat = parseFloat(totalTransport).toLocaleString(
                    //         'en', {
                    //             minimumFractionDigits: 0,
                    //             maximumFractionDigits: 0
                    //         });
                    //     hargaAkhir = hargaFloat;
                    //     $(modal_id).find('.totalToll').val(hargaAkhir);
                    //     $(modal_id).find('.totalToll_').val(totalTransport);
                    // });

                    // other
                    $(modal_id).find('.other').on('focusout', function() {
                        let totalTransport = 0;
                        $(modal_id).find('.realOther').each(function() {
                            totalTransport += parseInt($(this).val());
                        });
                        if (isNaN(totalTransport)) {
                            totalTransport = 0;
                        }
                        let hargaFloat = parseFloat(totalTransport).toLocaleString(
                            'en', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                        hargaAkhir = hargaFloat;
                        $(modal_id).find('.totalOther').val(hargaAkhir);
                        $(modal_id).find('.totalOther_').val(totalTransport);
                    });

                    // get total
                    $(modal_id).find('.acomodation,.transport,.perDiem,.other').on('focusout',
                        function() {
                            let total = 0;
                            let totalTransport = $(modal_id).find('.totalTransport_').val();
                            let totalAcomodation = $(modal_id).find('.totalAcomodation_').val();
                            let totalPerDiem = $(modal_id).find('.totalPerDiem_').val();
                            // let totalToll = $(modal_id).find('.totalToll_').val();
                            let totalOther = $(modal_id).find('.totalOther_').val();

                            if (totalTransport == '') {
                                totalTransport = 0;
                            }
                            if (totalAcomodation == '') {
                                totalAcomodation = 0;
                            }
                            if (totalPerDiem == '') {
                                totalPerDiem = 0;
                            }
                            // if (totalToll == '') {
                            //     totalToll = 0;
                            // }
                            if (totalOther == '') {
                                totalOther = 0;
                            }
                            total = parseInt(totalTransport) + parseInt(totalAcomodation) + parseInt(
                                totalPerDiem) + parseInt(totalOther);
                            $(modal_id).find('.subTotal_').val(total);
                            $(modal_id).find('.subTotal').val(total.toLocaleString(
                                'en', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                }));

                            let cashRemain = 0;

                            let cashAdvance = $(modal_id).find('.cashAdvance_').val();
                            cashRemain = parseInt(cashAdvance) - parseInt(total);

                            if (cashRemain < 0) {
                                $(modal_id).find('.cashRemain').addClass('text-danger');
                            } else {
                                $(modal_id).find('.cashRemain').removeClass('text-danger');
                            }
                            $(modal_id).find('.cashRemain').val(cashRemain.toLocaleString());
                        });


                    $(document).off("click", ".addRow");
                    $(document).on('click', '.addRow', function() {
                        x++;
                        var newRow = `
                        <tr>
                                        <td class="d-flex">
                                            <button type="button" class="btn-sm btn-danger me-2 remRow">-</button>
                                            <button type="button" class="btn-sm btn-primary addRow">+</button>
                                            </td>
                                        <td><input name="expense[${x}][date]" class="datepicker-here form-control digits"
                                                    data-position="top left" type="text" data-language="en"
                                                    data-value="{{ date('d-m-Y') }}" autocomplete="on"></td>
                                        <td>
                                            <textarea class="form-control" name="expense[${x}][desc]" id="" cols="30" rows="1"></textarea>
                                        </td>
                                        <td><input placeholder="0"
                                                class="transport form-control text-end" type="text" value="0">
                                            <input value="0" type="hidden" class="realTransport" name="expense[${x}][transport]">
                                        </td>
                                        <td><input placeholder="0"
                                                class="acomodation form-control text-end" type="text" value="0">
                                            <input value="0" type="hidden" class="realAcomodation" name="expense[${x}][acomodation]">
                                        </td>
                                        <td><input placeholder="0"
                                                class="perDiem form-control text-end" type="text" value="0">
                                            <input value="0" type="hidden" class="realPerDiem" name="expense[${x}][per_diem]">
                                        </td>
                                        
                                        <td><input placeholder="0"
                                                class="other form-control text-end" type="text" value="0">
                                            <input value="0" type="hidden" class="realOther" name="expense[${x}][other]">

                                        </td>

                                        </tr>
                         `;
                        $(modal_id).find('#table-body').append(newRow);
                        $(modal_id).find('.datepicker-here').datepicker({
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

                        // $(this).closest('tr').next().find('.datepicker-here').val(parseDate(
                        //     new Date()));

                        $(modal_id).find('.acomodation,.transport,.perDiem,.other').on('change',
                            function() {
                                let hargaInput = $(this).val();
                                // console.log(hargaInput);
                                let hargaPisah = hargaInput.split('.');
                                let hargaFinal = 0;
                                if (hargaPisah.length > 1) {
                                    hargaPisah[0] = hargaPisah[0].replace(/,/g, '');
                                    let hargaFloat = parseFloat(hargaPisah[0]).toLocaleString(
                                        'en', {

                                        });
                                    hargaAkhir = hargaFloat + ',' + parseFloat(hargaPisah[1]);
                                    hargaFinal = parseFloat(hargaPisah[0] + ',' + hargaPisah[1]);
                                } else {
                                    hargaPisah[0] = hargaPisah[0].replace(/,/g, '');
                                    let hargaFloat = parseFloat(hargaPisah).toLocaleString(
                                        'en', {
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 0
                                        });
                                    hargaAkhir = hargaFloat;
                                    hargaFinal = hargaPisah[0];
                                }
                                $(this).val(hargaAkhir);
                                $(this).next().val(hargaFinal);
                            });

                        // transport
                        $(modal_id).find('.transport').on('focusout', function() {
                            let totalTransport = 0;
                            $(modal_id).find('.realTransport').each(function() {
                                totalTransport += parseInt($(this).val());
                            });
                            if (isNaN(totalTransport)) {
                                totalTransport = 0;
                            }
                            let hargaFloat = parseFloat(totalTransport).toLocaleString(
                                'en', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                            hargaAkhir = hargaFloat;
                            $(modal_id).find('.totalTransport').val(hargaAkhir);
                            $(modal_id).find('.totalTransport_').val(totalTransport);
                        });

                        // acomodation
                        $(modal_id).find('.acomodation').on('focusout', function() {
                            let totalTransport = 0;
                            $(modal_id).find('.realAcomodation').each(function() {
                                totalTransport += parseInt($(this).val());
                            });
                            if (isNaN(totalTransport)) {
                                totalTransport = 0;
                            }
                            let hargaFloat = parseFloat(totalTransport).toLocaleString(
                                'en', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                            hargaAkhir = hargaFloat;
                            $(modal_id).find('.totalAcomodation').val(hargaAkhir);
                            $(modal_id).find('.totalAcomodation_').val(totalTransport);
                        });

                        // per diem
                        $(modal_id).find('.perDiem').on('focusout', function() {
                            let totalTransport = 0;
                            $(modal_id).find('.realPerDiem').each(function() {
                                totalTransport += parseInt($(this).val());
                            });
                            if (isNaN(totalTransport)) {
                                totalTransport = 0;
                            }
                            let hargaFloat = parseFloat(totalTransport).toLocaleString(
                                'en', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                            hargaAkhir = hargaFloat;
                            $(modal_id).find('.totalPerDiem').val(hargaAkhir);
                            $(modal_id).find('.totalPerDiem_').val(totalTransport);
                        });

                        // per diem
                        // $(modal_id).find('.toll').on('focusout', function() {
                        //     let totalTransport = 0;
                        //     $(modal_id).find('.realToll').each(function() {
                        //         totalTransport += parseInt($(this).val());
                        //     });
                        //     if (isNaN(totalTransport)) {
                        //         totalTransport = 0;
                        //     }
                        //     let hargaFloat = parseFloat(totalTransport).toLocaleString(
                        //         'en', {
                        //             minimumFractionDigits: 0,
                        //             maximumFractionDigits: 0
                        //         });
                        //     hargaAkhir = hargaFloat;
                        //     $(modal_id).find('.totalToll').val(hargaAkhir);
                        //     $(modal_id).find('.totalToll_').val(totalTransport);
                        // });

                        // other
                        $(modal_id).find('.other').on('focusout', function() {
                            let totalTransport = 0;
                            $(modal_id).find('.realOther').each(function() {
                                totalTransport += parseInt($(this).val());
                            });
                            if (isNaN(totalTransport)) {
                                totalTransport = 0;
                            }
                            let hargaFloat = parseFloat(totalTransport).toLocaleString(
                                'en', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                            hargaAkhir = hargaFloat;
                            $(modal_id).find('.totalOther').val(hargaAkhir);
                            $(modal_id).find('.totalOther_').val(totalTransport);
                        });

                        // get total
                        $(modal_id).find('.acomodation,.transport,.perDiem,.other').on('focusout',
                            function() {
                                let total = 0;
                                let totalTransport = $(modal_id).find('.totalTransport_').val();
                                let totalAcomodation = $(modal_id).find('.totalAcomodation_').val();
                                let totalPerDiem = $(modal_id).find('.totalPerDiem_').val();
                                // let totalToll = $(modal_id).find('.totalToll_').val();
                                let totalOther = $(modal_id).find('.totalOther_').val();

                                if (totalTransport == '') {
                                    totalTransport = 0;
                                }
                                if (totalAcomodation == '') {
                                    totalAcomodation = 0;
                                }
                                if (totalPerDiem == '') {
                                    totalPerDiem = 0;
                                }
                                // if (totalToll == '') {
                                //     totalToll = 0;
                                // }
                                if (totalOther == '') {
                                    totalOther = 0;
                                }
                                total = parseInt(totalTransport) + parseInt(totalAcomodation) +
                                    parseInt(
                                        totalPerDiem) + parseInt(totalOther);
                                $(modal_id).find('.subTotal_').val(total);
                                $(modal_id).find('.subTotal').val(total.toLocaleString(
                                    'en', {
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0
                                    }));

                                let cashRemain = 0;
                                // console.log(cashRemain);

                                let cashAdvance = $(modal_id).find('.cashAdvance_').val();
                                cashRemain = parseInt(cashAdvance) - parseInt(total);

                                if (cashRemain < 0) {
                                    $(modal_id).find('.cashRemain').addClass('text-danger');
                                } else {
                                    $(modal_id).find('.cashRemain').removeClass('text-danger');
                                }

                                $(modal_id).find('.cashRemain').val(cashRemain.toLocaleString(
                                    'en', {
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0
                                    }));
                            });
                    });
                    $(document).on('click', '.remRow', function() {
                        var row = $(this).closest('tr');
                        var valueX = parseInt(row.data('x'));
                        row.remove();
                        if (!isNaN(valueX) && valueX > 0) {
                            x = valueX;
                        }

                    });
                });


            });
        </script>
        <script>
            $(document).ready(function() {
                // $(document).on('submit', '.approved', function(event) {
                //     event.preventDefault();
                //     let formElement = $(this);
                //     let url = formElement.attr('action');
                //     let button = formElement.find('button[type="submit"]');
                //     button.prop('disabled', true);
                //     $.ajax({
                //         url: url,
                //         type: "GET",
                //         dataType: "JSON",
                //         processData: false, // prevent jQuery from processing the data
                //         contentType: false, // prevent jQuery from setting the content type
                //         beforeSend: function() {
                //             $('.btnSubmit').attr('disabled', true);
                //             $('.btnSubmit').html(
                //                 `<i class="fa fa-spinner fa-spin"></i> Processing...`
                //             );
                //         },
                //         success: function(response) {
                //             if (response.status == "success") {
                //                 swal("Success !", "data has been saved", "success", {
                //                     button: "Close",
                //                 });
                //                 // formElement[0].reset();
                //             } else {
                //                 swal("Failed !", "data failed to save", "error", {
                //                     button: "Close",
                //                 });
                //             }
                //             $('.dataTable').DataTable().ajax.reload();
                //             $('.hideModal').click();
                //         },
                //         error: function(data) {
                //             swal("failed !", "fail to saved data", "error", {
                //                 button: "Close",
                //             });
                //             button.prop('disabled', false);
                //         },
                //         complete: function() { // menambahkan fungsi complete untuk mengubah tampilan tombol kembali ke tampilan semula
                //             $('.btnSubmit').attr('disabled', false);
                //             $('.btnSubmit').html('Save');
                //         }
                //     });
                // });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                load_data();

                function load_data(status = '', start_date = '', end_date = '') {

                    var table = $('#outside').DataTable({
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
                        destroy: true,
                        ajax: {
                            url: "{{ url('trip/completed') }}",
                            data: {
                                status: status,
                                start_date: start_date,
                                end_date: end_date
                            }
                        },
                        columns: [{
                                className: 'dtr-control',
                                orderable: false,
                                data: null,
                                defaultContent: ''
                            }, {
                                className: 'text-end fw-bold',
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                            },
                            {
                                data: 'trip_number',
                                name: 'trip_number',
                            },
                             {
                                data: 'id_employee',
                                name: 'id_employee',
                            },

                            {
                                data: 'departure_date',
                                name: 'departure_date',

                            },
                            {
                                data: 'departure',
                                name: 'departure',

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
                                }
                            },
                            'colvis'
                        ],

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

                    var status = $('#status').val();
                    // console.log(status[0]);
                    var start_date = formatDate($('#start-date').val());
                    // console.log();
                    var end_date = formatDate($('#end-date').val());
                    if (status == 'In Progress' && start_date != '' && end_date != '') {
                        $('#outside').DataTable().destroy();
                        load_data(status[0], start_date, end_date);
                    } else if (status == 'Not Proposed' && isNaN(start_date) && isNaN(end_date)) {
                        $('#outside').DataTable().destroy();
                        load_data(status[0]);
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
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                    var yyyy = today.getFullYear();
                    today = yyyy + '-' + mm + '-' + dd;
                    $('#status').val('');
                    $('#outside').DataTable().destroy();
                    load_data();
                });


            });
        </script>
    @endpush
@endsection
