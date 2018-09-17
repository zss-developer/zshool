@if(auth()->check())
    <div class="nav-item dropdown user">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="{{route('user.index')}}" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="ks-avatar {{(Auth::user()->online) ? 'ks-online' : 'ks-offline'}}">
                <img src="{{ Auth::user()->picture }}" width="36" height="36">
            </span>
            <span class="ks-info d-block">
                <span class="ks-name ml-2">{{ Auth::user()->full_name }}</span>
                    <!-- <span class="ks-description">Premium User</span> -->
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Preview">
            <a class="dropdown-item" href="{{route('user.index')}}">
                <span class="la la-user ks-icon"></span>
                <span>Профиль</span>
            </a>
            <a class="dropdown-item" href="#" onclick="document.getElementById('logout-form').submit()">
                <span class="la la-sign-out ks-icon" aria-hidden="true"></span>
                <span>Выйти</span>
            </a>
        </div>
    </div>
@else
    <div class="nav-item dropdown">
        <label for="ks-auth-trigger" class="btn btn-primary ks-rounded btn-sm mb-0 mr-2"><i class="la la-lock"></i> Войти</label>
        <input type="checkbox" id="ks-auth-trigger" {{ (($errors->has('email') || $errors->has('password')) && !$errors->has('register'))? 'checked': '' }}>
        <div class="auth-dropdown">
            <div class="card ks-panel ks-light ks-login">
                <div class="card-block">
                    <form class="form-container" role="form" method="POST" action="{{ route('login') }}">

                        {{ csrf_field() }}

                        <h4 class="ks-header">Вход</h4>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <input type="email" name="email"
                                   class="form-control {{ $errors->has('email') ? 'error' : '' }}"
                                   placeholder="Email">
                            @if ($errors->has('email'))
                                <span class="help-block form-error">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            <input type="password" name="password"
                                   class="form-control {{ $errors->has('password') ? 'error' : '' }}" required
                                   placeholder="Пароль">
                            @if ($errors->has('password'))
                                <span class="help-block form-error">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="ks-text-right">
                                <a href="pages-forgot-password.html">Забыли пароль?</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Войти</button>
                        </div>
                        <div class="ks-text-center">
                            Впервые на нашем сайте? <a href="#" id="signup-btn">Зарегистрироваться</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-item dropdown">
        <label for="ks-help-trigger" class="btn btn-primary ks-rounded btn-sm mb-0" tabindex="-1">
            <i class="la la-user"></i> Регистрация
        </label>
        <div class="nav-item help-desk-btn">
            <input type="checkbox" id="ks-help-trigger" {{ ($errors->has('register'))? 'checked': '' }}>
            <label for="ks-help-trigger" class="ks-help-helper">
                <span class="la la-times-circle ks-icon"></span>
            </label>
            <div class="ks-help-canvas">
                <div class="card panel panel-default ks-light ks-panel ks-signup">
                    <div class="card-block">
                        <form class="form-container" method="POST" action="{{ route('register') }}">

                            {{ csrf_field() }}

                            <h4 class="ks-header">Регистрация</h4>
                            @if ($errors->has('register'))
                                <span class="help-block form-error">{{ $errors->first('register') }}</span>
                            @endif
                            <div class="form-group row {{ ($errors->has('first_name') || $errors->has('last_name')) ? 'has-error' : '' }}">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input type="text" name="first_name" id="first_name"
                                           class="form-control {{ $errors->has('first_name') ? 'error' : '' }}"
                                           required placeholder="Имя" value="{{ old('first_name') }}">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input type="text" name="last_name" id="last_name"
                                           class="form-control {{ $errors->has('last_name') ? 'error' : '' }}"
                                           required placeholder="Фамилия" value="{{ old('last_name') }}">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                <input type="text" name="phone" id="phone"
                                       class="form-control {{ $errors->has('phone') ? 'error' : '' }}"
                                       required placeholder="Телефон" value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                    <span class="help-block form-error">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <input type="email" name="email" id="email"
                                       class="form-control {{ $errors->has('email') ? 'error' : '' }}"
                                       required placeholder="Email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block form-error">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <input type="password" name="password" id="password" class="form-control" required
                                       placeholder="Пароль">
                                @if ($errors->has('password'))
                                    <span class="help-block form-error">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-control" required placeholder="Подтвердите пароль">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
                            </div>
                            <div class="ks-text-center">
                                <span class="text-muted">Нажимая "Зарегистрироваться" я соглашаюсь с </span> <a href="#">првилами сайта</a>
                            </div>
                            <div class="ks-text-center mt-2">
                                У вас уже есть учетная запись?<a href="#" id="login-btn">Войти</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif