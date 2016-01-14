app.controller('viewEscolaController', function ($scope, $http, toastr) {
    $scope.Escola = {
        id: 0,
        descricao: '',
        dddtelefone: '',
        numtelefone: '',
        enderecoId: '',
        observacoes: '',
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

    $scope.EscolaAdd = {
        id: 0,
        descricao: '',
        dddtelefone: '',
        numtelefone: '',
        enderecoId: '',
        observacoes: '',
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

    
    $scope.lstEscola = true;
    $scope.addEscola = false;
    $scope.updtEscola = false;

    $scope.showEditarEscola = function () {
        $scope.addEscola = false;
        $scope.lstEscola = false;
        $scope.updtEscola = true;
    };

    $scope.showAddEscola = function () {
        $scope.addEscola = true;
        $scope.lstEscola = false;
        $scope.updtEscola = false;

        $scope.EscolaAdd = {
            id: 0,
            descricao: '',
            dddtelefone: '',
            numtelefone: '',
            enderecoId: '',
            observacoes: '',
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

    $scope.showListEscola = function () {
        $scope.addEscola = false;
        $scope.lstEscola = true;
        $scope.updtEscola = false;
    };

    $scope.inserirEscola = function () {
        $scope.Endereco = {
            logradouro: $scope.EscolaAdd.enderecoLogradouro,
            numero: $scope.EscolaAdd.enderecoNumero,
            complemento: $scope.EscolaAdd.enderecoComplemento,
            bairro: $scope.EscolaAdd.enderecoBairro,
            cidade_id: $scope.EscolaAdd.enderecoCidadeId,
            cidadeName: $scope.EscolaAdd.enderecoCidadeName,
            cep: $scope.EscolaAdd.enderecoCep,
            latitude: $scope.EscolaAdd.enderecoLatitude,
            longetude: $scope.EscolaAdd.enderecoLongetude,
            ponto_referencia: $scope.EscolaAdd.enderecoPontoReferencia
        };

            $http.post('api/createEndereco', $scope.Endereco)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    toastr.success('Endereco da Escola adicionada!', 'Sucesso');
                    
                    $scope.maxId = 0;
                    
                    
                    $http.get('api/listarMaxIdEnderecos')
                        .success(function (data) {
                            if (data.result.length == 0) {
                                toastr.info('Não foram encontrados registos', 'Informação');
                            } else {
                                $scope.EscolaAdd.enderecoId = data.result[0].maxId;
                                $http.post('api/createEscola', $scope.EscolaAdd)
                                .success(function (data) {
                                    console.log(data);
                                    if (!data.erro) {
                                        toastr.success('Escola adicionada!', 'Sucesso');
                                        $scope.listarEscolas();
                                        $scope.showListEscola();
                                    } else {
                                        toastr.error('Erro ao inserir escola', 'Erro');
                                    }
                                })
                                .error(function () {
                                    toastr.error('Erro ao inserir escola', 'Erro');
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

       
    $scope.listaEscolas = {};
    $scope.listarEscolas = function () {
        $http.get('api/listarEscolas')
            .success(function (data) {
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaEscolas = data.result;
                }
            })
            .error(function (data) {
                console.log(data);
                toastr.error('Erro ao localizar Endereços', 'Erro');
            });
    };

    $scope.editarEscola = function (idEscola) {
        $http.get('api/getEscola/' + idEscola)
            .success(function (data) {
                $scope.Escola = data.result;
                $scope.showEditarEscola();
            })
            .error(function (data) {
                toastr.error('Falha em editar Escola', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirEscola = function (idEscola) {
        $http.get('api/excluirEscola/' + idEscola)
            .success(function (data) {
                toastr.success('Escola apagada com sucesso', 'Sucesso');
                $scope.listarEscolas();
                console.log(data);
            })
            .error(function (data) {
                toastr.error('Falha em excluir Perfil usuario', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarEscola = function () {
        $scope.Endereco = {
            id: $scope.Escola.enderecoId,
            logradouro: $scope.Escola.enderecoLogradouro,
            numero: $scope.Escola.enderecoNumero,
            complemento: $scope.Escola.enderecoComplemento,
            bairro: $scope.Escola.enderecoBairro,
            cidade_id: $scope.Escola.enderecoCidadeId,
            cidadeName: $scope.Escola.enderecoCidadeName,
            cep: $scope.Escola.enderecoCep,
            latitude: $scope.Escola.enderecoLatitude,
            longetude: $scope.Escola.enderecoLongetude,
            ponto_referencia: $scope.Escola.enderecoPontoReferencia
        };


        $http
            .post('api/alterarEndereco/' + $scope.Endereco.id, $scope.Endereco)
            .success(function (data) {

                if (!data.erro) {
                    // alterou o Endereço
                    toastr.success('Endereço da escola atualizado com sucesso', 'Sucesso');

                    $http
                    .post('api/alterarEscola/' + $scope.Escola.id, $scope.Escola)
                    .success(function (data) {
                        if (!data.erro) {
                            // auterou a escola
                            toastr.success('Dados da escola atualizado com sucesso', 'Sucesso');
                            $scope.listarEscolas();
                            $scope.showListEscola();
                        } else {
                            toastr.error('Falha em alterar dados da escola', 'Erro');
                            console.log(data);
                        }
                    })
                    .error(function (data) {
                        toastr.error('Falha em alterar dados da escola', 'Erro');
                        console.log(data);
                    });

                } else {
                    toastr.error('Falha em alterar Endereço da escola', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar Endereço da escola', 'Erro');
                console.log(data);
            });
    };

    $scope.listarEscolas();
    
    $scope.ExibirEscola = function (idEscola, latitude, longetude) {
        $http.get('api/getEscola/' + idEscola)
            .success(function (data) {
                $('#mapaPainel').show();
                initialize(latitude, longetude, data.result);
            })
            .error(function (data) {
                toastr.error('Falha em visualizar', 'Erro');
            });
        if ($scope.Escola.id == 0) {
            return false;
        } else {
            return true;
        }
        
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

    $scope.listarCidades();

})


var a = 0;
