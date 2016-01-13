app.controller('pessoaController', function ($scope, $http, toastr) {
    $scope.Pessoa = {
        id: 0,
        cpf_cnpj: '',
        razao_social: '',
        nome_fantasia: '',
        endereco_id: '',
        enderecoLogradouro: '',
        enderecoNumero: '',
        enderecoComplemento: '',
        enderecoBairro: '',
        enderecoCidadeId: '',
        enderecoCidadeName: '',
        enderecoCep: '',
        enderecoLatitude: '',
        enderecoLongetude: '',
        enderecoPontoReferencia: ''
    };

 
    $scope.PessoaAdd = {
        id: 0,
        cpf_cnpj: '',
        razao_social: '',
        nome_fantasia: '',
        endereco_id: '',
        enderecoLogradouro: '',
        enderecoNumero: '',
        enderecoComplemento: '',
        enderecoBairro: '',
        enderecoCidadeId: '',
        enderecoCidadeName: '',
        enderecoCep: '',
        enderecoLatitude: '',
        enderecoLongetude: '',
        enderecoPontoReferencia: ''
    };

    $scope.Endereco = {
        id: 0,
        logradouro: '',
        numero: '',
        complemento: '',
        bairro: '',
        cidade_id: 0,
        cidadeName: '',
        cep: 0,
        latitude: 0,
        longetude: 0,
        ponto_referencia: ''
    };
    
    $scope.lstPessoa = true;
    $scope.addPessoa = false;
    $scope.updtPessoa = false;

    $scope.showEditarPessoa = function () {
        $scope.addPessoa = false;
        $scope.lstPessoa = false;
        $scope.updtPessoa = true;
    };

    $scope.showAddPessoa = function () {
        $scope.addPessoa = true;
        $scope.lstPessoa = false;
        $scope.updtPessoa = false;
    };

    $scope.showListPessoa = function () {
        $scope.addPessoa = false;
        $scope.lstPessoa = true;
        $scope.updtPessoa = false;


        $scope.PessoaAdd = {
            id: 0,
            cpf_cnpj: '',
            razao_social: '',
            nome_fantasia: '',
            endereco_id: '',
            enderecoLogradouro: '',
            enderecoNumero: '',
            enderecoComplemento: '',
            enderecoBairro: '',
            enderecoCidadeId: '',
            enderecoCidadeName: '',
            enderecoCep: '',
            enderecoLatitude: '',
            enderecoLongetude: '',
            enderecoPontoReferencia: ''
        };

    };

    $scope.inserirPessoa = function () {
        $scope.Endereco = {
            id: $scope.PessoaAdd.endereco_id,
            logradouro: $scope.PessoaAdd.enderecoLogradouro,
            numero: $scope.PessoaAdd.enderecoNumero,
            complemento: $scope.PessoaAdd.enderecoComplemento,
            bairro: $scope.PessoaAdd.enderecoBairro,
            cidade_id: $scope.PessoaAdd.enderecoCidadeId,
            cidadeName: $scope.PessoaAdd.enderecoCidadeName,
            cep: $scope.PessoaAdd.enderecoCep,
            latitude: $scope.PessoaAdd.enderecoLatitude,
            longetude: $scope.PessoaAdd.enderecoLongetude,
            ponto_referencia: $scope.PessoaAdd.enderecoPontoReferencia
        };

        $http.post('api/createEndereco', $scope.Endereco)
            .success(function (data) {
                
                if (!data.erro) {
                    toastr.success('Endereco da Pessoa adicionada!', 'Sucesso');
                    
                    $scope.maxId = 0;
                    
                    $http.get('api/listarMaxIdEnderecos')
                        .success(function (data) {
                            if (data.result.length == 0) {
                                toastr.info('Não foram encontrados registos', 'Informação');
                            } else {
                                $scope.PessoaAdd.endereco_id = data.result[0].maxId;
                                $http.post('api/createPessoa', $scope.PessoaAdd)
                                .success(function (data) {
                                    if (!data.erro) {
                                        toastr.success('Pessoa adicionada!', 'Sucesso');
                                        $scope.listarPessoas();
                                        $scope.showListPessoa();
                                    } else {
                                        toastr.error('Erro ao inserir Pessoa', 'Erro');
                                    }
                                })
                                .error(function () {
                                    toastr.error('Erro ao inserir Pessoa', 'Erro');
                                });
                            }
                        })
                        .error(function (data) {
                            console.log(data);
                            toastr.error('Erro ao localizar Endereços', 'Erro');
                        });
                } else {
                    toastr.error('Erro no servidor', 'Erro');
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

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
                console.log(data);
                toastr.error('Erro ao localizar Endereços', 'Erro');
            });
    };

    $scope.editarPessoa = function (idPessoa) {
        $http.get('api/getPessoa/' + idPessoa)
            .success(function (data) {
                $scope.Pessoa = data.result;
                $scope.showEditarPessoa();
                
            })
            .error(function (data) {
                toastr.error('Falha em editar Pessoa', 'Erro');
                console.log(data);
            });
    };
    
    $scope.excluirPessoa = function (idPessoa) {
        $http.get('api/excluirPessoa/' + idPessoa)
            .success(function (data) {
                toastr.success('Pessoa apagada com sucesso', 'Sucesso');
                $scope.listarPessoas();
            })
            .error(function (data) {
                toastr.error('Falha em excluir pessoas', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarPessoa = function () {

        console.log($scope.Pessoa);

        $scope.Endereco = {
            id: $scope.Pessoa.endereco_id,
            logradouro: $scope.Pessoa.enderecoLogradouro,
            numero: $scope.Pessoa.enderecoNumero,
            complemento: $scope.Pessoa.enderecoComplemento,
            bairro: $scope.Pessoa.enderecoBairro,
            cidade_id: $scope.Pessoa.enderecoCidadeId,
            cidadeName: $scope.Pessoa.enderecoCidadeName,
            cep: $scope.Pessoa.enderecoCep,
            latitude: $scope.Pessoa.enderecoLatitude,
            longetude: $scope.Pessoa.enderecoLongetude,
            ponto_referencia: $scope.Pessoa.enderecoPontoReferencia
        };

        

        $http
            .post('api/alterarEndereco/' + $scope.Endereco.id, $scope.Endereco)
            .success(function (data) {

                if (!data.erro) {
                    // alterou o Endereço
                    toastr.success('Endereço da pessoa atualizado com sucesso', 'Sucesso');

                    $http
                    .post('api/alterarPessoa/' + $scope.Pessoa.id, $scope.Pessoa)
                    .success(function (data) {
                        if (!data.erro) {
                            // auterou a escola
                            toastr.success('Dados da Pessoa atualizado com sucesso', 'Sucesso');
                            $scope.listarPessoas();
                            $scope.showListPessoa();
                        } else {
                            toastr.error('Falha em alterar dados da pessoa', 'Erro');
                            console.log(data);
                        }
                    })
                    .error(function (data) {
                        toastr.error('Falha em alterar dados da pessa', 'Erro');
                        console.log(data);
                    });

                } else {
                    toastr.error('Falha em alterar Endereço da pessoa', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar Endereço da pessoa', 'Erro');
                console.log(data);
            });
    };


    $scope.ExibirEndereco = function (idEndereco, latitude, longetude) {
        console.log(idEndereco);
        $http.get('api/getEndereco/' + idEndereco)
            .success(function (data) {
                $('#mapaPainel').show();
                initialize(latitude, longetude, data.result);
            })
            .error(function (data) {
                toastr.error('Falha em visualizar', 'Erro');
            });
    };
    
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

    $scope.listarPessoas();
    $scope.listarCidades();

})

