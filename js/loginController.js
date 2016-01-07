app.controller('loginController', function ($scope, $http, toastr) {
    $scope.login = {
        usuario: '',
        senha: ''
    };



    $scope.fazerLogin = function () {
        $http.post('api/login', $scope.login)
            .success(function (data) {
                console.log(data);
                if (data.logado) {
                    window.location = "home.php"
                } else {
                    toastr.info('Verifique o usuário e a senha', 'Atenção');
                }
            });
    }

    

})
