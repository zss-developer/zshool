<form class="ks-form ks-settings-tab-form ks-notifications"> <!-- ks-uppercase ks-light -->
    <h3 class="ks-main-form-header">{{__('user.notifications')}}</h3>

    <div class="form-group row">
        <div class="col-lg-8">
            <div class="ks-fg-header">{{__('user.notifications_settings')}}</div>
            <div id="ks-accordion" class="ks-accordion" role="tablist" aria-multiselectable="true">
                <div class="panel ks-item">
                    <a data-toggle="collapse" data-parent="#ks-accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        {{__('user.actions_notifications')}}

                        <span class="badge badge-default">0</span>
                    </a>
                    <div id="collapseOne" class="panel-collapse in" role="tabpanel" aria-labelledby="collapseOne">
                        <div class="ks-body">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input id="c8" type="checkbox" class="custom-control-input">
                                    <label class="custom-control-label" for="c8">{{__('user.like_n_subscription')}}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input id="c9" type="checkbox" class="custom-control-input">
                                    <label class="custom-control-label" for="c9">{{__('user.add_reply')}}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input id="c10" type="checkbox" class="custom-control-input">
                                    <label class="custom-control-label" for="c10">{{__('user.new_message')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>