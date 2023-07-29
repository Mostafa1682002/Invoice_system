@extends('layouts.master')
@section('title')
    ارشيف الفواتير
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <style>
        tr {
            text-wrap: nowrap;
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    ارشيف الفواتير</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-12 my-3">
            @if (session('invoice_sucsess'))
                <div class="alert alert-success" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('invoice_sucsess') }}
                </div>
            @endif
        </div>
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap">
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
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>@php
                                $i = 0;
                            @endphp
                                @foreach ($invoices as $invoice)
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
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    <a class="dropdown-item modal-effect" id="delete_invoice"
                                                        data-effect="effect-scale" data-toggle="modal"
                                                        data-invoice-id="{{ $invoice->id }}"
                                                        data-invoice-number="{{ $invoice->invoice_number }}"
                                                        href="#modaldelte"><i
                                                            class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                        الفاتوره</a>
                                                    <a class="dropdown-item modal-effect" id="cancel_archive_invoice"
                                                        data-effect="effect-scale" data-toggle="modal"
                                                        data-invoice-id="{{ $invoice->id }}"
                                                        data-invoice-number="{{ $invoice->invoice_number }}"
                                                        href="#modaldcancelarchive"><i
                                                            class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل
                                                        الي الفواتير</a>
                                                    <a class="dropdown-item "
                                                        href="{{ route('invoices.print', $invoice['id']) }}"><i
                                                            class="text-dark fas fa-print"></i>&nbsp;&nbsp;طباعة
                                                        الفاتوره</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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


    <!-- Delete modal -->
    <div class="modal" id="modaldelte">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف فاتوره</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="invoices/destroy" method="POST" autocomplete="off">
                        @csrf
                        @method('DELETE')
                        <div class="">
                            <p class="mb-3">هل انت متاكد من عملية حذف الفاتوره ؟</p>
                            <div class="form-group">
                                <input type="hidden" name="id" id="input_invoice_id" class="form-control"
                                    value="">
                                <input type="text" name="invoice_number" class="form-control"
                                    id="input_invoice_number" value="" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                            <button class="btn ripple btn-danger" type="submit">حذف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Basic modal -->
    </div>
    <!-- Delete closed -->
    <!-- Cancel Archive modal -->
    <div class="modal" id="modaldcancelarchive">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title"> الغاء ارشفة الفاتوره</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('invoices.restoreInvoice', 'test') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="">
                            <p class="mb-3">هل انت متاكد من عملية الغاء ارشفة الفاتوره ؟</p>
                            <div class="form-group">
                                <input type="hidden" name="id" id="cancel_archive_invoice_id" class="form-control"
                                    value="">
                                <input type="text" name="invoice_number" class="form-control"
                                    id="cancel_archive_invoice_number" value="" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                            <button class="btn ripple btn-success" type="submit">تاكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Basic modal -->
    </div>
    <!-- Cancel Archive closed -->
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
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <script>
        var allButton_delete = document.querySelectorAll("#delete_invoice");
        //input model Delete
        var input_invoice_id = document.querySelector("#input_invoice_id");
        var invoice_number = document.querySelector("#invoice_number");
        allButton_delete.forEach(element_delete => {
            element_delete.addEventListener('click', () => {
                let vale_id = element_delete.getAttribute('data-invoice-id');
                let vale_number = element_delete.getAttribute('data-invoice-number');
                input_invoice_id.value = vale_id;
                input_invoice_number.value = vale_number;
            })
        });
    </script>
    <script>
        // cancel archive Invoice
        var allButton_cancel_archive = document.querySelectorAll("#cancel_archive_invoice");
        //input model Delete
        var cancel_archive_invoice_id = document.querySelector("#cancel_archive_invoice_id");
        var cancel_archive_number = document.querySelector("#cancel_archive_invoice_number");
        allButton_cancel_archive.forEach(element_cancelarchive => {
            element_cancelarchive.addEventListener('click', () => {
                let cancel_vale_id = element_cancelarchive.getAttribute('data-invoice-id');
                let cancel_vale_number = element_cancelarchive.getAttribute('data-invoice-number');
                cancel_archive_invoice_id.value = cancel_vale_id;
                cancel_archive_number.value = cancel_vale_number;
            })
        });
    </script>
@endsection
