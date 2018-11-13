@extends('layouts.common')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/styles/apps/file-manager.min.css') }}">
    <style>
        .card {
            border: none;
        }
        .ks-content {
            border-bottom: 1px solid #dee0e1;
        }
        .service {
            padding: 10px 40px;
            display: flex;
            justify-content: space-between;
        }
    </style>
@endpush

@push('left-sidebar')
    @include('layouts.left-sidebar')
@endpush

@push('right-sidebar')
    @include('layouts.right-sidebar')
@endpush

@section('content')
    <div class="ks-page-content">
        <div class="ks-page-content-body">
            <div class="card text-center">
                <div class="card-block">
                    <h3 class="card-tile">{{ $publication->title }}</h3>
                    <p class="card-text"> {{ $publication->description }}</p>
                </div>
            </div>
            <div class="ks-filemanager-page">
                <div class="ks-files">
                    <div class="ks-header pb-0">
                        <h4>Прикрепленные файлы</h4>
                    </div>
                    <div class="ks-content pt-0 pb-0">
                        <ul class="ks-items">
                            <li class="ks-item ks-item-file">
                                <span class="ks-thumb la la-file-excel-o text-success"></span>
                                <span class="ks-filename">File.xls</span>
                            </li>
                            <li class="ks-item ks-item-file">
                                <span class="ks-thumb la la-file-powerpoint-o text-warning"></span>
                                <span class="ks-filename">File.ppt</span>
                            </li>
                            <li class="ks-item ks-item-file">
                                <span class="ks-thumb la la-file-pdf-o text-danger"></span>
                                <span class="ks-filename">File.pdf</span>
                            </li>
                            <li class="ks-item ks-item-file">
                                <span class="ks-thumb la la-file-word-o text-info"></span>
                                <span class="ks-filename">File.doc</span>
                            </li>
                            <li class="ks-item ks-item-file">
                                <span class="ks-thumb la la-file-archive-o text-brown"></span>
                                <span class="ks-filename">File.zip</span>
                            </li>
                            <li class="ks-item ks-item-file">
                                <span class="ks-thumb la la-file-text-o text-info"></span>
                                <span class="ks-filename">File.txt</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="service">
                <div class="about">
                    Предмет<br>
                    Категория<br>
                    Целевая аудитория
                </div>
                <div class="download">
                    Скачать
                </div>
                <div class="author">
                    Автор<br>
                    Дата
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush