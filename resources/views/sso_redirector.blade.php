<!DOCTYPE html>
<html lang="bn">
<head>
    <title>Redirecting...</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ config('ndoptor_sso.sso_base_url') }}auth/js/keycloak.js"></script>
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/ndoptor_sso.js')}}"></script>
</head>

<body>
Redirecting to nDoptor SSO...
</body>

</html>
