<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Admin login page" />
    <title>Login - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-color), #0056b3);
            min-height: 100vh;
        }
        
        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-top: 2rem;
        }

        .social-login-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s;
        }
        
        .social-login-btn:hover {
            transform: scale(1.1);
        }
        
        .divider {
            position: relative;
            text-align: center;
            margin: 2rem 0;
        }
        
        .divider::before,
        .divider::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background-color: #dee2e6;
        }
        
        .divider::before { left: 0; }
        .divider::after { right: 0; }
        
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(13,110,253,0.25);
        }
        
        .login-btn {
            padding: 0.75rem 2.5rem;
            font-weight: 600;
            border-radius: 8px;
        }
        
        .footer {
            background: rgba(0,0,0,0.1);
            padding: 1rem 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        
        .illustration {
            max-width: 100%;
            height: auto;
        }

        /* Password toggle style */
        .password-field {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
            color: #6c757d;
        }

        .password-toggle:hover {
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="login-container">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <img src="{{url('storage/assets/images/logo5.jpeg')}}"
                            class="img-fluid" alt="Bengkalis Bermasa">
                        </div>
                        <div class="col-md-6">
                            <h2 class="text-center mb-4">Selamat Datang!</h2>
                            <form action="{{route('login.submit')}}" method="POST">
                                @csrf
                                @if (session()->has('warning'))
                                    <div class="alert alert-warning">
                                        {{session()->get('warning')}}
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="password-field">
                                        <input type="password" name="password" class="form-control" id="password" required>
                                        <button type="button" class="password-toggle" onclick="togglePassword()">
                                            <i class="far fa-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                        <label class="form-check-label" for="remember">Ingatkan Saya</label>
                                    </div>
                                    {{-- <a href="{{route('password.request')}}" class="text-end">Lupa Password?</a> --}}
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100 login-btn mb-3">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="footer">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-white mb-0">&copy; 2025 Dai Bermasa.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>