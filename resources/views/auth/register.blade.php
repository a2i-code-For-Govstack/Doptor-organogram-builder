@extends('layouts.guest')
@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/password_reset.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
<style>
    /* Custom Styles */
    body, html {
    margin: 0;
    font-family: "Nunito", sans-serif;
    font-size: 0.9rem;
    font-weight: 400;
    line-height: 1.6;
    color: #212529;
    text-align: left;

    }

    .navbar {
        background: rgba(255, 255, 255, 0.9);
        padding: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Retain original shadow for navbar */
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
    }

    .navbar__logo img {
        height: 40px;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
        margin-top: 60px;
    }

    .card {
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 370px;
    }

    .footer {
        text-align: center;
        color: #000;
        margin-top: 20px;
        font-size: 14px;
    }

    .btn-success {
        background-color: #38c172 !important;
        border-color: #38c172 !important;
    }

    .btn-success:hover {
        background-color: #2b8a3e !important;
        border-color: #2b8a3e !important;
    }

    /* Add box-shadow to input fields */
    input.form-control {
        box-shadow: 0 4px 8px rgba(56, 193, 114, 0.6);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .navbar__logo img {
            height: 30px;
        }
    }

    @media (max-width: 480px) {
        .navbar__logo img {
            height: 25px;
        }
        .card {
            padding: 15px;
        }
    }
</style>

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
    <div style="margin-top: 50px;" class="card">
        <h3 style="text-align: start !important;" class="card-title text-center mb-4"><i class="bi bi-person-check" style="font-size: 20px; color:black"></i> Register</h3>
        <hr>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-success btn-block">
                        {{ __('Register') }}
                    </button>
                </div>

                <hr>
                <div class="text-center">
                    <a href="{{ route('login') }}">Already have an Account?</a>
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
