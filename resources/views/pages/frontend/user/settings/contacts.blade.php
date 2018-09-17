@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('/libs/select2/css/select2.min.css')}}"> <!-- Original -->
    <link rel="stylesheet" type="text/css" href="{{asset('/libs/select2/css/select2.custom.min.css')}}">
@endpush

<form class="ks-form ks-settings-tab-form" action="{{route('user.settings.contacts')}}" method="POST"> <!-- ks-uppercase ks-light -->
    <h3 class="ks-form-main-header">{{ __('user.contact_information') }}</h3>

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
        <div class="col-lg-4">
            <label>{{ __('user.first_name') }}</label>
            <input type="text" class="form-control {{ $errors->has('first_name') ? 'form-control-danger' : '' }}" name="first_name" placeholder="" value="{{ (old('first_name')) ? old('first_name') : $user->first_name}}">
        </div>
        <div class="col-lg-4">
            <label>{{ __('user.last_name') }}</label>
            <input type="text" class="form-control {{ $errors->has('last_name') ? 'form-control-danger' : '' }}" name="last_name" placeholder="" value="{{ (old('last_name')) ? old('last_name') : $user->last_name}}">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-4">
            <label>{{ __('user.email') }}</label>
            <input type="email" class="form-control {{ $errors->has('email') ? 'form-control-danger' : '' }}" name="email" placeholder="" value="{{ (old('email')) ? old('email') : $user->email}}">
        </div>
        <div class="col-lg-4">
            <label>{{ __('user.phone') }}</label>
            <input type="text" class="form-control {{ $errors->has('phone') ? 'form-control-danger' : '' }}" name="phone" placeholder="+7(999)999-9999" value="{{ (old('phone')) ? old('phone') : $user->phone}}">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <label>{{ __('user.country') }}</label>
                    <select name="country" id="country" class="form-control" value="{{old('country')}}">
                        <option value="">{{__('user.choose_a_country')}}...</option>
                        @foreach($countries as $country)
                            <option value="{{$country->id}}" {{ (old('country') == $country->id || $user->location->parent_id == $country->id ? 'selected' : '') }}>{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <label>{{ __('user.city') }}</label>
                    <select name="city" id="city" class="form-control {{ $errors->has('city') ? 'error' : '' }}">
                        <option value="">{{__('business.choose_your_city')}}...</option>
                        <option value="{{$user->location_id }}" selected="selected">{{$user->location->name}}</option>

                    </select>
                    @if ($errors->has('city'))
                        <span class="help-block form-error">{{ $errors->first('city') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-8">
            <label>{{ __('user.about') }}</label>
            <textarea class="form-control {{ $errors->has('about') ? 'form-control-danger' : '' }}" name="about" rows="4">{{ (old('about')) ? old('about') : $user->about}}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-12">
            <button type="submit" class="btn btn-success">{{ __('user.save') }}</button>
        </div>
    </div>
</form>

@push('scripts')
    <script src="{{asset('/libs/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('/libs/jquery-mask/jquery.mask.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('select').select2({
                minimumResultsForSearch: Infinity
            });
            $('#city').select2({
                ajax: {
                    url: "{{route('xhr.cities')}}",
                    type: "get",
                    dataType: 'json',
                    data: function(params) {
                        let id = ($('#country').val() === undefined) ? 0 : $('#country').val();
                        var query= {
                            country_id: id,
							term: params.term,
                        };
                        return query;
                    },
                    processResults: function (data) {
                        if (data.message) {
                            return {
                                results: [
                                    {
                                        text: data.message,
                                        id: 1,
                                    },
                                ],
                            };
                        }
                        let arr =  $.map(data.cities, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        });

                        return {
                            results: arr
                        };
                    }
                },
            });

            $('input[name="phone"]').mask('+7(999)999-9999');
        });
    </script>
@endpush