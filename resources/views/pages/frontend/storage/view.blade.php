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
        .service .about, .service .published {
            display: flex;
            flex-direction: column;
        }
        .service .about span span, .service .published span span{
            color: #0000F0;
        }
        .alert {
            margin: 10px 40px;
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
                            @foreach($publication->files as $file)
                                <li class="ks-item ks-item-file">
                                    <span class="ks-thumb la {{ mimeToIcon($file->mime) }}"></span>
                                    <span class="ks-filename">{{ $file->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger ks-active-border" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="la la-close"></span>
                    </button>
                    <h5 class="alert-heading">Ошибка</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="service">
                <div class="about">
                    <span>Предмет: <span>{{ $publication->subject->name }}</span></span>
                    <span>Категория: <span>{{ $publication->section->name }}</span></span>
                    <span>Целевая аудитория: <span>{{ ($publication->class == 0) ? 'КПП' : $publication->class.' класс' }}</span></span>
                </div>
                <div class="download">
                    <a href="{{ route('storage.download', ['id' => $publication->id]) }}" class="btn btn-primary download">Скачать одним архивом</a>
                </div>
                <div class="published">
                    <span>Автор: <span>{{ $publication->author->full_name }}</span></span>
                    <span>Дата: <span>{{ $publication->created_at->format('d.m.Y') }}</span></span>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush