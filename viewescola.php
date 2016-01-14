<div ng-controller="viewEscolaController">  

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Escolas</h1>
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
							<a href="#" ng-click="showAddEscola()" ng-show="lstEscola"><i class="fa fa-plus-circle fa-fw"></i>Adicionar Escola</a>
							<a href="#" ng-click="showListEscola()" ng-show="addEscola"><i class="fa fa-times-circle fa-fw"></i>Cancelar Adição</a>
							<a href="#" ng-click="showListEscola()" ng-show="updtEscola"><i class="fa fa-times-circle fa-fw"></i>Cancelar Atualização</a>
							
						</div>
					</div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" ng-show="lstEscola"> 
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
									<th>Telefone</th>
									<th>Endereço</th>
                                    <th>Localização</th>
									<th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX" ng-repeat="model in listaEscolas track by model.id">
                                    <td>{{model.id}}</td>
                                    <td>{{model.descricao}}</td>
                                    <td>({{model.dddtelefone}}) {{model.numtelefone}}</td>
                                    <td>{{model.enderecoLogradouro}}, nº {{model.enderecoNumero}} - Comp. {{model.enderecoComplemento}} ,  {{model.enderecoBairro}}  - {{model.enderecoCidadeName}}</td>
		                            <td>
										<a href="#"  ng-click="ExibirEndereco(model.enderecoId, model.enderecoLatitude, model.enderecoLongetude)" data-toggle="modal" data-target="#myModal"><i class="fa fa-info-circle fa-fw"></i> Localização</a>
									</td>
                                    <td class="center">
										<a href="#"  ng-click="editarEscola(model.id)"><i class="fa fa-info-circle fa-fw"></i> Editar</a>
										<a href="#" ng-click="excluirEscola(model.id)"><i class="fa fa-minus-circle fa-fw"></i> Excluir</a>
									</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="panel-body" ng-show="addEscola">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="inserirEscola()">
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Nome*</label>
									<input type="text" class="form-control" id="inputAdd_nome" placeholder="Nome da escola " ng-model="EscolaAdd.descricao" required>
								</div>
								<div class="col-sm-6">
									<div class="col-sm-4">
										<label for="inputEmail3" class="control-label">Telefone</label>
										<input type="text" class="form-control" id="inputAdd_dddTelefone" placeholder="(0XX)" ng-model="EscolaAdd.dddtelefone" >
									</div>
									<div class="col-sm-8">
										<label for="inputEmail3" class="control-label">&nbsp</label>
										<input type="text" class="form-control" id="inputAdd_numeroTelefone" placeholder="99999-9999" ng-model="EscolaAdd.numtelefone" >
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Observações*</label>
									<input type="text" class="form-control" id="inputAdd_observacoes" placeholder="Observações úteis" ng-model="EscolaAdd.observacoes" required>
								</div>
							</div>
							<div class="well">
								<h4>Endereço</h4>
								
								<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Logradouro*</label>
									<input type="text" class="form-control" id="inputAdd_logradouro" placeholder="Rua / Avenida ... " ng-model="EscolaAdd.enderecoLogradouro" required>
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Complemento</label>
									<input type="text" class="form-control" id="inputAdd_complemento" placeholder="Qd. XX, Lt. YYY, Apt 0..." ng-model="EscolaAdd.enderecoComplemento" >
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="control-label">Número</label>
									<input type="text" class="form-control" id="inputAdd_numero" placeholder="Usuário" ng-model="EscolaAdd.enderecoNumero" >
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Bairro*</label>
									<input type="text" class="form-control" id="inputAdd_bairro" placeholder="Bairro / Setor" ng-model="EscolaAdd.enderecoBairro" required>
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Cidade*</label>
									<select ng-model="EscolaAdd.enderecoCidadeId"  class="form-control">
									       <option ng-repeat="cidade in listaCidades" value="{{cidade.id}}" > {{cidade.descricao}} </option>
								    </select>
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="control-label">Cep</label>
									<input type="text" class="form-control" id="inputAdd_cep" placeholder="Cep" ng-model="EscolaAdd.enderecoCep">
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-6">
								<label for="inputEmail3" class="control-label">Ponto de Referencia</label>
									<input type="text" class="form-control" id="inputAdd_ponto_referencia" placeholder="Ponto de Referencia" ng-model="EscolaAdd.enderecoPontoReferencia" >
								</div>
														
								<div class="col-sm-3">
									<label for="inputEmail3" class="control-label">Longetude</label>
									<input type="text" class="form-control" id="inputAdd_longetude" placeholder="Longetude" ng-model="EscolaAdd.enderecoLongetude" >
								</div>
														
								<div class="col-sm-3">
									<label for="inputEmail3" class="control-label">Latitude</label>
									<input type="text" class="form-control" id="inputAdd_latitude" placeholder="Latitude" ng-model="EscolaAdd.enderecoLatitude" >
								</div>
							</div>

							<div class="form-group">
							<div class="col-sm-9">
								
							</div>
							
							</div>
							</div>
							<div class="col-sm-10">
								<button type="submit" class="btn btn-default">Cadastrar Escola</button>
							</div>
							
							
						</form>
                    </div>
                </div>
				<div class="panel-body" ng-show="updtEscola">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="alterarEscola()">
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Nome*</label>
									<input type="text" class="form-control" id="input_nome" placeholder="Nome da escola " ng-model="Escola.descricao" required>
								</div>
								<div class="col-sm-6">
									<div class="col-sm-4">
										<label for="inputEmail3" class="control-label">Telefone</label>
										<input type="text" class="form-control" id="input_dddTelefone" placeholder="(0XX)" ng-model="Escola.dddtelefone" >
									</div>
									<div class="col-sm-8">
										<label for="inputEmail3" class="control-label">&nbsp</label>
										<input type="text" class="form-control" id="input_numeroTelefone" placeholder="99999-9999" ng-model="Escola.numtelefone" >
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Observações*</label>
									<input type="text" class="form-control" id="input_observacoes" placeholder="Observações úteis" ng-model="Escola.observacoes" required>
								</div>
							</div>
							<div class="well">
								<h4>Endereço</h4>
								
								<div class="form-group">
									<div class="col-sm-6">
										<label for="inputEmail3" class="control-label">Logradouro*</label>
										<input type="text" class="form-control" id="input_logradouro" placeholder="Rua / Avenida ... " ng-model="Escola.enderecoLogradouro" required>
									</div>
									<div class="col-sm-4">
										<label for="inputEmail3" class="control-label">Complemento</label>
										<input type="text" class="form-control" id="input_complemento" placeholder="Qd. XX, Lt. YYY, Apt 0..." ng-model="Escola.enderecoComplemento" >
									</div>
									<div class="col-sm-2">
										<label for="inputEmail3" class="control-label">Número</label>
										<input type="text" class="form-control" id="input_numero" placeholder="Usuário" ng-model="Escola.enderecoNumero" >
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-6">
										<label for="inputEmail3" class="control-label">Bairro*</label>
										<input type="text" class="form-control" id="input_bairro" placeholder="Bairro / Setor" ng-model="Escola.enderecoBairro" required>
									</div>
									<div class="col-sm-4">
										<label for="inputEmail3" class="control-label">Cidade*</label>
										<select ng-model="Escola.enderecoCidadeId"  class="form-control">
											   <option ng-repeat="cidade in listaCidades" value="{{cidade.id}}" > {{cidade.descricao}} </option>
										</select>
									</div>
									<div class="col-sm-2">
										<label for="inputEmail3" class="control-label">Cep</label>
										<input type="text" class="form-control" id="input_cep" placeholder="Cep" ng-model="Escola.enderecoCep">
									</div>
								</div>
							
								<div class="form-group">
									<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Ponto de Referencia</label>
										<input type="text" class="form-control" id="input_ponto_referencia" placeholder="Ponto de Referencia" ng-model="Escola.enderecoPontoReferencia" >
									</div>
														
									<div class="col-sm-3">
										<label for="inputEmail3" class="control-label">Longetude</label>
										<input type="text" class="form-control" id="input_longetude" placeholder="Longetude" ng-model="Escola.enderecoLongetude" >
									</div>
														
									<div class="col-sm-3">
										<label for="inputEmail3" class="control-label">Latitude</label>
										<input type="text" class="form-control" id="input_latitude" placeholder="Latitude" ng-model="Escola.enderecoLatitude" >
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-9">
								
								</div>
								<div class="col-sm-10">
									<button type="submit" class="btn btn-default">Atualizar Escola</button>
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


		
