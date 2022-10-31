<!-- Modal -->
<div class="modal fade" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editAccountModalLabel">Update My Account</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="name">
                        {{ __('First Name') }}
                    </label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="last_name">
                        {{ __('Last Name') }}
                    </label>
                    <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email">
                        {{ __('Email') }}
                    </label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                </div>
                <hr>
                <p class="text-muted">If you want to update accounts password, fill these fields. Otherwise, leave it empty.</p>
                <div class="form-group mb-3">
                    <label for="password">
                        {{ __('Current Password') }}
                    </label>
                    <input id="password" type="password" class="form-control" name="password" value="" />
                </div>
                <div class="form-group mb-3">
                    <label for="new_password">
                        {{ __('New Password') }}
                    </label>
                    <input id="new_password" type="password" class="form-control" name="new_password" value="" />
                </div>
                <div class="form-group mb-3">
                    <label for="confirm_password">
                        {{ __('Confirm Password') }}
                    </label>
                    <input id="confirm_password" type="password" class="form-control" name="confirm_password" value="" />
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary text-white">Save changes</button>
        </div>
      </div>
    </div>
</div>