@extends('layouts.common')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/styles/profile/settings.css')}}">
@endpush

@section('content')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>{{ __('user.profile') }}</h3>
        </section>
    </div>

    <div class="ks-page-content">
        <div class="ks-page-content-body ks-profile">
            <div class="ks-profile-header">
                <div class="ks-profile-header-user">
                    <div class="ks-avatar">
                        <img src="{{ Auth::user()->picture }}" class="ks-avatar" width="100" height="100">
                    </div>
                    <div class="ks-info">
                        <div class="ks-name">{{$user->first_name}} {{$user->last_name}}</div>
                        <div class="ks-description">{{($user->location) ? $user->location->name : ''}}</div>
                        <div class="ks-rating">
                            <i class="la la-star ks-star" aria-hidden="true"></i>
                            <i class="la la-star ks-star" aria-hidden="true"></i>
                            <i class="la la-star ks-star" aria-hidden="true"></i>
                            <i class="la la-star ks-star" aria-hidden="true"></i>
                            <i class="la la-star-half-o-disabled la-star ks-star" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ks-tabs-container ks-tabs-default ks-tabs-no-separator ks-full ks-light">
                <ul class="nav ks-nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-toggle="tab" data-target="#settings" aria-expanded="false">{{ __('user.settings') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="settings" role="tabpanel" aria-expanded="false">
                        <div class="ks-settings-tab">

                            <div class="ks-menu">
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="nav-item">
                                        <a class="nav-link {{Route::is('user.index') ? 'active' : ''}}" href="{{route('user.index')}}">{{ __('user.common') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{Route::is('user.settings.contacts') ? 'active' : ''}}" href="{{route('user.settings.contacts')}}">{{ __('user.contacts') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{Route::is('user.settings.security') ? 'active' : ''}}" href="{{route('user.settings.security')}}">{{ __('user.security') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{Route::is('user.settings.notifications') ? 'active' : ''}}" href="{{route('user.settings.notifications')}}">{{ __('user.notifications') }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="ks-settings-form-wrapper">
                                @include($view)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
