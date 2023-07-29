@extends('layouts.master')
@section('title')
    الاقسام
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
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/الاقسام</span>
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
            @if (session('success_sections'))
                <div class="alert alert-success" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('success_sections') }}
                </div>
            @endif
        </div>
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="col-sm-6 col-md-4 col-xl-3">
                        @can('اضافة قسم')
                            <a class="modal-effect btn btn-primary btn-block" data-effect="effect-scale" data-toggle="modal"
                                href="#modaldemo8"><i class="fas fa-plus ml-1"></i>اضافة قسم</a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">اسم القسم</th>
                                    <th class="border-bottom-0">معلومات القسم</th>
                                    <th class="border-bottom-0">منشا القسم</th>
                                    <th class="border-bottom-0">تاريخ انشاء القسم</th>
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($sections as $section)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $section['section_name'] }}</td>
                                        <td>{{ $section['description'] }}</td>
                                        <td>{{ $section['created_by'] }}</td>
                                        <td>{{ $section['created_at'] }}</td>
                                        <td>
                                            @can('تعديل قسم')
                                                <a class="modal-effect btn btn-primary btn-sm" id="edite_section"
                                                    data-effect="effect-scale" data-toggle="modal" href="#modaldemo88"
                                                    data-id='{{ $section['id'] }}'
                                                    data-section-name='{{ $section['section_name'] }}'
                                                    data-description='{{ $section['description'] }}'>تعديل</a>
                                            @endcan
                                            @can('حذف قسم')
                                                <a class="modal-effect btn btn-danger btn-sm" id="delete_section"
                                                    data-effect="effect-scale" data-toggle="modal" href="#modaldemo888"
                                                    data-section-name-delete='{{ $section['section_name'] }}'
                                                    data-id='{{ $section['id'] }}'>حذف</a>
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



    <!-- Basic modal -->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">انشاء قسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sections.store') }}" method="POST">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <input type="hidden" name="created_by" class="form-control" placeholder=""
                                    value="{{ auth()->user()->name }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName">اسم القسم</label>
                                <input type="text" name="section_name" class="form-control" id="exampleInputName"
                                    placeholder="" value="{{ old('section_name') }}">
                                @error('section_name')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputDescription">الملاحظات</label>
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
                    <h6 class="modal-title">تعديل قسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="sections/update" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="">
                            <div class="form-group">
                                <input type="hidden" name="id" id="section_id" class="form-control"
                                    value="">
                            </div>
                            <div class="form-group">
                                <label for="new_name_section">اسم القسم</label>
                                <input type="text" name="section_name" class="form-control" id="new_name_section"
                                    placeholder="" value="">
                            </div>
                            <div class="form-group">
                                <label for="new_description">الملاحظات</label>
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
                    <form action="sections/destroy" method="POST" autocomplete="off">
                        @csrf
                        @method('DELETE')
                        <div class="">
                            <div class="form-group">
                                <input type="hidden" name="id" id="input_section_id" class="form-control"
                                    value="">
                            </div>
                            <p class="mb-3">هل انت متاكد من حذف القسم ؟</p>
                            <div class="form-group">
                                <input type="text" name="section_name" class="form-control" id="input_name_section"
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
        var allSections = document.querySelectorAll('#edite_section');
        var new_section_id = document.querySelector('#section_id');
        var new_section_name = document.querySelector('#new_name_section');
        var new_description = document.querySelector('#new_description');
        allSections.forEach(section_edite => {
            section_edite.addEventListener('click', function() {
                var section_id = section_edite.getAttribute('data-id');
                var section_name = section_edite.getAttribute('data-section-name');
                var section_description = section_edite.getAttribute('data-description');
                //Pass Value To Input
                new_section_id.value = section_id;
                new_section_name.value = section_name;
                new_description.value = section_description;
            })
        });
    </script>
    {{-- Delete Section JS --}}
    <script>
        var allSections = document.querySelectorAll('#delete_section');
        var input_section_id = document.querySelector('#input_section_id');
        var input_name_section = document.querySelector('#input_name_section');
        allSections.forEach(section_delete => {
            section_delete.addEventListener('click', function() {
                var section_id = section_delete.getAttribute('data-id');
                var section_name_delete = section_delete.getAttribute('data-section-name-delete');
                //Pass Value To Input
                input_section_id.value = section_id;
                input_name_section.value = section_name_delete;
            })
        });
    </script>
@endsection
