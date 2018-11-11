@extends('layouts.common')

@push('styles')
    <style>
        .card {
            border: none;
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

        </div>
    </div>
@endsection

@push('scripts')

@endpush