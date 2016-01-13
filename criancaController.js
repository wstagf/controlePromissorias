app.controller('criancaController', function ($scope, $http, toastr) {
    $scope.Crianca = {
        id: 0,
        nome: '',
        escola_id: '',
        escolaName:'',
        serie: '',
        observacao: ''

    };

    $scope.CriancaAdd = {
        id: 0,
        nome: '',
        escola_id: '',
        escolaName: '',
        serie: '',
        observacao: ''
    };

    $scope.Escola = {
        id: 0,
        descricao: ''
    };

    
    $scope.lstCrianca = true;
    $scope.addCrianca = false;
    $scope.updtCrianca = false;

    $scope.showEditarCrianca = function () {
        $scope.addCrianca = false;
        $scope.lstCrianca = false;
        $scope.updtCrianca = true;
    };

    $scope.showAddCrianca = function () {
        $scope.addCrianca = true;
        $scope.lstCrianca = false;
        $scope.updtCrianca = false;

        $scope.CriancaAdd = {
            id: 0,
            nome: '',
            escola_id: '',
            escolaName: '',
            serie: '',
            observacao: ''
        };
    };

    $scope.showListCrianca = function () {
        $scope.addCrianca = false;
        $scope.lstCrianca = true;
        $scope.updtCrianca = false;
    };

    $scope.inserirCrianca = function () {
        $http.post('api/createCrianca', $scope.CriancaAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    toastr.success('Crianca adicionada!', 'Sucesso');
                    $scope.listarCriancas();
                    $scope.showListCrianca();
                } else {
                    toastr.error('Erro ao inserir Crianca', 'Erro');
                }
            })
            .error(function () {
                toastr.error('Erro ao inserir Crianca', 'Erro');
        });
    }

       
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
                console.log(data);
                toastr.error('Erro ao localizar Endereços', 'Erro');
            });
    };

    $scope.editarCrianca = function (idCrianca) {
        $http.get('api/getCrianca/' + idCrianca)
            .success(function (data) {
                console.log(data);
                $scope.Crianca = data.result;
                $scope.showEditarCrianca();
            })
            .error(function (data) {
                toastr.error('Falha em editar Crianca', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirCrianca = function (idCrianca) {
        $http.get('api/excluirCrianca/' + idCrianca)
            .success(function (data) {
                toastr.success('Crianca apagada com sucesso', 'Sucesso');
                $scope.listarCriancas();
                console.log(data);
            })
            .error(function (data) {
                toastr.error('Falha em excluir crianca', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarCrianca = function () {
        $http.post('api/alterarCrianca/' + $scope.Crianca.id, $scope.Crianca)
        .success(function (data) {
            if (!data.erro) {
                // auterou a Crianca
                toastr.success('Dados da Crianca atualizado com sucesso', 'Sucesso');
                $scope.listarCriancas();
                $scope.showListCrianca();
            } else {
                toastr.error('Falha em alterar dados da Crianca', 'Erro');
                console.log(data);
            }
        })
        .error(function (data) {
            toastr.error('Falha em alterar dados da Crianca', 'Erro');
            console.log(data);
        });
    };

    
  
    $scope.listaEscola = {};
    $scope.listarEscolas = function () {
        $http.get('api/listarEscolas')
            .success(function (data) {
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaEscola = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar escolas', 'Erro');
            });
    };

    $scope.listarEscolas();
    $scope.listarCriancas();

})

