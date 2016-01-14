app.controller('situacaopromissoriaController', function ($scope, $http, toastr) {
    
    $scope.SituacaoPromissoria = {
        id: 0,
        descricao: '',
    };

    $scope.SituacaoPromissoriaAdd = {
        id: 0,
        descricao: ''
    };

    
    $scope.lstSituacaoPromissoria = true;
    $scope.addSituacaoPromissoria = false;
    $scope.updtSituacaoPromissoria = false;

    $scope.showEditarSituacaoPromissoria = function () {
        $scope.addSituacaoPromissoria = false;
        $scope.lstSituacaoPromissoria = false;
        $scope.updtSituacaoPromissoria = true;
    };

    $scope.showAddSituacaoPromissoria = function () {
        $scope.addSituacaoPromissoria = true;
        $scope.lstSituacaoPromissoria = false;
        $scope.updtSituacaoPromissoria = false;

        $scope.SituacaoPromissoriaAdd = {
            id: 0,
            descricao: ''
        };
    };

    $scope.showListSituacaoPromissoria = function () {
        $scope.addSituacaoPromissoria = false;
        $scope.lstSituacaoPromissoria = true;
        $scope.updtSituacaoPromissoria = false;
    };

    $scope.inserirSituacaoPromissoria = function () {
        $http.post('api/createSituacaoPromissoria', $scope.SituacaoPromissoriaAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    $scope.SituacaoPromissoriaAdd = {
                        id: 0,
                        descricao: ''
                    };
                    toastr.success('Situação Promissoria adicionado!', 'Sucesso');
                    $scope.listarSituacaoPromissoriaes();
                    $scope.showListSituacaoPromissoria();
                } else {
                    alert('Deu erro')
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

       
    $scope.listaSituacaoPromissoriaes = {};
    $scope.listarSituacaoPromissoriaes = function () {
        $http.get('api/listarSituacaoPromissoriaes')
            .success(function (data) {
                //$scope.listaUsuarios = data.$usuarios;
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaSituacaoPromissoriaes = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar situação de promissorias', 'Erro');
            });
    };

    $scope.editarSituacaoPromissoria = function (idSituacaoPromissoria) {
        $http.get('api/getSituacaoPromissoria/' + idSituacaoPromissoria)
            .success(function (data) {
                $scope.SituacaoPromissoria = data.result;
                $scope.showEditarSituacaoPromissoria();
            })
            .error(function (data) {
                toastr.error('Falha em editar situação de promissorias', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirSituacaoPromissoria = function (idSituacaoPromissoria) {
        $http.get('api/excluirSituacaoPromissoria/' + idSituacaoPromissoria)
            .success(function (data) {
                toastr.success('Situação de promissorias apagado com sucesso', 'Sucesso');
                $scope.listarSituacaoPromissoriaes();
                console.log(data);
            })
            .error(function (data) {
                toastr.error('Falha em excluir situação de promissorias', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarSituacaoPromissoria = function () {
        $http
            .post('api/alterarSituacaoPromissoria/' + $scope.SituacaoPromissoria.id, $scope.SituacaoPromissoria)
            .success(function (data) {

                if (!data.erro) {
                    // deu certo a alteração
                    toastr.success('Situação de promissorias atualizado com sucesso', 'Sucesso');
                    $scope.listarSituacaoPromissoriaes();
                    $scope.showListSituacaoPromissoria();
                } else {
                    toastr.error('Falha em alterar situação de promissorias', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar situação de promissorias', 'Erro');
                console.log(data);
            });
    };

    $scope.listarSituacaoPromissoriaes();
})
