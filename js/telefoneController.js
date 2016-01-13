app.controller('telefoneController', function ($scope, $http, toastr) {
    $scope.Telefone = {
        id: 0,
        ddd: '',
        numero: '',
        ramal: '',
        observacao: '',
        pessoa_id: '',
        pessoaName: ''

    };

    $scope.TelefoneAdd = {
        id: 0,
        ddd: '',
        numero: '',
        ramal: '',
        observacao: '',
        pessoa_id: '',
        pessoaName: ''
    };

    $scope.Pessoa = {
        id: 0,
        razao_social : ''
    };

    
    $scope.lstTelefone = true;
    $scope.addTelefone = false;
    $scope.updtTelefone = false;

    $scope.showEditarTelefone = function () {
        $scope.addTelefone = false;
        $scope.lstTelefone = false;
        $scope.updtTelefone = true;
    };

    $scope.showAddTelefone = function () {
        $scope.addTelefone = true;
        $scope.lstTelefone = false;
        $scope.updtTelefone = false;
        $scope.TelefoneAdd = {
            id: 0,
            ddd: '',
            numero: '',
            ramal: '',
            observacao: '',
            pessoa_id: '',
            pessoaName: ''
        };

    };

    $scope.showListTelefone = function () {
        $scope.addTelefone = false;
        $scope.lstTelefone = true;
        $scope.updtTelefone = false;
    };

    $scope.inserirTelefone = function () {
        $http.post('api/createTelefone', $scope.TelefoneAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    toastr.success('Telefone adicionada!', 'Sucesso');
                    $scope.listarTelefones();
                    $scope.showListTelefone();
                } else {
                    toastr.error('Erro ao inserir Telefone', 'Erro');
                }
            })
            .error(function () {
                toastr.error('Erro ao inserir Telefone', 'Erro');
        });
    }

       
    $scope.listaTelefones = {};
    $scope.listarTelefones = function () {
        $http.get('api/listarTelefones')
            .success(function (data) {
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaTelefones = data.result;
                }
            })
            .error(function (data) {
                console.log(data);
                toastr.error('Erro ao localizar Endereços', 'Erro');
            });
    };

    $scope.editarTelefone = function (idTelefone) {
        $http.get('api/getTelefone/' + idTelefone)
            .success(function (data) {
                $scope.Telefone = data.result;
                $scope.showEditarTelefone();
            })
            .error(function (data) {
                toastr.error('Falha em editar Telefone', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirTelefone = function (idTelefone) {
        $http.get('api/excluirTelefone/' + idTelefone)
            .success(function (data) {
                toastr.success('Telefone apagada com sucesso', 'Sucesso');
                $scope.listarTelefones();
                console.log(data);
            })
            .error(function (data) {
                toastr.error('Falha em excluir telefone', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarTelefone = function () {
        $http.post('api/alterarTelefone/' + $scope.Telefone.id, $scope.Telefone)
        .success(function (data) {
            if (!data.erro) {
                // auterou a Telefone
                toastr.success('Dados da Telefone atualizado com sucesso', 'Sucesso');
                $scope.listarTelefones();
                $scope.showListTelefone();
            } else {
                toastr.error('Falha em alterar dados da Telefone', 'Erro');
                console.log(data);
            }
        })
        .error(function (data) {
            toastr.error('Falha em alterar dados da Telefone', 'Erro');
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
                toastr.error('Erro ao localizar Usuarios', 'Erro');
            });
    };

    $scope.listarPessoas();
    $scope.listarTelefones();

})

