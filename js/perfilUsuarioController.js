app.controller('perfilusuarioController', function ($scope, $http, toastr) {
    
    $scope.perfilusuario = {
        id: 0,
        descricao: '',
    };

    $scope.perfilUsuarioAdd = {
        id: 0,
        descricao: ''
    };

    
    $scope.lstPerfilUsuario = true;
    $scope.addPerfilUsuario = false;
    $scope.updtPerfilUsuario = false;

    $scope.showEditarPerfilUsuario = function () {
        $scope.addPerfilUsuario = false;
        $scope.lstPerfilUsuario = false;
        $scope.updtPerfilUsuario = true;
    };

    $scope.showAddPerfilUsuario = function () {
        $scope.addPerfilUsuario = true;
        $scope.lstPerfilUsuario = false;
        $scope.updtPerfilUsuario = false;

        $scope.perfilUsuarioAdd = {
            id: 0,
            descricao: ''
        };


    };

    $scope.showListPerfilUsuario = function () {
        $scope.addPerfilUsuario = false;
        $scope.lstPerfilUsuario = true;
        $scope.updtPerfilUsuario = false;
    };

    $scope.inserirPerfilUsuario = function () {
        $http.post('api/createPerfilUsuario', $scope.perfilUsuarioAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    $scope.perfilUsuarioAdd = {
                        id: 0,
                        descricao: ''
                    };
                    toastr.success('Perfil de usuário adicionado!', 'Sucesso');
                    $scope.listarPerfilUsuarios();
                    $scope.showListPerfilUsuario();
                } else {
                    alert('Deu erro')
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

       
    $scope.listaPerfilUsuarios = {};
    $scope.listarPerfilUsuarios = function () {
        $http.get('api/listarPerfilUsuarios')
            .success(function (data) {
                //$scope.listaUsuarios = data.$usuarios;
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaPerfilUsuarios = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar Usuarios', 'Erro');
            });
    };

    $scope.editarPerfilUsuario = function (idPerfilUsuario) {
        $http.get('api/getPerfilUsuario/' + idPerfilUsuario)
            .success(function (data) {
                $scope.perfilusuario = data.result;
                $scope.showEditarPerfilUsuario();
            })
            .error(function (data) {
                toastr.error('Falha em editar perfil usuario', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirPerfilUsuario = function (idPerfilUsuario) {
        $http.get('api/excluirPerfilUsuario/' + idPerfilUsuario)
            .success(function (data) {
                toastr.success('Perfil Usuario apagado com sucesso', 'Sucesso');
                $scope.listarPerfilUsuarios();
                console.log(data);
            })
            .error(function (data) {
                toastr.error('Falha em excluir Perfil usuario', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarPerfilUsuario = function () {
        $http
            .post('api/alterarPerfilUsuario/' + $scope.perfilusuario.id, $scope.perfilusuario)
            .success(function (data) {

                if (!data.erro) {
                    // deu certo a alteração
                    toastr.success('Perfil Usuario atualizado com sucesso', 'Sucesso');
                    $scope.listarPerfilUsuarios();
                    $scope.showListPerfilUsuario();
                } else {
                    toastr.error('Falha em alterar Perfil Usuário', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar Perfil Usuário', 'Erro');
                console.log(data);
            });
    };

    $scope.listarPerfilUsuarios();
})
