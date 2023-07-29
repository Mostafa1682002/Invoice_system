@extends('layouts.master')
@section('title')
    المنتجات
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
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
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/المنتجات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-12 my-3">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            @if (session('success_products'))
                <div class="alert alert-success" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('success_products') }}
                </div>
            @endif
        </div>
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="col-sm-6 col-md-4 col-xl-3">
                        @can('اضافة منتج')
                            <a class="modal-effect btn btn-primary btn-block" data-effect="effect-scale" data-toggle="modal"
                                href="#modaldemo8"><i class="fas fa-plus ml-1"></i>اضافة منتج
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">اسم المنتج</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">معلومات المنتج</th>
                                    <th class="border-bottom-0">تاريخ انشاء المنتج</th>
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->section->section_name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            @can('تعديل منتج')
                                                <a class="modal-effect btn btn-primary btn-sm" id="edite_products"
                                                    data-effect="effect-scale" data-toggle="modal" href="#modaldemo88"
                                                    data-id='{{ $product->id }}'
                                                    data-product-name='{{ $product->product_name }}'
                                                    data-section-name={{ $product->section_id }}
                                                    data-description='{{ $product->description }}'>تعديل</a>
                                            @endcan
                                            @can('حذف منتج')
                                                <a class="modal-effect btn btn-danger btn-sm" id="delete_products"
                                                    data-effect="effect-scale" data-toggle="modal" href="#modaldemo888"
                                                    data-product-name-delete='{{ $product->product_name }}'
                                                    data-id='{{ $product->id }}'>حذف</a>
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
        <!--/div-->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->



    <!-- Add Product -->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">انشاء منتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <label for="exampleInputName">اسم المنتج</label>
                                <input type="text" name="product_name" class="form-control" id="exampleInputName"
                                    placeholder="" value="{{ old('product_name') }}">
                                @error('product_name')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName">القسم</label>
                                <div class="mg-t-20 mg-lg-t-0">
                                    <select class="form-control select2" id="exampleInputName" name="section_id" required>
                                        <option label="--حدد القسم--">
                                        </option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section['id'] }}">
                                                {{ $section['section_name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('section_id')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputDescription">معلومات المنتج</label>
                                <textarea name="description" class="form-control" id="exampleInputDescription">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit">اضافه</button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Basic modal -->


    </div>
    <!-- main-content closed -->
    <!-- Edite modal -->
    <div class="modal" id="modaldemo88">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل منتج</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="products/update" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="">
                            <div class="form-group">
                                <input type="hidden" name="id" id="product_id" class="form-control"
                                    value="">
                            </div>
                            <div class="form-group">
                                <label for="new_name_product">اسم المنتج</label>
                                <input type="text" name="product_name" class="form-control" id="new_name_product"
                                    placeholder="" value="">
                            </div>
                            <div class="form-group">
                                <label for="new_name_section">القسم</label>
                                <div class="mg-t-20 mg-lg-t-0">
                                    <select class="form-control select2" id="new_name_section" name="section_id"
                                        required>
                                        <option label="--حدد القسم--">
                                        </option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section['id'] }}">
                                                {{ $section['section_name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new_description">معلومات المنتج</label>
                            <textarea name="description" class="form-control" id="new_description"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                    <button class="btn ripple btn-primary" type="submit">تعديل</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Basic modal -->


    </div>
    <!-- Edite closed -->
    <!-- Delete modal -->
    <div class="modal" id="modaldemo888">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف قسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="products/destroy" method="POST" autocomplete="off">
                        @csrf
                        @method('DELETE')
                        <div class="">
                            <div class="form-group">
                                <input type="hidden" name="id" id="input_product_id" class="form-control"
                                    value="">
                            </div>
                            <p class="mb-3">هل انت متاكد من حذف المنتج ؟</p>
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" id="input_name_product_delete"
                                    placeholder="" value="" readonly>
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
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
    {{-- Edite Section JS --}}
    <script>
        var allProductsEdite = document.querySelectorAll('#edite_products');
        //Select All Input
        var new_product_id = document.querySelector('#product_id');
        var new_product_name = document.querySelector('#new_name_product');
        var new_section_name = document.querySelector('#new_name_section');
        var new_description = document.querySelector('#new_description');
        allProductsEdite.forEach(product_edite => {
            product_edite.addEventListener('click', function() {
                var product_id = product_edite.getAttribute('data-id');
                var product_name = product_edite.getAttribute('data-product-name');
                var section_name = product_edite.getAttribute('data-section-name');
                var product_description = product_edite.getAttribute('data-description');

                //Pass Value To Input
                new_product_id.value = product_id;
                new_product_name.value = product_name;
                new_section_name.value = section_name;
                new_description.value = product_description;
            })
        })
    </script>
    {{-- Delete Section JS --}}
    <script>
        var allProducts = document.querySelectorAll('#delete_products');

        var input_product_id = document.querySelector('#input_product_id');
        var input_name_product_delete = document.querySelector('#input_name_product_delete');
        allProducts.forEach(product_delete => {
            product_delete.addEventListener('click', function() {
                var product_id = product_delete.getAttribute('data-id');
                var product_name_delete = product_delete.getAttribute('data-product-name-delete');
                //Pass Value To Input
                input_product_id.value = product_id;
                input_name_product_delete.value = product_name_delete;
            })
        });
    </script>
@endsection
