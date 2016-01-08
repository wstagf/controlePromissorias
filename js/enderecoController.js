app.controller('enderecoController', function ($scope, $http, toastr) {
    $scope.Endereco = {
        id: 0,
        logradouro: '',
        numero: '',
        complemento: '',
        bairro: '',
        cidade_id: 0,
        cep: 0,
        latitude: 0,
        longetude: 0,
        ponto_referencia: ''
    };

    $scope.EnderecoAdd = {
        id: 0,
        logradouro: '',
        numero: '',
        complemento: '',
        bairro: '',
        cidade_id: 0,
        cep: 0,
        latitude: 0,
        longetude: 0,
        ponto_referencia: ''
    };

    
    $scope.lstEndereco = true;
    $scope.addEndereco = false;
    $scope.updtEndereco = false;

    $scope.showEditarEndereco = function () {
        $scope.addEndereco = false;
        $scope.lstEndereco = false;
        $scope.updtEndereco = true;
    };

    $scope.showAddEndereco = function () {
        $scope.addEndereco = true;
        $scope.lstEndereco = false;
        $scope.updtEndereco = false;
    };

    $scope.showListEndereco = function () {
        $scope.addEndereco = false;
        $scope.lstEndereco = true;
        $scope.updtEndereco = false;
    };

    $scope.inserirEndereco = function () {
        $http.post('api/createEndereco', $scope.EnderecoAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    $scope.EnderecoAdd = {
                        id: 0,
                        descricao: ''
                    };
                    toastr.success('Endereço adicionado!', 'Sucesso');
                    $scope.listarEnderecos();
                    $scope.showListEndereco();
                } else {
                    toastr.error('Erro no servidor', 'Erro');
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

       
    $scope.listaEnderecos = {};
    $scope.listarEnderecos = function () {
        $http.get('api/listarEnderecos')
            .success(function (data) {
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaEnderecos = data.result;
                }
            })
            .error(function (data) {
                console.log(data);
                toastr.error('Erro ao localizar Endereços', 'Erro');
            });
    };

    $scope.editarEndereco = function (idEndereco) {
        $http.get('api/getEndereco/' + idEndereco)
            .success(function (data) {
                $scope.Endereco = data.result;
                $scope.showEditarEndereco();
            })
            .error(function (data) {
                toastr.error('Falha em editar Endereço', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirEndereco = function (idEndereco) {
        $http.get('api/excluirEndereco/' + idEndereco)
            .success(function (data) {
                toastr.success('Endereço apagado com sucesso', 'Sucesso');
                $scope.listarEnderecos();
                console.log(data);
            })
            .error(function (data) {
                toastr.error('Falha em excluir Perfil usuario', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarEndereco = function () {
        $http
            .post('api/alterarEndereco/' + $scope.Endereco.id, $scope.Endereco)
            .success(function (data) {

                if (!data.erro) {
                    // deu certo a alteração
                    toastr.success('Endereço atualizado com sucesso', 'Sucesso');
                    $scope.listarEnderecos();
                    $scope.showListEndereco();
                } else {
                    toastr.error('Falha em alterar Endereço', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar Endereço', 'Erro');
                console.log(data);
            });
    };

    $scope.listarEnderecos();
    
    $scope.ExibirEndereco = function (idEndereco) {
        $http.get('api/getEndereco/' + idEndereco)
            .success(function (data) {
                $scope.Endereco = data.result;
                console.log($scope.Endereco);
            })
            .error(function (data) {
                toastr.error('Falha em editar Endereço', 'Erro');
                console.log(data);
            });
    };

    $scope.buscarEndereco = function (enderecoId, latitude, longetude) {
        $scope.ExibirEndereco(enderecoId);
        console.log(latitude);
        console.log(longetude);
    }

})
