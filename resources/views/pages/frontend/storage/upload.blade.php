@extends('layouts.common')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('/libs/select2/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/libs/select2/css/select2.custom.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/styles/widgets/upload.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/libs/trumbowyg/ui/trumbowyg.min.css') }}"> <!-- original -->
    <style>
        textarea {
            z-index: 100;
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
    <div class="ks-page-header">
        <section class="ks-title">
            <h3> Загрузка материалов </h3>
        </section>
    </div>

    <div class="ks-page-content">
        <div class="ks-page-content-body">
            <form class="ks-form container-fluid" method="POST">
                {{ csrf_field() }}

                @if (count($errors) > 0)
                    <div class="alert alert-danger ks-active-border" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true" class="la la-close"></span>
                        </button>
                        <h5 class="alert-heading">{{ __('common.error') }}</h5>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group row ml-0 mr-0 {{ $errors->has('header') ? 'has-error' : '' }}">
                    <label class="form-control-label label-required" for="header">Название разработки</label>
                    <input type="text" class="form-control {{ $errors->has('header') ? 'form-control-danger' : '' }}" name="header" value="{{ old('header') }}">
                </div>

                <div class="form-group row ml-0 mr-0 {{ $errors->has('section') ? 'has-error' : '' }}">
                    <label class="form-control-label label-required col-md-12" for="section">Тип разработки</label>
                    <select name="section" class="form-control col-md-5">
                        <option value="">Выберите тип разработки...</option>
                        @foreach($storage_sections as $item)
                            <option value="{{ $item->id }}" {{ old('section') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row ml-0 mr-0 {{ $errors->has('subject') ? 'has-error' : '' }}">
                    <label class="form-control-label label-required col-md-12" for="subject">Предмет</label>
                    <select name="section" class="form-control col-md-5">
                        <option value="">Выберите предмет...</option>
                        @foreach($subjects as $item)
                            <option value="{{ $item->id }}" {{ old('subject') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <div id="ks-attach-files-widget" class="card panel ks-attach-files-widget">
                        <h5 class="card-header">Прикрепленные файлы</h5>
                        <div class="card-block">
                            <ul class="ks-uploading-files"></ul>
                            <ul class="ks-uploaded-files">
                                <li>
                                    <span class="ks-icon la la-file-pdf-o ks-color-danger"></span>
                                    <div class="ks-body">
                                        <div class="ks-header">
                                            <span class="ks-filename">file.pdf</span>
                                        </div>
                                        <div class="ks-description">
                                            Uploaded by Administrator on April 21, 2016 at 10:28 AM
                                        </div>
                                    </div>
                                    <div class="ks-remove">
                                        <a class="ks-icon la la-trash"></a>
                                    </div>
                                </li>
                            </ul>
                            <div id="ks-file-upload-dropzone" class="ks-upload">
                                <span class="ks-icon la la-cloud-upload"></span>
                                <span class="ks-text">Перетащите файлы сюда, чтобы их прикрепить, или</span>
                                <span class="ks-upload-btn">
                                    <button class="btn btn-primary ks-btn-file">
                                        <span class="la la-cloud-upload ks-icon"></span>
                                        <span class="ks-text">Выберите файл</span>
                                        <input id="ks-file-upload-widget-input" type="file" name="files[]" data-url="" multiple>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Описание раработки</label>
                    <textarea name="description" id="description" class="form-control">{!! old('description') !!}</textarea>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('/libs/select2/js/select2.js')}}"></script>
    <script src="{{asset('/libs/trumbowyg/trumbowyg.min.js')}}"></script>
    <script src="{{asset('/libs/trumbowyg/plugins/base64/trumbowyg.base64.min.js')}}"></script>
    <script src="{{asset('/libs/trumbowyg/plugins/noembed/trumbowyg.noembed.min.js')}}"></script>
    <script src="{{asset('/libs/trumbowyg/langs/ru.min.js')}}"></script>


    <script src="{{asset('/libs/jquery-file-upload/js/load-image.all.min.js')}}"></script>
    <script src="{{asset('/libs/jquery-file-upload/js/canvas-to-blob.min.js')}}"></script>
    <script src="{{asset('/libs/jquery-file-upload/js/vendor/jquery.ui.widget.js')}}"></script>
    <script src="{{asset('/libs/jquery-file-upload/js/jquery.iframe-transport.js')}}"></script>
    <script src="{{asset('/libs/jquery-file-upload/js/jquery.fileupload.js')}}"></script>
    <script src="{{asset('/libs/jquery-file-upload/js/jquery.fileupload-process.js')}}"></script>
    <script src="{{asset('/libs/jquery-file-upload/js/jquery.fileupload-image.js')}}"></script>
    <script src="{{asset('/libs/jquery-file-upload/js/jquery.fileupload-audio.js')}}"></script>
    <script src="{{asset('/libs/jquery-file-upload/js/jquery.fileupload-video.js')}}"></script>
    <script src="{{asset('/libs/jquery-file-upload/js/jquery.fileupload-validate.js')}}"></script>

    <script type="application/javascript">
        (function ($) {
            $(document).ready(function() {

                var configurations = {
                    core: {
                        autogrow: true
                    },
                    plugins: {
                        autogrow: false,
                        btnsDef: {
                            align: {
                                dropdown: ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                                ico: 'justifyLeft',
                                title: 'Выравнивание'
                            }
                        },
                        btns: [
                            ['undo', 'redo'],
                            'btnGrp-design',
                            ['superscript', 'subscript'],
                            ['removeformat'],
                            ['formatting'],
                            ['link'],
                            ['align'],
                            'btnGrp-lists',
                            ['horizontalRule'],
                            ['fullscreen']
                        ],
                        lang: 'ru'
                    }
                };

                $('#description').trumbowyg(configurations.plugins);

                $('select').select2({
                    minimumResultsForSearch: Infinity
                });

                function bytesToSize(bytes) {
                    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                    if (bytes == 0) return '0 Byte';
                    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
                }

                $('#ks-file-upload-widget-input').fileupload({
                    dropZone: $('#ks-file-upload-dropzone'),
                    autoUpload: false,
                    multipart: true,
                    dataType: 'json',
                    singleFileUploads: false,
                    limitMultiFileUploads: 5,
                    limitMultiFileUploadSize: 20000000,
                    add: function (e, data) {
                        var jqXHR;

                        $.each(data.files, function (index, file) {
                            var fileUploadInfo = '<li id="file-uploading-' + file.lastModified + '"> \
                            <span class="ks-icon la la-file-word-o ks-color-info"></span> \
                            <div class="ks-body"> \
                            <div class="ks-header"> \
                            <span class="ks-filename">' + file.name + '</span> \
                            </div> \
                            <div class="ks-progress"> \
                            <div class="progress ks-progress-sm"> \
                            <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div> \
                            </div> \
                            <div class="ks-description"> \
                               \
                            </div> \
                            </div> \
                            </div> \
                            <div class="ks-cancel"> \
                            <a class="ks-icon la la-close"></a> \
                            </div> \
                            </li>';
                            data.context = $(fileUploadInfo).appendTo($('#ks-attach-files-widget .ks-uploading-files'));

                            $(data.context).find(".ks-cancel").click(function() {
                                jqXHR.abort();
                                data.context.remove();
                            })
                        });

                        data.process().done(function () {
                            jqXHR = data.submit();
                        });
                    },
                    progress: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        var size = data.files[0].size;
                        var uploadedBytes = (size / 100) * progress;
                        var id = 'file-uploading-' + data.files[0].lastModified;

                        size = bytesToSize(size);
                        uploadedBytes = bytesToSize(uploadedBytes);

                        $('#' + id).find('.progress-bar').css('width', progress + '%');
                        $('#' + id).find('.ks-description').text(uploadedBytes + ' of ' + size);
                    },
                    done: function (e, data) {
                        $.each(data.files, function (index, file) {
                            var id = 'file-uploading-' + data.files[0].lastModified;
                            $('#' + id).remove();
                        });

                        var uploadedFileInfo = '<li> \
                            <span class="ks-icon la la-file-pdf-o ks-color-danger"></span> \
                            <div class="ks-body"> \
                            <div class="ks-header"> \
                            <span class="ks-filename">' + data.result.file.name + '</span> \
                            </div> \
                            <div class="ks-description"> \
                                '+ data.result.file.uploadedBy +' \
                            </div> \
                            </div> \
                            <div class="ks-remove"> \
                            <a class="ks-icon la la-trash"></a> \
                            </div> \
                            </li>';
                        $(uploadedFileInfo).appendTo($('#ks-attach-files-widget .ks-uploaded-files'));

                        new Noty({
                            text: 'File ' + data.result.file.name + ' has been uploaded successfully!',
                            type   : 'success',
                            theme  : 'mint',
                            layout : 'topRight',
                            timeout: 2000
                        }).show();
                    },
                    fail: function (e, data) {
                        $.each(data.files, function (index, file) {
                            var id = 'file-uploading-' + data.files[0].lastModified;
                            $('#' + id).addClass('ks-file-uploading-error');
                        });

                        new Noty({
                            text: 'Uploading error! Please try again later.',
                            type   : 'error',
                            theme  : 'mint',
                            layout : 'topRight',
                            timeout: 2000
                        }).show();
                    }
                });
                $(document).on('click', '#ks-attach-files-widget .ks-uploaded-files .ks-remove', function () {
                    var file = $(this).closest('li');

                    $.confirm({
                        title: 'Danger!',
                        content: 'Are you sure you want to remove this file?',
                        type: 'danger',
                        buttons: {
                            confirm: {
                                text: 'Yes, remove',
                                btnClass: 'btn-danger',
                                action: function() {
                                    file.remove();
                                }
                            },
                            cancel: function () {}
                        }
                    });
                });

                // DropZone implementation
                $(".ks-attach-files-widget .ks-upload").on('dragover', function (e) {
                    $(this).addClass('ks-dragover');
                }).on('dragleave', function (e) {
                    $(this).removeClass('ks-dragover');
                }).on('drop', function (e) {
                    $(this).removeClass('ks-dragover');
                });

                $(document).bind('drop dragover', function (e) {
                    e.preventDefault();
                });
            });
        })(jQuery);
    </script>
@endpush