<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            max-width: 600px; /* Increased max-width */
            margin: auto;
            margin-top: 5rem;
            transition: transform 0.3s ease;
        }
        .login-container:hover {
            transform: scale(1.02);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header h2 {
            font-size: 2rem; /* Increased font-size */
            font-weight: 600;
            color: #333;
        }
        .error-message {
            background: #fef2f2;
            color: #dc2626;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            border: 1px solid #fca5a5;
        }
        .input-field {
            border-color: #d1d5db;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .input-field:focus {
            border-color: #4f46e5;
            outline: none;
            box-shadow: 0 0 0 2px rgba(100, 116, 139, 0.2);
        }
        .input-label {
            display: block;
            font-size: 0.875rem;
            color: #4b5563;
            margin-bottom: 0.5rem;
        }
        .login-button {
            background: #4f46e5;
            color: #ffffff;
            border: none;
            padding: 0.75rem;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        .login-button:hover {
            background: #4338ca;
        }
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
        }
        .login-footer a {
            color: #4f46e5;
            text-decoration: none;
            font-size: 0.875rem;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }
        .login-icon {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .login-icon img {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="login-container">
        <div class="login-icon">
            <img src="https://i.ibb.co.com/NTtNPXr/logo-removebg-preview.png" alt="App Logo">
        </div>
        <div class="login-header">
            <h2>Login to Cashier App</h2>
        </div>
        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="input-label">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="Enter your email" required>
            </div>
            <div class="mb-4">
                <label for="password" class="input-label">Password</label>
                <input type="password" id="password" name="password" class="input-field" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="login-button">Login</button>
        </form>
        <div class="login-footer">
            <a href="{{ route('pelanggan.register') }}">Dont have an account? Register</a>
        </div>
    </div>
</body>
</html>
