@extends('layouts.common')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('/libs/select2/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/libs/select2/css/select2.custom.min.css')}}">
    <style>

        .subject {
            padding: 20px;
        }
        .class {
            padding: 5px 0;
            margin: 0 -2px;
            display: flex;
            flex-wrap: wrap;
        }
        .line-break {
            width: 100%;
        }
        .class input {
            display: none;
        }
        .class label {
            margin: 0 2px 5px;
            cursor: pointer;
        }
        .class input:checked+label{
            background-color: #7cafd4;
            border-color: #7cafd4;
            color: #000;
        }
        .publication {
            padding-left: 20px;
        }
        .publication:hover {
            background-color: #ebeef5;
        }
        .publication .ks-icon {
            font-size: 46px;
            margin: 0 auto;
            padding: 15px 0;
        }
        .publication .card-title{
            color: #21577f;
            font-weight: bold;
        }
        .publication .info {
            text-align: right;
            color:#979797;
        }
        .publication .info i {
            margin-left: 10px;
            font-weight: bold;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
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
            <h3>{{ $section->full_name }}</h3>
        </section>
    </div>

    <div class="ks-page-content">
        <div class="ks-page-content-body">
            <div class="card-block">
                <div class="form-group row mb-0">
                    <label for="subject" class="col-md-2 form-control-label">Предмет:</label>
                    <div class="col-md-4">
                        <select id="subject" name="subject" class="form-control">
                            <option value="">Выберите предмет...</option>
                            <option value="all">Все предметы</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <div class="class">
                        <input type="radio" id="all" value="" name="class" checked>
                        <label for="all" class="badge badge-primary badge-pill"> Все классы </label>
                        <div class="line-break"></div>
                        <input type="radio" id="kpp" value="0" name="class">
                        <label for="kpp" class="badge badge-primary badge-pill"> КПП </label>
                        @for($i=1; $i<=11;$i++)
                            <input type="radio" id="{{ "class-$i" }}" value="{{ $i }}" name="class">
                            <label for="{{ "class-$i" }}" class="badge badge-primary badge-pill"> {{ "$i класс" }}</label>
                        @endfor
                    </div>
                </div>
            </div>

            <div class="card-block">
                @if($publications->count())
                    @foreach($publications as $publication)
                        <a href="{{ route('storage.view', [$section->code, $publication->id]) }}" class="card publication">
                            <div class="row">
                                <div class="col-md-1 ks-text-center">
                                    <span class="ks-icon la la-file-o ks-color-danger"></span>
                                </div>
                                <div class="card-block col-md-10">
                                    <h5 class="card-title mb-1">{{ $publication->title }}</h5>
                                    <p class="card-text">{{ strlen($publication->description)>200 ? mb_substr($publication->description,0,200).'...' : $publication->description}}</p>
                                    <div class="info">
                                        <i class="la la-clock-o"></i> {{ $publication->created_at }}
                                        <i class="la la-user"></i>{{ $publication->author->full_name }}
                                        <i class="la la-eye"></i>10
                                        <i class="la la-download"></i>0
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                        {{ $publications->render() }}

                @else
                    <h3>Еще нет материалов для отображения</h3>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('/libs/select2/js/select2.js')}}"></script>
    <script type="application/javascript">
        (function ($) {
            $(document).ready(function() {
                $('select').select2({
                    minimumResultsForSearch: Infinity
                });
            });
        })(jQuery);
    </script>
@endpush