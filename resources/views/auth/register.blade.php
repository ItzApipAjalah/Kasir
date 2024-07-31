<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            max-width: 600px;
            margin: auto;
            margin-top: 5rem;
            transition: transform 0.3s ease;
        }
        .register-container:hover {
            transform: scale(1.02);
        }
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .register-header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
        }
        .error-message, .password-error-message {
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
        .register-button {
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
        .register-button:hover {
            background: #4338ca;
        }
        .register-footer {
            text-align: center;
            margin-top: 1.5rem;
        }
        .register-footer a {
            color: #4f46e5;
            text-decoration: none;
            font-size: 0.875rem;
        }
        .register-footer a:hover {
            text-decoration: underline;
        }
        .register-icon {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .register-icon img {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="register-container">
        <div class="register-icon">
            <img src="https://i.ibb.co/NTtNPXr/logo-removebg-preview.png" alt="App Logo">
        </div>
        <div class="register-header">
            <h2>Register as Customer</h2>
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
        <div id="password-error-message" class="password-error-message" style="display:none;">
            Password and Confirm Password do not match.
        </div>
        <form method="POST" action="{{ route('pelanggan.register') }}" onsubmit="return validatePasswordMatch();">
            @csrf
            <div class="mb-4">
                <label for="name" class="input-label">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="input-field" placeholder="Enter your name" required>
            </div>
            <div class="mb-4">
                <label for="email" class="input-label">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="Enter your email" required>
            </div>
            <div class="mb-4">
                <label for="password" class="input-label">Password</label>
                <input type="password" id="password" name="password" class="input-field" placeholder="Enter your password" required>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="input-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="input-field" placeholder="Confirm your password" required>
            </div>
            <button type="submit" class="register-button">Register</button>
        </form>
        <div class="register-footer">
            <a href="{{ route('login') }}">Already have an account? Login</a>
        </div>
    </div>

    <script>
        function validatePasswordMatch() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('password_confirmation').value;
            var errorMessage = document.getElementById('password-error-message');

            if (password !== confirmPassword) {
                errorMessage.style.display = 'block';
                return false; // Prevent form submission
            } else {
                errorMessage.style.display = 'none';
                return true; // Allow form submission
            }
        }
    </script>
</body>
</html>
