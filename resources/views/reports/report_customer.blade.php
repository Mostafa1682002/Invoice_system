@extends('layouts.master')
@section('title')
    تقرير العملاء
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقرير
                    العملاء</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">

                    <form action="{{ route('search_customer') }}" method="POST" role="search" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">القسم</label>
                                <select name="section" class="form-control select" onchange="ShowProduct(this)">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد القسم</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}"> {{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                <label for="inputName" class="control-label">المنتج</label>
                                <select id="product" name="product" class="form-control select">
                                </select>
                            </div>


                            <div class="col-lg-3">
                                <label for="exampleFormControlSelect1">من تاريخ</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="start_at">
                                            <i class="fas fa-calendar-alt"></i>
                                        </label>
                                    </div><input class="form-control fc-datepicker" id="start_at" name="start_at"
                                        placeholder="YYYY-MM-DD" type="text">
                                </div><!-- input-group -->
                            </div>

                            <div class="col-lg-3">
                                <label for="exampleFormControlSelect1">الي تاريخ</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="end_at">
                                            <i class="fas fa-calendar-alt"></i>
                                        </label>
                                    </div><input class="form-control fc-datepicker" name="end_at" id="end_at"
                                        placeholder="YYYY-MM-DD" type="text">
                                </div><!-- input-group -->
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-sm-4 col-12 col-md-3">
                                <button class="btn btn-primary btn-block">بحث</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (isset($details))
                            <table id="example" class="table key-buttons text-md-nowrap" style=" text-align: center">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">رقم الفاتوره</th>
                                        <th class="border-bottom-0">تاريخ الفاتوره</th>
                                        <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                        <th class="border-bottom-0">القسم</th>
                                        <th class="border-bottom-0">المنتج</th>
                                        <th class="border-bottom-0">الخصم</th>
                                        <th class="border-bottom-0">نسبة الضريبه</th>
                                        <th class="border-bottom-0">قيمةالضريبه</th>
                                        <th class="border-bottom-0">الاجمالي</th>
                                        <th class="border-bottom-0">الحاله</th>
                                        <th class="border-bottom-0">ملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0;@endphp
                                    @foreach ($details as $invoice)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $invoice['invoice_number'] }}</td>
                                            <td>{{ $invoice['invoice_date'] }}</td>
                                            <td>{{ $invoice['due_date'] }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('invoiceDetails.show', ['invoiceDetail' => $invoice->id]) }}">{{ $invoice->section->section_name }}</a>
                                            </td>
                                            <td>{{ $invoice['product'] }}</td>
                                            <td>{{ $invoice['discount'] }}</td>
                                            <td>{{ $invoice['rate_vat'] }}</td>
                                            <td>{{ $invoice['value_vat'] }}</td>
                                            <td>{{ $invoice['total'] }}</td>
                                            @if ($invoice['value_status'] == 0)
                                                <td class="text-success">{{ $invoice['status'] }}</td>
                                            @elseif ($invoice['value_status'] == 1)
                                                <td class="text-warning">{{ $invoice['status'] }}</td>
                                            @else
                                                <td class="text-danger">{{ $invoice['status'] }}</td>
                                            @endif
                                            <td>{{ $invoice['notes'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>
    <script>
        function ShowProduct(ele) {
            var SectionId = ele.value;
            // Creating the XMLHttpRequest object
            var request = new XMLHttpRequest();

            // Instantiating the request object
            request.open("GET", "{{ URL::to('section') }}/" + SectionId);

            // Defining event listener for readystatechange event
            request.onreadystatechange = function() {
                // Check if the request is compete and was successful
                if (this.readyState === 4 && this.status === 200) {
                    var SelectProduct = document.querySelector("[name='product']");
                    var allProducts = JSON.parse(this.responseText);
                    SelectProduct.innerHTML = '';
                    for (var id in allProducts) {
                        SelectProduct.innerHTML += `<option value='${allProducts[id]}'>${allProducts[id]}</option>`;
                    }
                }
            };
            // Sending the request to the server
            request.send();
        }
    </script>
@endsection
