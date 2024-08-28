<!--begin::Sign-in Method-->
<div class="card {{ $class ?? '' }}">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ __('Sign-in Method') }}</h3>
        </div>
    </div>
    <!--end::Card header-->

    <!--begin::Content-->
    <div id="kt_account_signin_method" class="collapse show">
        <!--begin::Card body-->
        <div class="card-body border-top p-9">
            <!--begin::Password-->
            <div class="d-flex flex-wrap align-items-center mb-10">
                <!--begin::Label-->
                <div id="kt_signin_password">
                    <div class="fs-6 fw-bolder mb-1">{{ __('Password') }}</div>
                    <div class="fw-bold text-gray-600">************</div>
                </div>
                <!--end::Label-->

                <!--begin::Edit-->
                <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                    <!--begin::Form-->
                    <form id="kt_signin_change_password" class="form" novalidate="novalidate" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="current_email" value="{{ auth()->user()->email }} "/>
                        <div class="row mb-1">
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="current_password" class="form-label fs-6 fw-bolder mb-3">{{ __('Current Password') }}</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="current_password" id="current_password"/>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="password" class="form-label fs-6 fw-bolder mb-3">{{ __('New Password') }}</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="password" id="password"/>
                                    <p class="error text-danger"></p>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="password_confirmation" class="form-label fs-6 fw-bolder mb-3">{{ __('Confirm New Password') }}</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="password_confirmation" id="password_confirmation"/>
                                    <p class="error text-danger"></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-text mb-5">{{ __('Password must be at least 8 character and contain symbols') }}</div>

                        <div class="d-flex">
                            <button id="kt_password_submit" type="submit" class="btn btn-primary me-2 px-6">
                                @include('partials.general._button-indicator', ['label' => __('Update Password')])
                            </button>
                            <button id="kt_password_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">{{ __('Cancel') }}</button>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Edit-->

                <!--begin::Action-->
                <div id="kt_signin_password_button" class="ms-auto">
                    <button class="btn btn-light btn-active-light-primary">{{ __('Reset Password') }}</button>
                </div>
                <!--end::Action-->
            </div>
            <!--end::Password-->

        </div>
        <!--end::Card body-->
    </div>
    <!--end::Content-->
</div>
<!--end::Sign-in Method-->

<script>
    var passwordMainEl;
    var passwordEditEl;
    var passwordChange;
    var passwordCancel;

    var toggleChangePassword = function () {
        passwordMainEl.classList.toggle('d-none');
        passwordChange.classList.toggle('d-none');
        passwordEditEl.classList.toggle('d-none');
    }
    passwordChange = document.getElementById('kt_signin_password_button');
    passwordEditEl = document.getElementById('kt_signin_password_edit');
    passwordMainEl = document.getElementById('kt_signin_password');
    passwordCancel = document.getElementById('kt_password_cancel');

    passwordCancel.addEventListener('click', function () {
            toggleChangePassword();
        });
    passwordChange.querySelector('button').addEventListener('click', function () {
        toggleChangePassword();
    });
</script>
<script>
    $('#kt_signin_change_password').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            type: 'POST',
            url: "{{ route('settings.changePassword') }}",
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,

            success: function(response) {
                console.log(response);
                if (response.status == 'success') {
                    $('.error').html('');
                    toastr.success(response.msg);
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                if (response.status == 'error') {
                    $('.error').html('');
                    $.each(response.msg, function(key, value) {
                        $(`#${key}`).siblings('p').html(value);
                    });
                }
                if (response.status == 'incorrect') {
                    toastr.error(response.msg);
                }
            }
        });
    });
</script>