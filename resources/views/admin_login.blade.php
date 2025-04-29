<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Five Star Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/images/logo.png') }}">

    <style>
        body {
            background: linear-gradient(135deg, #1e396b, #6cb2e4);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .login-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-container h1 {
            font-size: 2rem;
            color: #1e396b;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-control {
            border: 1px solid #6cb2e4;
        }

        .btn-login {
            background-color: #4c8bc2;
            color: #ffffff;
            font-weight: bold;
        }

        .btn-login:hover {
            background-color: #2a5a9d;
        }

        .form-text {
            text-align: center;
            margin-top: 1rem;
        }

        .form-text a {
            color: #1e396b;
            text-decoration: none;
        }

        .form-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf 
            <div class="mb-3">
                <label for="admin_username" class="form-label">Username</label>
                <input type="text" class="form-control" id="admin_username" name="admin_username" required>
            </div>
            <div class="mb-3">
                <label for="admin_password" class="form-label">Password</label>
                <input type="password" class="form-control" id="admin_password" name="admin_password" required>
            </div>
            <button type="submit" class="btn btn-login w-100 py-2">Login</button>
        </form>
        @if (session('error'))
            <div class="text-danger text-center mt-3">{{ session('error') }}</div>
        @endif
        <a href="{{ route('home') }}" class="btn btn-secondary w-100 py-2 mt-2">Go Home</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>