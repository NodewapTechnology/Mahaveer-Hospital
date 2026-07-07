<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login · Mahaveer Hospital CMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=3">
</head>
<body>
    <div class="admin-login-wrap">
        <div class="admin-login-card" data-testid="admin-login-card">
            <div style="text-align:center;margin-bottom:1.5rem;">
                <div style="width:60px;height:60px;background:var(--a-primary);color:#fff;border-radius:16px;display:inline-grid;place-items:center;font-weight:700;font-size:1.4rem;">M+</div>
            </div>
            <h1 style="text-align:center;">Mahaveer CMS</h1>
            <div class="sub" style="text-align:center;">Sign in to continue</div>

            @if($errors->any())
                <div class="alert alert-danger" style="margin-top:1.5rem;" data-testid="login-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.attempt') }}" style="margin-top:1.5rem;" data-testid="admin-login-form">
                @csrf
                <div class="form-group">
                    <label>Email <span class="req">*</span></label>
                    <input type="email" name="email" required autofocus class="form-control" value="{{ old('email') }}" data-testid="login-email">
                </div>
                <div class="form-group">
                    <label>Password <span class="req">*</span></label>
                    <input type="password" name="password" required class="form-control" data-testid="login-password">
                </div>
                <div class="form-check" style="margin-bottom:1.25rem;">
                    <input type="checkbox" name="remember" id="remember"><label for="remember" style="margin:0;font-weight:500;">Remember me</label>
                </div>
                <button type="submit" class="btn-adm btn-primary" style="width:100%;justify-content:center;padding:.75rem;font-size:.95rem;" data-testid="login-submit">
                    <i class="fas fa-right-to-bracket"></i> Sign In
                </button>
            </form>
            <div style="text-align:center;margin-top:1.5rem;">
                <a href="{{ url('/') }}" style="color:var(--a-muted);text-decoration:none;font-size:.85rem;"><i class="fas fa-arrow-left"></i> Back to website</a>
            </div>
        </div>
    </div>
</body>
</html>
