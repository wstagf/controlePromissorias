app.controller('trabalhoController', function ($scope, $http, toastr) {
    $scope.Trabalho = {
        id: 0,
        crianca_id: '',
        criancaName:'',
        valor: '',        
        parcelas:'',
        saldo: '',
        observacoes: ''
    };

    $scope.TrabalhoAdd = {
        id: 0,
        crianca_id: '',
        criancaName: '',
        valor: '',
        parcelas: '',
        saldo: '',
        observacoes: ''
    };

    $scope.Crianca = {
        id: 0,
        nome: ''
    };

    
    $scope.lstTrabalho = true;
    $scope.addTrabalho = false;
    $scope.updtTrabalho = false;

    $scope.showEditarTrabalho = function () {
        $scope.addTrabalho = false;
        $scope.lstTrabalho = false;
        $scope.updtTrabalho = true;
    };

    $scope.showAddTrabalho = function () {
        $scope.addTrabalho = true;
        $scope.lstTrabalho = false;
        $scope.updtTrabalho = false;

        $scope.TrabalhoAdd = {
            id: 0,
            crianca_id: '',
            criancaName: '',
            valor: '',
            parcelas: '',
            saldo: '',
            observacoes: ''
        };
    };

    $scope.showListTrabalho = function () {
        $scope.addTrabalho = false;
        $scope.lstTrabalho = true;
        $scope.updtTrabalho = false;
    };

    $scope.inserirTrabalho = function () {
        $http.post('api/createTrabalho', $scope.TrabalhoAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    toastr.success('Trabalho adicionada!', 'Sucesso');
                    $scope.listarTrabalhos();
                    $scope.showListTrabalho();
                } else {
                    toastr.error('Erro ao inserir Trabalho', 'Erro');
                }
            })
            .error(function (data) {
                toastr.error('Erro ao inserir Trabalho', 'Erro');
                console.log(data);
        });
    }

       
    $scope.listaTrabalhos = {};
    $scope.listarTrabalhos = function () {
        $http.get('api/listarTrabalhos')
            .success(function (data) {
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaTrabalhos = data.result;
                }
            })
            .error(function (data) {
                console.log(data);
                toastr.error('Erro ao localizar trabalhos', 'Erro');
            });
    };

    $scope.editarTrabalho = function (idTrabalho) {
        $http.get('api/getTrabalho/' + idTrabalho)
            .success(function (data) {
                console.log(data);
                $scope.Trabalho = data.result;
                $scope.showEditarTrabalho();
            })
            .error(function (data) {
                toastr.error('Falha em editar Trabalho', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirTrabalho = function (idTrabalho) {
        $http.get('api/excluirTrabalho/' + idTrabalho)
            .success(function (data) {
                toastr.success('Trabalho apagada com sucesso', 'Sucesso');
                $scope.listarTrabalhos();
                console.log(data);
            })
            .error(function (data) {
                toastr.error('Falha em excluir Trabalho', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarTrabalho = function () {
        $http.post('api/alterarTrabalho/' + $scope.Trabalho.id, $scope.Trabalho)
        .success(function (data) {
            if (!data.erro) {
                // auterou a Trabalho
                toastr.success('Dados da Trabalho atualizado com sucesso', 'Sucesso');
                $scope.listarTrabalhos();
                $scope.showListTrabalho();
            } else {
                toastr.error('Falha em alterar dados da Trabalho', 'Erro');
                console.log(data);
            }
        })
        .error(function (data) {
            toastr.error('Falha em alterar dados da Trabalho', 'Erro');
            console.log(data);
        });
    };

    
  
    $scope.listaCriancas = {};
    $scope.listarCriancas = function () {
        $http.get('api/listarCriancas')
            .success(function (data) {
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaCriancas = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar criancas', 'Erro');
            });
    };

    $scope.listarCriancas();
    $scope.listarTrabalhos();

})

