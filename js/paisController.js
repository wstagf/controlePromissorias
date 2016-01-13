app.controller('paisController', function ($scope, $http, toastr) {
    
    $scope.Pais = {
        id: 0,
        descricao: '',
    };

    $scope.PaisAdd = {
        id: 0,
        descricao: ''
    };

    
    $scope.lstPais = true;
    $scope.addPais = false;
    $scope.updtPais = false;

    $scope.showEditarPais = function () {
        $scope.addPais = false;
        $scope.lstPais = false;
        $scope.updtPais = true;
    };

    $scope.showAddPais = function () {
        $scope.addPais = true;
        $scope.lstPais = false;
        $scope.updtPais = false;

        $scope.PaisAdd = {
            id: 0,
            descricao: ''
        };
    };

    $scope.showListPais = function () {
        $scope.addPais = false;
        $scope.lstPais = true;
        $scope.updtPais = false;
    };

    $scope.inserirPais = function () {
        $http.post('api/createPais', $scope.PaisAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    $scope.PaisAdd = {
                        id: 0,
                        descricao: ''
                    };
                    toastr.success('País adicionado!', 'Sucesso');
                    $scope.listarPaises();
                    $scope.showListPais();
                } else {
                    alert('Deu erro')
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

       
    $scope.listaPaises = {};
    $scope.listarPaises = function () {
        $http.get('api/listarPaises')
            .success(function (data) {
                //$scope.listaUsuarios = data.$usuarios;
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaPaises = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar Usuarios', 'Erro');
            });
    };

    $scope.editarPais = function (idPais) {
        $http.get('api/getPais/' + idPais)
            .success(function (data) {
                $scope.Pais = data.result;
                $scope.showEditarPais();
            })
            .error(function (data) {
                toastr.error('Falha em editar País', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirPais = function (idPais) {
        $http.get('api/excluirPais/' + idPais)
            .success(function (data) {
                toastr.success('País apagado com sucesso', 'Sucesso');
                $scope.listarPaises();
                console.log(data);
            })
            .error(function (data) {
                toastr.error('Falha em excluir País', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarPais = function () {
        $http
            .post('api/alterarPais/' + $scope.Pais.id, $scope.Pais)
            .success(function (data) {

                if (!data.erro) {
                    // deu certo a alteração
                    toastr.success('País atualizado com sucesso', 'Sucesso');
                    $scope.listarPaises();
                    $scope.showListPais();
                } else {
                    toastr.error('Falha em alterar País', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar País', 'Erro');
                console.log(data);
            });
    };

    $scope.listarPaises();
})
