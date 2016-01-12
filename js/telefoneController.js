app.controller('telefoneController', function ($scope, $http, toastr) {
    $scope.Telefone = {
        id: 0,
        ddd: '',
        numero: '',
        ramal: 0,
        observacao: '',
        pessoa_id: ''

    };

    $scope.TelefoneAdd = {
        id: 0,
        ddd: '',
        numero: '',
        ramal: 0,
        observacao: '',
        pessoa_id: ''
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
    };

    $scope.showListTelefone = function () {
        $scope.addTelefone = false;
        $scope.lstTelefone = true;
        $scope.updtTelefone = false;
    };

    //$scope.inserirTelefone = function () {
    //    $scope.Endereco = {
    //        logradouro: $scope.TelefoneAdd.enderecoLogradouro,
    //        numero: $scope.TelefoneAdd.enderecoNumero,
    //        complemento: $scope.TelefoneAdd.enderecoComplemento,
    //        bairro: $scope.TelefoneAdd.enderecoBairro,
    //        cidade_id: $scope.TelefoneAdd.enderecoCidadeId,
    //        cidadeName: $scope.TelefoneAdd.enderecoCidadeName,
    //        cep: $scope.TelefoneAdd.enderecoCep,
    //        latitude: $scope.TelefoneAdd.enderecoLatitude,
    //        longetude: $scope.TelefoneAdd.enderecoLongetude,
    //        ponto_referencia: $scope.TelefoneAdd.enderecoPontoReferencia
    //    };

    //        $http.post('api/createEndereco', $scope.Endereco)
    //        .success(function (data) {
    //            console.log(data);
    //            if (!data.erro) {
    //                toastr.success('Endereco da Telefone adicionada!', 'Sucesso');
                    
    //                $scope.maxId = 0;
                    
                    
    //                $http.get('api/listarMaxIdEnderecos')
    //                    .success(function (data) {
    //                        if (data.result.length == 0) {
    //                            toastr.info('Não foram encontrados registos', 'Informação');
    //                        } else {
    //                            $scope.TelefoneAdd.enderecoId = data.result[0].maxId;
    //                            $http.post('api/createTelefone', $scope.TelefoneAdd)
    //                            .success(function (data) {
    //                                console.log(data);
    //                                if (!data.erro) {
    //                                    toastr.success('Telefone adicionada!', 'Sucesso');
    //                                    $scope.listarTelefones();
    //                                    $scope.showListTelefone();
    //                                } else {
    //                                    toastr.error('Erro ao inserir Telefone', 'Erro');
    //                                }
    //                            })
    //                            .error(function () {
    //                                toastr.error('Erro ao inserir Telefone', 'Erro');
    //                            });
    //                        }
    //                    })
    //                    .error(function (data) {
    //                        console.log(data);
    //                        toastr.error('Erro ao localizar Endereços', 'Erro');
    //                    });
                    

                    

    //            } else {
    //                toastr.error('Erro no servidor', 'Erro');
    //            }
    //        })
    //        .error(function () {
    //            toastr.error('Erro no servidor', 'Erro');
    //        });
    //}

       
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


    //$scope.excluirTelefone = function (idTelefone) {
    //    $http.get('api/excluirTelefone/' + idTelefone)
    //        .success(function (data) {
    //            toastr.success('Telefone apagada com sucesso', 'Sucesso');
    //            $scope.listarTelefones();
    //            console.log(data);
    //        })
    //        .error(function (data) {
    //            toastr.error('Falha em excluir Perfil usuario', 'Erro');
    //            console.log(data);
    //        });
    //};

    $scope.alterarTelefone = function () {
        $scope.Endereco = {
            id: $scope.Telefone.enderecoId,
            logradouro: $scope.Telefone.enderecoLogradouro,
            numero: $scope.Telefone.enderecoNumero,
            complemento: $scope.Telefone.enderecoComplemento,
            bairro: $scope.Telefone.enderecoBairro,
            cidade_id: $scope.Telefone.enderecoCidadeId,
            cidadeName: $scope.Telefone.enderecoCidadeName,
            cep: $scope.Telefone.enderecoCep,
            latitude: $scope.Telefone.enderecoLatitude,
            longetude: $scope.Telefone.enderecoLongetude,
            ponto_referencia: $scope.Telefone.enderecoPontoReferencia
        };


        $http
            .post('api/alterarEndereco/' + $scope.Endereco.id, $scope.Endereco)
            .success(function (data) {

                if (!data.erro) {
                    // alterou o Endereço
                    toastr.success('Endereço da Telefone atualizado com sucesso', 'Sucesso');

                    $http
                    .post('api/alterarTelefone/' + $scope.Telefone.id, $scope.Telefone)
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

                } else {
                    toastr.error('Falha em alterar Endereço da Telefone', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar Endereço da Telefone', 'Erro');
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

