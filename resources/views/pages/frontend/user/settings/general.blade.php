<form class="ks-form ks-settings-tab-form ks-general" action="{{route('xhr.user.picture.change')}}" method="POST"> <!-- ks-uppercase ks-light -->
    <h3 class="ks-main-form-header">
        {{ __('user.common') }}
    </h3>

    {{ csrf_field() }}

    <div class="ks-manage-avatar ks-group">
        <img class="ks-avatar" src="{{ $user->picture }}" width="100" height="100">
        <div class="ks-manage-avatar-body">
            <div class="ks-manage-avatar-body-header">{{ __('user.avatar') }}</div>
            <div class="ks-manage-avatar-body-description">
                {{ __('user.avatar_recommended') }}

            </div>
            <div class="ks-manage-avatar-body-controls">
                <button class="btn btn-primary ks-btn-file">
                    <span class="la la-upload ks-icon"></span>
                    <span class="ks-text">{{ __('user.upload') }}</span>
                    <input type="file" class="image" name="image" id="image">
                </button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        $(document).ready(function (e) {
            $('.ks-form').on('submit',(function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    type:'POST',
                    url: $(this).attr('action'),
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        location.reload();
                    },
                    error: function(data){

                    }
                });
            }));

            $("#image").on("change", function() {
                $(".ks-form").submit();
            });
        });
    </script>
@endpush