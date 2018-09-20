<form class="ks-form ks-settings-tab-form ks-notifications" method="post"> <!-- ks-uppercase ks-light -->
    {{ csrf_field() }}
    <h3 class="ks-main-form-header">{{__('user.notifications')}}</h3>

    <div class="form-group row">
        <div class="col-lg-8">
            <div class="ks-fg-header">{{__('user.notifications_settings')}}</div>
            @if (count($errors) > 0)
                <div class="alert alert-danger ks-active-border" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="la la-close"></span>
                    </button>
                    <h5 class="alert-heading">Ошибка</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div id="ks-accordion" class="ks-accordion" role="tablist" aria-multiselectable="true">
                <div class="panel ks-item">
                    <a data-toggle="collapse" data-parent="#ks-accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        {{__('user.actions_notifications')}}
                        <span class="badge badge-default">@{{ notify_count }}</span>
                    </a>
                    <div id="collapseOne" class="panel-collapse in" role="tabpanel" aria-labelledby="collapseOne">
                        <div class="ks-body">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input id="c8" name="notifications[]" value="subscription" type="checkbox" class="custom-control-input" v-model="notifications">
                                    <label class="custom-control-label" for="c8">{{__('user.like_n_subscription')}}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input id="c9" name="notifications[]" value="reply" type="checkbox" class="custom-control-input" v-model="notifications">
                                    <label class="custom-control-label" for="c9">{{__('user.add_reply')}}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input id="c10" name="notifications[]" value="message" type="checkbox" class="custom-control-input" v-model="notifications">
                                    <label class="custom-control-label" for="c10">{{__('user.new_message')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success">{{ __('user.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        new Vue({
            el:"#ks-accordion",
            data: {
                notifications: {!! json_encode($user->notifications) !!}
            },
            computed:{
                notify_count: function () {
                    return this.notifications.length;
                }
            }
        });
    </script>
@endpush