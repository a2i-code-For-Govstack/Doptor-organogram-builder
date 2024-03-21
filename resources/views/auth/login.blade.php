<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Organogram Builder</title>
    <link rel="stylesheet" href="{{asset('assets/guest/css/style.bundle.css')}}">
    <style>
        html, body {
            height: 100%;
        }

        body.my-login-page {
            background-color: #f7f9fb;
            font-size: 14px;
        }

        .my-login-page .brand {
            width: 90px;
            height: 90px;
            overflow: hidden;
            border-radius: 50%;
            margin: 40px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, .05);
            position: relative;
            z-index: 1;
        }

        .my-login-page .brand img {
            width: 100%;
        }

        .my-login-page .card-wrapper {
            width: 400px;
        }

        .my-login-page .card {
            border-color: transparent;
            box-shadow: 0 4px 8px rgba(0, 0, 0, .05);
        }

        .my-login-page .card.fat {
            padding: 10px;
        }

        .my-login-page .card .card-title {
            margin-bottom: 30px;
        }

        .my-login-page .form-control {
            border-width: 2.3px;
        }

        .my-login-page .form-group label {
            width: 100%;
        }

        .my-login-page .btn.btn-block {
            padding: 12px 10px;
        }

        .my-login-page .footer {
            margin: 40px 0;
            color: #888;
            text-align: center;
        }

        @media screen and (max-width: 425px) {
            .my-login-page .card-wrapper {
                width: 90%;
                margin: 0 auto;
            }
        }

        @media screen and (max-width: 320px) {
            .my-login-page .card.fat {
                padding: 0;
            }

            .my-login-page .card.fat .card-body {
                padding: 15px;
            }
        }
    </style>
</head>

<body class="my-login-page">
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="card-wrapper">
                <div class="brand">
                    <img src="{{asset('assets/img/ndoptor.svg')}}" alt="logo">
                </div>
                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title">Login</h4>
                        @if ($errors->any())
                            <div class="alert alert-danger border-left-danger" role="alert">
                                <ul class="pl-4 my-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" class="my-login-validation" action="{{route('login')}}" novalidate="">
                            @csrf
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input id="username" type="text" class="form-control" name="username" value="" required
                                       autofocus>
                                <div class="invalid-feedback">
                                    Username is invalid
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password
                                    <a href="{{route('password.request')}}" class="float-right">
                                        Forgot Password?
                                    </a>
                                </label>
                                <input id="password" type="password" class="form-control" name="password" required
                                       data-eye>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                            </div>
                            <div class="form-group m-0">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="footer">
                    Copyright &copy; {{date('Y')}} &mdash; Organogram Builder
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{asset('assets/guest/plugins.bundle.js')}}"></script>
<script>
    'use strict';

    $(function () {
        $("input[type='password'][data-eye]").each(function (i) {
            var $this = $(this),
                id = 'eye-password-' + i,
                el = $('#' + id);

            $this.wrap($("<div/>", {
                style: 'position:relative',
                id: id
            }));

            $this.css({
                paddingRight: 60
            });
            $this.after($("<div/>", {
                html: 'Show',
                class: 'btn btn-primary btn-sm',
                id: 'passeye-toggle-' + i,
            }).css({
                position: 'absolute',
                right: 10,
                top: ($this.outerHeight() / 2) - 12,
                padding: '2px 7px',
                fontSize: 12,
                cursor: 'pointer',
            }));

            $this.after($("<input/>", {
                type: 'hidden',
                id: 'passeye-' + i
            }));

            var invalid_feedback = $this.parent().parent().find('.invalid-feedback');

            if (invalid_feedback.length) {
                $this.after(invalid_feedback.clone());
            }

            $this.on("keyup paste", function () {
                $("#passeye-" + i).val($(this).val());
            });
            $("#passeye-toggle-" + i).on("click", function () {
                if ($this.hasClass("show")) {
                    $this.attr('type', 'password');
                    $this.removeClass("show");
                    $(this).removeClass("btn-outline-primary");
                } else {
                    $this.attr('type', 'text');
                    $this.val($("#passeye-" + i).val());
                    $this.addClass("show");
                    $(this).addClass("btn-outline-primary");
                }
            });
        });

        $(".my-login-validation").submit(function () {
            var form = $(this);
            if (form[0].checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.addClass('was-validated');
        });
    });
</script>
</body>
</html>
