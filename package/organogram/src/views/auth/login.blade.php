<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character set and responsive design -->
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title of the page -->
    <title>Organogram Builder</title>

    <!-- CSS files for styling -->
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
    </style>

    <!-- Google Translate script for language selection -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,bn'
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</head>
<body>
    <!-- Navbar with logo and language selector -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar__logo">
                <img src="https://seeklogo.com/images/A/a2i-logo-5D16E2F1C3-seeklogo.com.png" alt="Logo">
            </div>
            <div class="navbar-language" id="google_translate_element"></div>
        </div>
    </nav>

    <!-- Login card container -->
    <div class="my-login-page">
        <div class="card">
            <!-- Login title with icon -->
            <h4 class="card-title"><i class="bi bi-person-check"></i> Login</h4>
            <hr>
            <!-- Display errors, if any -->
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Login form -->
            <form method="POST" class="my-login-validation" action="{{ route('login') }}" novalidate>
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" class="form-control shadow-green" name="username" required autofocus>
                    <div class="invalid-feedback">
                        Username is invalid
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control shadow-green" name="password" required>
                    <div class="invalid-feedback">
                        Password is required
                    </div>
                    <!-- Show password button with icon -->
                    <div id="passeye-toggle" class="btn-show-password">
                        <i class="bi bi-eye"></i> 
                    </div>
                </div>
                <a href="{{ route('password.request') }}" class="float-right">Forgot Password?</a><br>

                <div class="form-group m-1">
                    <button type="submit" class="btn btn-success btn-block">Login</button>
                </div>
                
                <hr>
                <div class="text-center">
                    <a href="{{ route('register') }}">Create an Account</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer with copyright information -->
    <div class="footer">
    Copyright &copy; {{ date('Y') }} &mdash; Organogram Builder
</div>

    <!-- External JavaScript files -->
    <script src="{{ asset('assets/guest/plugins.bundle.js') }}"></script>

    <script>
        'use strict';

        $(function () {
            // Toggle the visibility of the password field when the show button is clicked
            $("#passeye-toggle").on("click", function () {
                var passwordInput = $("#password");
                var icon = $(this).find("i");

                if (passwordInput.attr("type") === "password") {
                    passwordInput.attr("type", "text"); // Show the password
                    icon.removeClass("bi-eye").addClass("bi-eye-slash"); // Change icon to "eye-slash"
                    $(this).html('<i class="bi bi-eye-slash"></i>'); // Change text to "Hide"
                } else {
                    passwordInput.attr("type", "password"); // Hide the password
                    icon.removeClass("bi-eye-slash").addClass("bi-eye"); // Change icon back to "eye"
                    $(this).html('<i class="bi bi-eye"></i>'); // Change text back to "Show"
                }
            });

            // Validate the form before submitting
            $(".my-login-validation").submit(function (event) {
                var form = $(this);
                if (form[0].checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.addClass('was-validated');
            });
        });

        // Observer to remove unwanted text from the Google Translate widget
        const sc = document.querySelector('.navbar-language');
        const config = { attributes: false, childList: true, subtree: true };
        const observer = new MutationObserver(function (mutationsList, observer) {
            const sc = document.querySelector('.goog-te-gadget');
            sc.childNodes[1].textContent = ''; // Remove the "Translate" label
        });

        observer.observe(sc, config);
    </script>
</body>
</html>
