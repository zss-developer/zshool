<form class="ks-form ks-settings-tab-form" action="{{route('user.settings.security')}}" method="POST"> <!-- ks-uppercase ks-light -->
    <h3 class="ks-form-main-header">{{ __('user.security') }}</h3>

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

    @if(session()->has('message'))
        <div class="alert alert-success ks-active-border" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" class="la la-close"></span>
            </button>
            {{ session()->get('message') }}
        </div>
    @endif

    {!! csrf_field()  !!}

    <div class="form-group row">
        <div class="col-lg-6">
            <label>{{ __('user.current_password') }}</label>
            <input type="password" class="form-control {{ $errors->has('password') ? 'form-control-danger' : '' }}" name="password" placeholder="">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-6">
            <label>{{ __('user.new_password') }}</label>
            <input type="password" class="form-control {{ $errors->has('new_password') ? 'form-control-danger' : '' }}" name="new_password" placeholder="">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-6">
            <label>{{ __('user.confirm_new_password') }}</label>
            <input type="password" class="form-control" name="new_password_confirmation" placeholder="">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-12">
            <button type="submit" class="btn btn-success">{{ __('user.save') }}</button>
        </div>
    </div>
</form>