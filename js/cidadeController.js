app.controller('cidadeController', function ($scope, $http, toastr) {

    $scopepaisSelecionado = {};

    $scope.Cidade = {
        id: 0,
        descricao: '',
        estadoId: 0,
        estadoName : ''
    };

    $scope.CidadeAdd = {
        id: 0,
        descricao: '',
        estadoId: 0,
        estadoName: ''
    };

    
    $scope.lstCidade = true;
    $scope.addCidade = false;
    $scope.updtCidade = false;

    $scope.showEditarCidade = function () {
        $scope.addCidade = false;
        $scope.lstCidade = false;
        $scope.updtCidade = true;
    };

    $scope.showAddCidade = function () {
        $scope.addCidade = true;
        $scope.lstCidade = false;
        $scope.updtCidade = false;

        $scope.CidadeAdd = {
            id: 0,
            descricao: '',
            estadoId: 0,
            estadoName: ''
        };
    };

    $scope.showListCidade = function () {
        $scope.addCidade = false;
        $scope.lstCidade = true;
        $scope.updtCidade = false;
    };

    $scope.inserirCidade = function () {
        $http.post('api/createCidade', $scope.CidadeAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    $scope.CidadeAdd = {
                        id: 0,
                        descricao: ''
                    };
                    toastr.success('Cidade adicionada!', 'Sucesso');
                    $scope.listarCidades();
                    $scope.showListCidade();
                } else {
                    alert('Deu erro')
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

       
    $scope.listaCidades = {};
    $scope.listarCidades = function () {
        $http.get('api/listarCidades')
            .success(function (data) {
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaCidades = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar Usuarios', 'Erro');
            });
    };

    $scope.editarCidade = function (idCidade) {
        $http.get('api/getCidade/' + idCidade)
            .success(function (data) {
                $scope.Cidade = data.result;
                $scope.showEditarCidade();
            })
            .error(function (data) {
                toastr.error('Falha em editar Cidade', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirCidade = function (idCidade) {
        $http.get('api/excluirCidade/' + idCidade)
            .success(function (data) {
                toastr.success('Cidade apagada com sucesso', 'Sucesso');
                $scope.listarCidades();
                console.log(data);
            })
            .error(function (data) {
                toastr.error('Falha em excluir Cidade', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarCidade = function () {
        $http
            .post('api/alterarCidade/' + $scope.Cidade.id, $scope.Cidade)
            .success(function (data) {

                if (!data.erro) {
                    // deu certo a alteração
                    toastr.success('Cidade atualizado com sucesso', 'Sucesso');
                    $scope.listarCidades();
                    $scope.showListCidade();
                } else {
                    toastr.error('Falha em alterar Cidade', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar Cidade', 'Erro');
                console.log(data);
            });
    };

    $scope.listaEstados = {};
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
                toastr.error('Erro ao localizar Usuarios', 'Erro');
            });
    };

    $scope.listarCidades();
    $scope.listarEstados();
})
