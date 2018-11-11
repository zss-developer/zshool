@extends('layouts.common')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('/libs/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/libs/select2/css/select2.custom.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/styles/widgets/upload.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/libs/trumbowyg/ui/trumbowyg.min.css') }}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/sweetalert/sweetalert.css') }}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/libs/sweetalert/sweetalert.min.css') }}">
    <style>
        .textarea {
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
            <form class="ks-form container-fluid pb-0">
                <div class="form-group">
                    <div id="ks-attach-files-widget" class="card panel ks-attach-files-widget">
                        <h5 class="card-header">Прикрепленные файлы</h5>
                        <div class="card-block">
                            <ul class="ks-uploading-files">
                                <li :id="'file-uploading-' + index" v-for="(file,index) in uploading_files">
                                    <span class="ks-icon la la-file-o ks-color-info"></span>
                                    <div class="ks-body">
                                        <div class="ks-header">
                                            <span class="ks-filename">@{{ file.name }}</span>
                                        </div>
                                        <div class="ks-progress">
                                            <div class="progress ks-progress-sm">
                                                <div class="progress-bar progress-bar-striped bg-info" role="progressbar" :style="'width: '+ file.progress+'%'" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="ks-description">
                                                Загружено @{{ stringSize(file.uploaded) }} из @{{ stringSize(file.size) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ks-cancel" @click="cancelFile(index)">
                                        <a class="ks-icon la la-close"></a>
                                    </div>
                                </li>
                            </ul>
                            <ul class="ks-uploaded-files">
                                <li :id="'file-uploaded-' + index" v-for="(file,index) in uploaded_files">
                                    <span class="ks-icon la la-file-o ks-color-danger"></span>
                                    <div class="ks-body">
                                        <div class="ks-header">
                                            <span class="ks-filename">@{{ file.name }}</span>
                                        </div>
                                        <div class="ks-description">
                                            Загружено @{{ file.uploaded  }}
                                        </div>
                                    </div>
                                    <div class="ks-remove" @click="removeFile(index)">
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
                                        <input id="ks-file-upload-widget-input" type="file" name="files[]" data-url="{{ route('xhr.storage.uploadFile') }}" multiple>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form class="ks-form container-fluid pt-0" method="POST">
                {{ csrf_field() }}

                <input type="hidden" name="files[]" :value="file.id" v-for="file in uploaded_files">

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

                <div class="form-group row ml-0 mr-0 {{ $errors->has('title') ? 'has-error' : '' }}">
                    <label class="form-control-label label-required" for="title">Название разработки</label>
                    <input id="title" type="text" class="form-control {{ $errors->has('title') ? 'form-control-danger' : '' }}" name="title" value="{{ old('title   ') }}">
                </div>

                <div class="form-group row ml-0 mr-0 {{ $errors->has('section') ? 'has-error' : '' }}">
                    <label class="form-control-label label-required col-md-12" for="section">Тип разработки</label>
                    <select id="section" name="section" class="form-control col-md-5">
                        <option value="">Выберите тип разработки...</option>
                        @foreach($storage_sections as $item)
                            <option value="{{ $item->id }}" {{ old('section') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row ml-0 mr-0 {{ $errors->has('subject') ? 'has-error' : '' }}">
                    <label class="form-control-label label-required col-md-12" for="subject">Предмет</label>
                    <select id="subject" name="subject" class="form-control col-md-5">
                        <option value="">Выберите предмет...</option>
                        @foreach($subjects as $item)
                            <option value="{{ $item->id }}" {{ old('subject') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row ml-0 mr-0 {{ $errors->has('class') ? 'has-error' : '' }}">
                    <label class="form-control-label label-required col-md-12" for="class">Класс</label>
                    <select id="class" name="class" class="form-control col-md-5">
                        <option value="0" {{ old('class') == 0 ? 'selected' : '' }}>КПП</option>
                        @for($i=1; $i<=11;$i++)
                            <option value="{{ $i }}" {{ old('class') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
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
    <script src="{{asset('/libs/sweetalert/sweetalert.min.js')}}"></script>

    <script type="application/javascript">

        var widget = new Vue({
           el: '.ks-page-content',
           data: {
               uploading_files: [],
               uploaded_files: {!! session('files') ? json_encode(session('files')) : '[]'  !!},
           },
            watch: {
               uploaded_files: function () {
                   $('#files').val(JSON.stringify(this.uploaded_files.map(a => a.id)));
               }
            },
            methods: {
                stringSize: function (bytes) {
                    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                    if (bytes == 0) return '0 Byte';
                    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
                },
                uploadFile: function(file) {
                    this.uploading_files.push(file);
                },
                updateFile: function(key,value) {
                    $.each(this.uploading_files,function (index,item) {
                       if (item.key == key) {
                           item.uploaded = value;
                           item.progress = parseInt(item.uploaded / item.size * 100, 10);
                           return false;
                       }
                    });
                },
                setJqXHR: function (key, jqXHR) {
                    $.each(this.uploading_files,function (index,item) {
                        if (item.key == key) {
                            item.jqXHR = jqXHR;
                            return false;
                        }
                    });
                },
                completeFile: function(key, file) {
                    var self = this;
                    $.each(this.uploading_files,function (index,item) {
                        if (item.key == key) {
                            self.uploading_files.splice(index,1);
                            return false;
                        }
                    });
                    this.uploaded_files.push(file);
                },
                cancelFile: function (index) {
                    if (this.uploading_files[index].jqXHR != null) {
                        this.uploading_files[index].jqXHR.abort();
                    }
                    this.uploading_files.splice(index, 1);
                },
                removeFile: function (index) {
                    var self = this;
                    swal({
                            title: 'Внимание!',
                            text:  'Вы действительно хотите удалить файл?',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Да, удалить",
                            cancelButtonText: "Отмена",
                            closeOnConfirm: true,
                        },
                        function(){
                            $.ajax({
                                type:'POST',
                                url: '{{ route('xhr.storage.deleteFile') }}',
                                data:{
                                    '_token': '{{ csrf_token() }}',
                                    'id': self.uploaded_files[index].id,
                                },
                                dataType: 'json',
                                success:function(data){
                                    self.uploaded_files.splice(index, 1);
                                },
                                error: function(data){
                                    swal("Упс!", "Не удалось удалить файл, попробуйте позднее", "warning");
                                }
                            });

                        });
                }

            },

        });

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

                $('#ks-file-upload-widget-input').fileupload({
                    autoUpload: false,
                    add: function (e, data) {
                        $.each(data.files, function (index, file) {
                            /*if(uploaded_files.length == 5) {
                               swal("Внимание!", "Загрузить можно не более 5-ти файлов", "warning");
                            }*/
                            var item = {
                                'name'     :  file.name,
                                'size'     : file.size,
                                'uploaded' : 0,
                                'progress' : 0,
                                'key'      : file.lastModified,
                                'jqXHR'    : null
                            };
                            widget.uploadFile(item);
                        });

                        data.process().done(function () {
                            var jqXHR = data.submit();
                            widget.setJqXHR(data.files[0].lastModified, jqXHR);
                        });
                    },
                    submit: function (e, data) {
                        data.formData = {'_token' : '{{ csrf_token() }}'};
                    },
                    progress: function (e, data) {
                        widget.updateFile(data.files[0].lastModified, data.loaded);
                    },
                    done: function (e, data) {
                        $.each(data.result.files, function (index, file) {
                            $.each(data.files,function (item_index,item) {
                               if (item.name === file.name) {
                                   widget.completeFile(item.lastModified, file);
                               }
                            });
                        });
                    },
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