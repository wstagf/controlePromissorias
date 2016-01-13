app.controller('estadoController', function ($scope, $http, toastr) {

    $scopepaisSelecionado = {};

    $scope.Estado = {
        id: 0,
        descricao: '',
        paisId: 0,
        paisName : ''
    };

    $scope.EstadoAdd = {
        id: 0,
        descricao: '',
        paisId: 0,
        paisName: ''
    };

    
    $scope.lstEstado = true;
    $scope.addEstado = false;
    $scope.updtEstado = false;

    $scope.showEditarEstado = function () {
        $scope.addEstado = false;
        $scope.lstEstado = false;
        $scope.updtEstado = true;
    };

    $scope.showAddEstado = function () {
        $scope.addEstado = true;
        $scope.lstEstado = false;
        $scope.updtEstado = false;

        $scope.EstadoAdd = {
            id: 0,
            descricao: '',
            paisId: 0,
            paisName: ''
        };

    };

    $scope.showListEstado = function () {
        $scope.addEstado = false;
        $scope.lstEstado = true;
        $scope.updtEstado = false;
    };

    $scope.inserirEstado = function () {
        $http.post('api/createEstado', $scope.EstadoAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    $scope.EstadoAdd = {
                        id: 0,
                        descricao: ''
                    };
                    toastr.success('Estado adicionado!', 'Sucesso');
                    $scope.listarEstados();
                    $scope.showListEstado();
                } else {
                    alert('Deu erro')
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

       
    $scope.listarEstados = {};
    $scope.listarEstados = function () {
        $http.get('api/listarEstados')
            .success(function (data) {
                //$scope.listaUsuarios = data.$usuarios;
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaEstados = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar Usuarios', 'Erro');
            });
    };

    $scope.editarEstado = function (idEstado) {
        $http.get('api/getEstado/' + idEstado)
            .success(function (data) {
                $scope.Estado = data.result;
                $scope.showEditarEstado();
            })
            .error(function (data) {
                toastr.error('Falha em editar Estado', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirEstado = function (idEstado) {
        $http.get('api/excluirEstado/' + idEstado)
            .success(function (data) {
                toastr.success('Estado apagado com sucesso', 'Sucesso');
                $scope.listarEstados();
                console.log(data);
            })
            .error(function (data) {
                toastr.error('Falha em excluir Estado', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarEstado = function () {
        $http
            .post('api/alterarEstado/' + $scope.Estado.id, $scope.Estado)
            .success(function (data) {

                if (!data.erro) {
                    // deu certo a alteração
                    toastr.success('Estado atualizado com sucesso', 'Sucesso');
                    $scope.listarEstados();
                    $scope.showListEstado();
                } else {
                    toastr.error('Falha em alterar Estado', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar Estado', 'Erro');
                console.log(data);
            });
    };

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
                toastr.error('Erro ao localizar Usuarios', 'Erro');
            });
    };

    function updatePaisSelecionado() {
        alert('trocou');
    }


    $scope.listarEstados();
    $scope.listarPaises();
})
