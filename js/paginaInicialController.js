app.controller('paginaInicialController', function ($scope, $http, toastr) {
    
    $scope.sair = function () {
        toastr.info('Saindo do sistema', 'Atenção');
        $http.get('api/logout')
        window.location = "index.php"
    }
    
    $scope.pagina = 'homeContent.php';

    $scope.navegar = function (parametro) {
        $scope.pagina = parametro + '.php';
    }

    $scope.usuario = {
        id: 0,
        usuario: '',
        idPerfilUsuario: 0,
        status: 0
    }
    
    $scope.lstUsuario = true;
    $scope.addUsuario = false;
    $scope.updtUsuario = false;

    $scope.showEditarUsuario = function () {
        $scope.addUsuario = false;
        $scope.lstUsuario = false;
        $scope.updtUsuario = true;
    }

    $scope.showAddUsuario = function () {
        $scope.addUsuario = true;
        $scope.lstUsuario = false;
        $scope.updtUsuario = false;
    }

    $scope.showListUsuario = function () {
        $scope.addUsuario = false;
        $scope.lstUsuario = true;
        $scope.updtUsuario = false;
    }
  
    $scope.loginAdd = {
        usuario: '',
        senha: ''
    };

    $scope.inserirUsuario = function () {
        $http.post('api/registration', $scope.loginAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    $scope.loginAdd = {
                        usuario: '',
                        senha: ''
                    };
                    toastr.success('Usuário adicionado!', 'Sucesso');
                    $scope.listarUsuarios();
                    $scope.showListUsuario();
                } else {
                    alert('Deu erro')
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

       
    $scope.listaUsuarios = {};
    $scope.listarUsuarios = function () {
        $http.get('api/listarUsuarios')
            .success(function (data) {
                //$scope.listaUsuarios = data.$usuarios;
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaUsuarios = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar Usuarios', 'Erro');
            });
    };

    $scope.editarUsuario = function (idUsuario) {
        $http.get('api/getUsuario/' + idUsuario)
            .success(function (data) {
                $scope.usuario = data.result;
                $scope.showEditarUsuario();
            })
            .error(function (data) {
                toastr.error('Falha em editar usuario', 'Erro');
                console.log(data);
            });
    };

    $scope.excluirUsuario = function (idUsuario) {
        $http.get('api/excluirUsuario/' + idUsuario)
            .success(function (data) {
                toastr.success('Usuario apagado com sucesso', 'Sucesso');
                $scope.listarUsuarios();
            })
            .error(function (data) {
                toastr.error('Falha em excluir usuario', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarUsuario = function () {
        $http
            .post('api/alterarUsuario/' + $scope.usuario.id, $scope.usuario)
            .success(function (data) {

                if (!data.erro) {
                    // deu certo a alteração
                    toastr.success('Usuario atualizado com sucesso', 'Sucesso');
                    $scope.listarUsuarios();
                    $scope.showListUsuario();
                } else {
                    toastr.error('Falha em alterar usuario', 'Erro');
                    console.log(data);
                }

            })
            .error(function (data) {
                toastr.error('Falha em alterar usuario', 'Erro');
                console.log(data);
            });
    };

    $scope.listarUsuarios();
})
