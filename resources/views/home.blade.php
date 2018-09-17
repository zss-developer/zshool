@extends('layouts.common')

@push('left-sidebar')
    @include('layouts.left-sidebar')
@endpush

@push('right-sidebar')
    @include('layouts.right-sidebar')
@endpush

@push('styles')
    <style>
        .ks-header h3 {
            font-weight: 500;
        }
        strong {
            font-weight: bold !important;
        }
        ul.tasks {
            list-style-type: circle;
        }
        ul.tasks li {
            font-size: 1rem;
            margin-bottom: 0.3rem;
        }
    </style>
@endpush

@section('content')
    <div class="ks-content">
        <div class="ks-body">
            <div class="container-fluid">
                <div class="ks-header">
                    <h2 class="ks-text-center mt-0 mb-4"> Приветствуем вас на сайте для учителей </h3>
                </div>
                <div class="card card-block">
                    <p class="lead ks-text-center">Этот сайт был создан в рамках государственной программы <strong> <em> «Цифровой Казахстан» </em> </strong></p>
                    <h4 class="mb-2" >Цель проекта:</h4>
                    <p class="lead">Создание единого информационного пространства, доступного для каждого педагога Костанайской области.</p>

                    <h4 class="mb-2" >Задачи проекта:</h4>
                    <ul class="tasks">
                        <li>Обеспечение методической поддержки внедрения цифровых образовательных ресурсов и инструментов в педагогическую практику.</li>
                        <li>Обмен опытом в области применения новых образовательных технологий.</li>
                        <li>Создание механизмов и сервисов для взаимодействия педагогов области.</li>
                        <li>Создание базы данных методических, образовательных продуктов для применения на уроках и во внеурочной деятельности.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


@endsection