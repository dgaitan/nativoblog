<!-- Modal -->
<div class="modal fade" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="editAccountModalForm" method="PUT" action="{{ route('app.account.update') }}">
            <div class="modal-header">
                <h5 class="modal-title" id="editAccountModalLabel">Update My Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf

                {{-- Success --}}
                <div id="editAccountModalNotices" class="col-12" style="display: none">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <p class="alert-content"></p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>

                {{-- Error --}}
                <div id="editAccountModalErrors" class="col-12" style="display: none">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <p class="alert-content"></p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="name">
                        {{ __('First Name') }}
                    </label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                    <div id="invalid-message-name" class="invalid-feedback" style="display:none"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="last_name">
                        {{ __('Last Name') }}
                    </label>
                    <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required>
                    <div id="invalid-message-last_name" class="invalid-feedback" style="display:none"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="email">
                        {{ __('Email') }}
                    </label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                    <div id="invalid-message-email" class="invalid-feedback" style="display:none"></div>
                </div>
                <hr>
                <p class="text-muted">If you want to update accounts password, fill these fields. Otherwise, leave it empty.</p>
                <div class="form-group mb-3">
                    <label for="current_password">
                        {{ __('Current Password') }}
                    </label>
                    <input id="current_password" type="password" class="form-control is-password" name="current_password" value="" />
                    <div id="invalid-message-current_password" class="invalid-feedback" style="display:none"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="password">
                        {{ __('New Password') }}
                    </label>
                    <input id="password" type="password" class="form-control is-password" name="password" value="" />
                    <div id="invalid-message-password" class="invalid-feedback" style="display:none"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="password_confirmation">
                        {{ __('Confirm Password') }}
                    </label>
                    <input id="password_confirmation" type="password" class="form-control is-password" name="password_confirmation" value="" />
                    <div id="invalid-message-password_confirmation" class="invalid-feedback" style="display:none"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="editAccountModalFormButton" class="btn btn-primary text-white">Save changes</button>
            </div>
        </form>
    </div>
</div>