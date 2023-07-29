@extends('layouts.master')
@section('title')
    تفاصيل الفاتوره
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> قائمةالفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الفاتوره
                </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <!--div-->
        <div class="col-12 my-3">
            @if (session('success_invoice'))
                <div class="alert alert-success" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('success_invoice') }}
                </div>
            @endif
        </div>
        <div class="col-xl-12">

            <!-- div -->
            <div class="card mg-b-20" id="tabs-style3">
                <div class="card-body">
                    {{-- <div class="text-wrap"> --}}
                    {{-- <div class="example"> --}}
                    <div class="panel panel-primary tabs-style-3">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu ">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs">
                                    <li class=""><a href="#tab11" class="active" data-toggle="tab"><i
                                                class="fa fa-laptop"></i> معلومات الفاتوره</a></li>
                                    <li><a href="#tab12" data-toggle="tab"><i class="fa fa-cube"></i>
                                            حالات الفاتوره</a></li>
                                    <li><a href="#tab13" data-toggle="tab"><i class="fa fa-cogs"></i> المرفقات</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab11">
                                    <div class=" table-responsive mt-15">
                                        <table class="table table-striped" style="text-align:center">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">رقم الفاتورة</th>
                                                    <td>{{ $invoices->invoice_number }}</td>
                                                    <th scope="row">تاريخ الاصدار</th>
                                                    <td>{{ $invoices->invoice_date }}</td>
                                                    <th scope="row">تاريخ الاستحقاق</th>
                                                    <td>{{ $invoices->due_date }}</td>
                                                    <th scope="row">القسم</th>
                                                    <td>{{ $invoices->section->section_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">المنتج</th>
                                                    <td>{{ $invoices->product }}</td>
                                                    <th scope="row">مبلغ التحصيل</th>
                                                    <td>{{ $invoices->amount_collection }}</td>
                                                    <th scope="row">مبلغ العمولة</th>
                                                    <td>{{ $invoices->amount_commission }}</td>
                                                    <th scope="row">الخصم</th>
                                                    <td>{{ $invoices->discount }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">نسبة الضريبة</th>
                                                    <td>{{ $invoices->rate_vat }}</td>
                                                    <th scope="row">قيمة الضريبة</th>
                                                    <td>{{ $invoices->value_vat }}</td>
                                                    <th scope="row">الاجمالي مع الضريبة</th>
                                                    <td>{{ $invoices->total }}</td>
                                                    <th scope="row">الحالة الحالية</th>
                                                    @if ($invoices->value_status == 0)
                                                        <td><span
                                                                class="badge badge-pill badge-success">{{ $invoices->status }}</span>
                                                        </td>
                                                    @elseif($invoices->value_status == 2)
                                                        <td><span
                                                                class="badge badge-pill badge-danger">{{ $invoices->status }}</span>
                                                        </td>
                                                    @else
                                                        <td><span
                                                                class="badge badge-pill badge-warning">{{ $invoices->status }}</span>
                                                        </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <th scope="row">ملاحظات</th>
                                                    <td>{{ $invoices->notes }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="tab-pane" id="tab12">
                                    <div class="table-responsive mt-15">
                                        <table class="table center-aligned-table mb-0 table-hover"
                                            style="text-align:center">
                                            <thead>
                                                <tr class="text-dark">
                                                    <th>#</th>
                                                    <th>رقم الفاتورة</th>
                                                    <th>نوع المنتج</th>
                                                    <th>القسم</th>
                                                    <th>حالة الدفع</th>
                                                    <th>تاريخ الدفع </th>
                                                    <th>ملاحظات</th>
                                                    <th>تاريخ الاضافة </th>
                                                    <th>المستخدم</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @foreach ($invoice_details as $details)
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        <td>{{ $details->invoice_number }}</td>
                                                        <td>{{ $details->product }}</td>
                                                        <td>{{ $invoices->section->section_name }}</td>
                                                        @if ($details->value_status == 0)
                                                            <td><span
                                                                    class="badge badge-pill badge-success">{{ $details->status }}</span>
                                                            </td>
                                                        @elseif($details->value_status == 2)
                                                            <td><span
                                                                    class="badge badge-pill badge-danger">{{ $details->status }}</span>
                                                            </td>
                                                        @else
                                                            <td><span
                                                                    class="badge badge-pill badge-warning">{{ $details->status }}</span>
                                                            </td>
                                                        @endif
                                                        <td>{{ $details->payment_date }}</td>
                                                        <td>{{ $details->notes }}</td>
                                                        <td>{{ $details->created_at }}</td>
                                                        <td>{{ $details->user }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                                <div class="tab-pane" id="tab13">
                                    @can('اضافة مرفق')
                                        <div class="card-body">
                                            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                            <h5 class="card-title">اضافة مرفقات</h5>
                                            <form method="post" action="{{ route('invoiceAttachment.store') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="custom-file">
                                                    <input type="hidden" id="customFile" name="invoice_number"
                                                        value="{{ $invoices->invoice_number }}">
                                                    <input type="hidden" id="invoice_id" name="invoice_id"
                                                        value="{{ $invoices->id }}">
                                                    <input type="file" class="custom-file-input" id="customFile"
                                                        name="file_name" required>
                                                    <label class="custom-file-label" for="customFile">حدد
                                                        المرفق</label>
                                                </div><br><br>
                                                <button type="submit" class="btn btn-primary btn-sm ">تاكيد</button>
                                            </form>
                                        </div>
                                    @endcan
                                    <div class="table-responsive mt-15">
                                        <table class="table center-aligned-table mb-0 table-hover"
                                            style="text-align:center">
                                            <thead>
                                                <tr class="text-dark">
                                                    <th>#</th>
                                                    <th>اسم الملف</th>
                                                    <th>قام بالاضافه</th>
                                                    <th>تاريخ الاضافه</th>
                                                    <th>العمليات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = 0;@endphp
                                                @foreach ($invoice_attachment as $attachment)
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        <td>{{ $attachment->file_name }}</td>
                                                        <td>{{ $attachment->created_by }}</td>
                                                        <td>{{ $invoices->created_at }}</td>
                                                        <td>
                                                            <a href="{{ asset("imges_uplode/Attachments/$attachment->invoice_number/$attachment->file_name") }}"
                                                                target="_blank" class="btn btn-sm btn-outline-success"> <i
                                                                    class="fas fa-eye ml-1"></i>عرض </a>
                                                            <a href="{{ route('download', ['invoice_number' => $attachment->invoice_number, 'file_name' => $attachment->file_name]) }}"
                                                                class="btn btn-sm btn-outline-info"><i
                                                                    class="fas fa-download ml-1"></i>تحميل</a>
                                                            @can('حذف المرفق')
                                                                <a class="modal-effect btn-sm  btn btn-outline-danger deletefile"
                                                                    data-effect="effect-scale" data-toggle="modal"
                                                                    data-namefile="{{ $attachment->file_name }}"
                                                                    data-name-invoice="{{ $attachment->invoice_number }}"
                                                                    data-id="{{ $attachment->id }}" href="#modaldemo8"><i
                                                                        class="fas fa-trash ml-1"></i>حذف</a>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}
                    {{-- </div> --}}
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->




    <!-- Add Product -->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف المرفق</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="/invoiceAttachment/destroy" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="">
                            <p class="mb-3">هل انت متاكد من حذف المرفق ؟</p>
                            <div class="form-group">
                                <input type="hidden" name="id" class="form-control" id="exampleInputId"
                                    placeholder="" value="">
                                {{-- <input type="hidden" name="invoice_number" class="form-control" id="exampleInputInoi"
                                    placeholder="" value=""> --}}
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName">اسم المرفق</label>
                                <input type="text" name="file_name" class="form-control" id="exampleInputName"
                                    placeholder="" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputInvoiceName">مرفق خاص بفاتوره رقم</label>
                                <input type="text" name="invoice_name" class="form-control"
                                    id="exampleInputInvoiceName" placeholder="" value="" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit">تاكيد</button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Basic modal -->


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

    <!--Delet File js -->
    <script>
        let deletefiles = document.querySelectorAll('.deletefile');
        var element_id = document.querySelector("#exampleInputId");
        var element_name = document.querySelector("#exampleInputName");
        var element_Invoicename = document.querySelector("#exampleInputInvoiceName");

        deletefiles.forEach(deletefile => {
            deletefile.addEventListener('click', () => {
                var fileid = deletefile.getAttribute('data-id');
                var filename = deletefile.getAttribute('data-namefile');
                var Invoicename = deletefile.getAttribute('data-name-invoice');
                element_id.value = fileid;
                element_name.value = filename;
                console.log(Invoicename);
                element_Invoicename.value = Invoicename;
            })
        });
    </script>
@endsection
