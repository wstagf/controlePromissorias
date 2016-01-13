<div ng-controller="pessoaController">  

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Pessoas</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
					<div class="row">
						<div class="col-lg-8">
						</div>
						<div class="col-lg-4">
							<a href="#" ng-click="showAddPessoa()" ng-show="lstPessoa"><i class="fa fa-plus-circle fa-fw"></i>Adicionar Pessoa</a>
							<a href="#" ng-click="showListPessoa()" ng-show="addPessoa"><i class="fa fa-times-circle fa-fw"></i>Cancelar Adição</a>
							<a href="#" ng-click="showListPessoa()" ng-show="updtPessoa"><i class="fa fa-times-circle fa-fw"></i>Cancelar Atualização</a>
							
						</div>
					</div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" ng-show="lstPessoa"> 
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
									<th>CPF</th>
									<th>Endereço</th>
									<!--<th>Telefone</th> -->
                                    <th>Localização</th>
									<th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX" ng-repeat="model in listaPessoas track by model.id">
                                    <td>{{model.id}}</td>
                                    <td>{{model.razao_social}} {{model.nome_fantasia}}</td>
									<td>{{model.cpf_cnpj}} </td>
		                            <!-- <td>({{model.dddtelefone}}) {{model.numtelefone}}</td> -->
                                    <td>{{model.enderecoLogradouro}}, nº {{model.enderecoNumero}} - Comp. {{model.enderecoComplemento}} ,  {{model.enderecoBairro}}  - {{model.enderecoCidadeName}}</td>
		                            <td>
										<a href="#"  ng-click="ExibirEndereco(model.endereco_id, model.enderecoLatitude, model.enderecoLongetude)" data-toggle="modal" data-target="#myModal"><i class="fa fa-info-circle fa-fw"></i> Localização</a>
									</td>
                                    <td class="center">
										<a href="#"  ng-click="editarPessoa(model.id)"><i class="fa fa-info-circle fa-fw"></i> Editar</a>
										<a href="#" ng-click="excluirPessoa(model.id)"><i class="fa fa-minus-circle fa-fw"></i> Excluir</a>
									</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="panel-body" ng-show="addPessoa">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="inserirPessoa()">
							<div class="form-group">
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Nome*</label>
									<input type="text" class="form-control" id="input_nome" placeholder="Razao Social / Nome:" ng-model="PessoaAdd.razao_social" >
								</div>
								<div class="col-sm-8">
									<div class="col-sm-6">
										<label for="inputEmail3" class="control-label">Nome Fantasia</label>
										<input type="text" class="form-control" id="input_dddTelefone" placeholder="Nome Fantasia" ng-model="PessoaAdd.nome_fantasia" >
									</div>
									<div class="col-sm-6">
										<label for="inputEmail3" class="control-label">Cpf/Cnpj</label>
										<input type="text" class="form-control" id="input_numeroTelefone" placeholder="CPF/CNPJ *" ng-model="PessoaAdd.cpf_cnpj" >
									</div>
								</div>
							</div>
							<div class="well">
								<h4>Endereço</h4>
								<div class="form-group">
									<div class="col-sm-6">
										<label for="inputEmail3" class="control-label">Logradouro*</label>
										<input type="text" class="form-control" id="input_logradouro" placeholder="Rua / Avenida ... " ng-model="PessoaAdd.enderecoLogradouro" >
									</div>
									<div class="col-sm-4">
										<label for="inputEmail3" class="control-label">Complemento</label>
										<input type="text" class="form-control" id="input_complemento" placeholder="Qd. XX, Lt. YYY, Apt 0..." ng-model="PessoaAdd.enderecoComplemento" >
									</div>
									<div class="col-sm-2">
										<label for="inputEmail3" class="control-label">Número</label>
										<input type="text" class="form-control" id="input_numero" placeholder="Usuário" ng-model="PessoaAdd.enderecoNumero" >
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-6">
										<label for="inputEmail3" class="control-label">Bairro*</label>
										<input type="text" class="form-control" id="input_bairro" placeholder="Bairro / Setor" ng-model="PessoaAdd.enderecoBairro" >
									</div>
									<div class="col-sm-4">
										<label for="inputEmail3" class="control-label">Cidade*</label>
										<select ng-model="PessoaAdd.enderecoCidadeId"  class="form-control">
											   <option ng-repeat="cidade in listaCidades" value="{{cidade.id}}" > {{cidade.descricao}} </option>
										</select>
									</div>
									<div class="col-sm-2">
										<label for="inputEmail3" class="control-label">Cep</label>
										<input type="text" class="form-control" id="input_cep" placeholder="Cep" ng-model="PessoaAdd.enderecoCep">
									</div>
								</div>
							
								<div class="form-group">
									<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Ponto de Referencia</label>
										<input type="text" class="form-control" id="input_ponto_referencia" placeholder="Ponto de Referencia" ng-model="PessoaAdd.enderecoPontoReferencia" >
									</div>
														
									<div class="col-sm-3">
										<label for="inputEmail3" class="control-label">Longetude</label>
										<input type="text" class="form-control" id="input_longetude" placeholder="Longetude" ng-model="PessoaAdd.enderecoLongetude" >
									</div>
														
									<div class="col-sm-3">
										<label for="inputEmail3" class="control-label">Latitude</label>
										<input type="text" class="form-control" id="input_latitude" placeholder="Latitude" ng-model="PessoaAdd.enderecoLatitude" >
									</div>
								</div>
							</div>
								<div class="form-group">
									<div class="col-sm-9">
								
									</div>
							
								</div>
							
							<div class="col-sm-10">
								<button type="submit" class="btn btn-default">Cadastrar Escola</button>
							</div>
							
							
						</form>
                    </div>
                </div>
				<div class="panel-body" ng-show="updtPessoa">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="alterarPessoa()">
							<div class="form-group">
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Nome*</label>
									<input type="text" class="form-control" id="input_nome" placeholder="Razao Social / Nome:" ng-model="Pessoa.razao_social" >
								</div>
								<div class="col-sm-8">
									<div class="col-sm-6">
										<label for="inputEmail3" class="control-label">Nome Fantasia</label>
										<input type="text" class="form-control" id="input_dddTelefone" placeholder="Nome Fantasia" ng-model="Pessoa.nome_fantasia" >
									</div>
									<div class="col-sm-6">
										<label for="inputEmail3" class="control-label">Cpf/Cnpj</label>
										<input type="text" class="form-control" id="input_numeroTelefone" placeholder="CPF/CNPJ *" ng-model="Pessoa.cpf_cnpj" >
									</div>
								</div>
							</div>
							<div class="well">
								<h4>Endereço</h4>
								<div class="form-group">
									<div class="col-sm-6">
										<label for="inputEmail3" class="control-label">Logradouro*</label>
										<input type="text" class="form-control" id="input_logradouro" placeholder="Rua / Avenida ... " ng-model="Pessoa.enderecoLogradouro" >
									</div>
									<div class="col-sm-4">
										<label for="inputEmail3" class="control-label">Complemento</label>
										<input type="text" class="form-control" id="input_complemento" placeholder="Qd. XX, Lt. YYY, Apt 0..." ng-model="Pessoa.enderecoComplemento" >
									</div>
									<div class="col-sm-2">
										<label for="inputEmail3" class="control-label">Número</label>
										<input type="text" class="form-control" id="input_numero" placeholder="Usuário" ng-model="Pessoa.enderecoNumero" >
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-6">
										<label for="inputEmail3" class="control-label">Bairro*</label>
										<input type="text" class="form-control" id="input_bairro" placeholder="Bairro / Setor" ng-model="Pessoa.enderecoBairro" >
									</div>
									<div class="col-sm-4">
										<label for="inputEmail3" class="control-label">Cidade*</label>
										<select ng-model="Pessoa.enderecoCidadeId"  class="form-control">
											   <option ng-repeat="cidade in listaCidades" value="{{cidade.id}}" > {{cidade.descricao}} </option>
										</select>
									</div>
									<div class="col-sm-2">
										<label for="inputEmail3" class="control-label">Cep</label>
										<input type="text" class="form-control" id="input_cep" placeholder="Cep" ng-model="Pessoa.enderecoCep">
									</div>
								</div>
							
								<div class="form-group">
									<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Ponto de Referencia</label>
										<input type="text" class="form-control" id="input_ponto_referencia" placeholder="Ponto de Referencia" ng-model="Pessoa.enderecoPontoReferencia" >
									</div>
														
									<div class="col-sm-3">
										<label for="inputEmail3" class="control-label">Longetude</label>
										<input type="text" class="form-control" id="input_longetude" placeholder="Longetude" ng-model="Pessoa.enderecoLongetude" >
									</div>
														
									<div class="col-sm-3">
										<label for="inputEmail3" class="control-label">Latitude</label>
										<input type="text" class="form-control" id="input_latitude" placeholder="Latitude" ng-model="Pessoa.enderecoLatitude" >
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-9">
								
								</div>
								<div class="col-sm-10">
									<button type="submit" class="btn btn-default">Atualizar Pessoa</button>
								</div>
							</div>
						</form>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.row -->
<!-- Maps API Javascript -->


		
