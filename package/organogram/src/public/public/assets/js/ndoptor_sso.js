ndoptor_sso = new Keycloak('/keycloak.json');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function initKeycloak() {
    ndoptor_sso.init({onLoad: 'check-sso'}).then(function (authenticated) {
        if (authenticated !== false) {
            data = {
                'access_token': ndoptor_sso.token,
                'username': ndoptor_sso.idTokenParsed.preferred_username
            };
            $.ajax({
                type: "POST",
                url: '/sso/init_session',
                data: data,
                success: function (data) {
                    window.location.reload();
                    console.log('initialized');
                },
            });
        } else {

            $.ajax({
                type: "POST",
                url: '/sso/destroy_session',
                data: {},
                success: function (data) {
                    console.log('logged out');
                },
            });

            ndoptor_sso.init({onLoad: 'login-required'}).then(function () {
                console.log('initiated');
            }).catch(function (m) {
                console.log(m);
                alert('failed to initialize');
            });
        }
    });
}

// function ssoLogout() {
//     logoutOptions = { redirectUri: 'http://localhost:8000' };
//     ndoptor_sso.logout(logoutOptions).then((success) => {
//         console.log("--> log: logout success ", success);
//     }).catch((error) => {
//         console.log("--> log: logout error ", error);
//     });
// }

initKeycloak()
