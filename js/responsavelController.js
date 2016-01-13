app.controller('responsavelController', function ($scope, $http, toastr) {
    $scope.Responsavel = {
        id: 0,
        crianca_id: '',
        pessoa_id: '',
        responsavelName: '',
        criancaName : ''

    };

    $scope.ResponsavelAdd = {
        id: 0,
        crianca_id: '',
        pessoa_id: '',
        responsavelName: '',
        criancaName: ''
    };

    $scope.Pessoa = {
        id: 0,
        nome: ''
    };
    $scope.Crianca = {
        id: 0,
        nome: ''
    };

    
    $scope.lstResponsavel = true;
    $scope.addResponsavel = false;
    $scope.updtResponsavel = false;

    $scope.showEditarResponsavel = function () {
        $scope.addResponsavel = false;
        $scope.lstResponsavel = false;
        $scope.updtResponsavel = true;
    };

    $scope.showAddResponsavel = function () {
        $scope.addResponsavel = true;
        $scope.lstResponsavel = false;
        $scope.updtResponsavel = false;

        $scope.ResponsavelAdd = {
            id: 0,
            crianca_id: '',
            pessoa_id: '',
            responsavelName: '',
            criancaName: ''
        };

    };

    $scope.showListResponsavel = function () {
        $scope.addResponsavel = false;
        $scope.lstResponsavel = true;
        $scope.updtResponsavel = false;
    };


    $scope.inserirResponsavel = function () {
        $http.post('api/createResponsavel', $scope.ResponsavelAdd)
            .success(function (data) {
                if (!data.erro) {
                    console.log(data);
                    toastr.success('Responsavel adicionada!', 'Sucesso');
                    $scope.listarResponsaveis();
                    $scope.showListResponsavel();
                } else {
                    console.log(data);
                    toastr.error('Erro ao inserir Responsavel', 'Erro');
                }
            })
            .error(function (data) {
                console.log(data);
                toastr.error('Erro ao inserir Responsavel', 'Erro');
        });
    }

       
    $scope.listaResponsaveis = {};
    $scope.listarResponsaveis = function () {
        $http.get('api/listarResponsaveis')
            .success(function (data) {
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaResponsaveis = data.result;
                }
            })
            .error(function (data) {
                console.log(data);
                toastr.error('Erro ao localizar Endereços', 'Erro');
            });
    };


    $scope.editarResponsavel = function (idResponsavel) {
        $http.get('api/getResponsavel/' + idResponsavel)
            .success(function (data) {
                console.log(data);
                $scope.Responsavel = data.result;
                $scope.showEditarResponsavel();
            })
            .error(function (data) {
                console.log(data);
                toastr.error('Falha em editar Responsavel', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirResponsavel = function (idResponsavel) {
        $http.get('api/excluirResponsavel/' + idResponsavel)
            .success(function (data) {
                toastr.success('Responsavel apagado com sucesso', 'Sucesso');
                $scope.listarResponsaveis();
                console.log(data);
            })
            .error(function (data) {
                toastr.error('Falha em excluir Responsavel', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarResponsavel = function () {
        $http.post('api/alterarResponsavel/' + $scope.Responsavel.id, $scope.Responsavel)
        .success(function (data) {
            if (!data.erro) {
                // alterou a Responsavel
                console.log(data);
                toastr.success('Dados da Responsavel atualizado com sucesso', 'Sucesso');
                $scope.listarResponsaveis();
                $scope.showListResponsavel();
            } else {
                toastr.error('Falha em alterar dados da Responsavel', 'Erro');
                console.log(data);
            }
        })
        .error(function (data) {
            toastr.error('Falha em alterar dados da Responsavel', 'Erro');
            console.log(data);
        });
    };

    
  
    $scope.listaPessoas = {};
    $scope.listarPessoas = function () {
        $http.get('api/listarPessoas')
            .success(function (data) {
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaPessoas = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar escolas', 'Erro');
            });
    };


    $scope.listaCriancas= {};
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
                toastr.error('Erro ao localizar escolas', 'Erro');
            });
    };

    $scope.listarPessoas();
    $scope.listarCriancas();
    $scope.listarResponsaveis();

})

