@extends('layouts.common')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('/libs/select2/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/libs/select2/css/select2.custom.min.css')}}">
    <style>
        .ks-title {
            min-height: 70px !important;
            height: 70px !important;
        }
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
        }
        .class input:checked+label{
            background-color: #7cafd4;
            border-color: #7cafd4;
            color: #000;
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
    <div class="ks-header">
        <section class="ks-title">
            <h3> {{ $section->full_name }}</h3>
        </section>
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
                    <input type="radio" id="all" value="all" name="class" checked>
                    <label for="all" class="badge badge-primary badge-pill"> Все классы </label>
                    <div class="line-break"></div>
                    <input type="radio" id="kpp" value="kpp" name="class">
                    <label for="kpp" class="badge badge-primary badge-pill"> КПП </label>
                    @for($i=1; $i<=11;$i++)
                        <input type="radio" id="{{ "class $i" }}" value="{{ $i }}" name="class">
                        <label for="{{ "class $i" }}" class="badge badge-primary badge-pill"> {{ "$i класс" }}</label>
                    @endfor
                </div>
            </div>
        </div>

        <div class="card-block">
            <h3>Еще нет материалов для отображения</h3>
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