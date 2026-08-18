@extends('admin.layout')
@section('title', 'My Account')
@section('content')

@if(session('success'))
    <div class="alert alert-success" data-testid="account-success"><i class="fas fa-circle-check"></i> {{ session('success') }}</div>
@endif

<div class="card" style="margin-bottom:1.5rem;">
    <div class="card-header">
        <div>
            <h2>Account Details</h2>
            <p class="text-muted" style="margin:.2rem 0 0;font-size:.85rem;">Update your name and login email.</p>
        </div>
    </div>
    <form method="POST" action="{{ route('admin.account.update') }}">
        @csrf @method('PUT')
        <div class="form-row">
            <div class="form-group">
                <label>Name <span class="req">*</span></label>
                <input class="form-control" name="name" value="{{ old('name', $admin->name) }}" required data-testid="account-name">
                @error('name')<div class="field-error" style="color:var(--a-danger,#c0392b);font-size:.8rem;margin-top:.3rem;">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Email <span class="req">*</span></label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $admin->email) }}" required data-testid="account-email">
                @error('email')<div class="field-error" style="color:var(--a-danger,#c0392b);font-size:.8rem;margin-top:.3rem;">{{ $message }}</div>@enderror
            </div>
        </div>
        <button type="submit" class="btn-adm btn-primary" data-testid="save-account"><i class="fas fa-save"></i> Save Account</button>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <h2>Change Password</h2>
            <p class="text-muted" style="margin:.2rem 0 0;font-size:.85rem;">Enter your current password, then set a new one (min 8 characters).</p>
        </div>
    </div>
    <form method="POST" action="{{ route('admin.account.password') }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Current Password <span class="req">*</span></label>
            <input type="password" class="form-control" name="current_password" required autocomplete="current-password" data-testid="current-password">
            @error('current_password')<div class="field-error" style="color:var(--a-danger,#c0392b);font-size:.8rem;margin-top:.3rem;">{{ $message }}</div>@enderror
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>New Password <span class="req">*</span></label>
                <input type="password" class="form-control" name="password" required autocomplete="new-password" data-testid="new-password">
                @error('password')<div class="field-error" style="color:var(--a-danger,#c0392b);font-size:.8rem;margin-top:.3rem;">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Confirm New Password <span class="req">*</span></label>
                <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" data-testid="confirm-password">
            </div>
        </div>
        <button type="submit" class="btn-adm btn-primary" data-testid="save-password"><i class="fas fa-key"></i> Update Password</button>
    </form>
</div>
@endsection
