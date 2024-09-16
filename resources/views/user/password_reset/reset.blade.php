@extends('layouts.guest')

@section('title')
Password Reset
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/password_reset.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
<style>
    /* Custom Styles for the Card */
    .card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 30px;
        width: 370px;
        margin: 60px auto;
        font-family: 'Arial', sans-serif;
    }

    .card-title {
        font-size: 22px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
    }

    .form-control {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 16px;
        padding: 12px 15px;
        margin-bottom: 15px;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: #38c172;
        box-shadow: 0 0 0 3px rgba(56, 193, 114, 0.2);
    }

    .btn-success {
        background-color: #38c172;
        border-color: #38c172;
        border-radius: 8px;
        padding: 12px 20px;
        font-size: 16px;
        font-weight: 600;
        width: 100%;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-success:hover {
        background-color: #2b8a3e;
        border-color: #2b8a3e;
    }

    .invalid-feedback {
        color: #e3342f;
        font-size: 14px;
        margin-top: -10px;
        margin-bottom: 10px;
    }

    .footer {
        text-align: center;
        color: #666;
        margin-top: 30px;
        padding: 10px;
        background-color: #f8f9fa;
        font-size: 14px;
    }

    .navbar {
        background: #ffffff;
        padding: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .navbar__logo img {
        height: 40px;
    }

    .text-center a {
        color: #38c172;
        font-weight: 600;
        text-decoration: none;
    }

    .text-center a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

<!-- Navigation Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar__logo">
            <img src="https://seeklogo.com/images/A/a2i-logo-5D16E2F1C3-seeklogo.com.png" alt="Logo">
        </div>
        <div class="navbar-language" id="google_translate_element"></div>
    </div>
</nav>

<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title"><i class="bi bi-arrow-clockwise" style="font-size: 22px; color:black"></i> Reset Password</h2>
            <hr>
            <form method="POST" action="{{ route('password.email') }}" class="my-login-validation" novalidate>
                @csrf
                <div class="form-group">
                    <label for="username">Username or User ID</label>
                    <input id="username" type="text" class="form-control" name="username" required autofocus>
                    <div class="invalid-feedback">
                        Please enter your username or user ID.
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" required>
                    <div class="invalid-feedback">
                        Please enter a valid email address.
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number (Optional)</label>
                    <input id="phone" type="text" class="form-control" name="phone">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Send Password Reset Link</button>
                </div>
                <hr>
                <div class="text-center">
                    <a href="{{ route('login') }}">Remembered your password? Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/custom.js') }}"></script>
@include('scripts.reset_pass')
<script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,bn'
        }, 'google_translate_element');
    }
    const sc = document.querySelector('.navbar-language');
    const config = { attributes: false, childList: true, subtree: true };
    const observer = new MutationObserver(function (mutationsList, observer) {
        const sc = document.querySelector('.goog-te-gadget');
        sc.childNodes[1].textContent = '';
    });

    observer.observe(sc, config);
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
@endsection
