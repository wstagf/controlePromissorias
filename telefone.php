<div ng-controller="telefoneController">  

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Telefones</h1>
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
							<a href="#" ng-click="showAddTelefone()" ng-show="lstTelefone"><i class="fa fa-plus-circle fa-fw"></i>Adicionar Telefone</a>
							<a href="#" ng-click="showListTelefone()" ng-show="addTelefone"><i class="fa fa-times-circle fa-fw"></i>Cancelar Adição</a>
							<a href="#" ng-click="showListTelefone()" ng-show="updtTelefone"><i class="fa fa-times-circle fa-fw"></i>Cancelar Atualização</a>
						</div>
					</div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" ng-show="lstTelefone"> 
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>DDD</th>
									<th>Número Telefone</th>
									<th>Ramal</th>
									<th>Observações</th>
									<th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX" ng-repeat="model in listaTelefones track by model.id">
                                    <td>{{model.id}}</td>
                                    <td>{{model.ddd}}</td>
                                    <td>{{model.numero}}</td>
									<td>{{model.ramal}}</td>
									<td>{{model.observacao}}</td>
                                    <td class="center">
										<a href="#"  ng-click="editarTelefone(model.id)"><i class="fa fa-info-circle fa-fw"></i> Editar</a>
										<a href="#" ng-click="excluirTelefone(model.id)"><i class="fa fa-minus-circle fa-fw"></i> Excluir</a>
									</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="panel-body" ng-show="addTelefone">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="inserirTelefone()">
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Nome*</label>
									<input type="text" class="form-control" id="inputAdd_nome" placeholder="Nome da Telefone " ng-model="TelefoneAdd.descricao" required>
								</div>
								<div class="col-sm-6">
									<div class="col-sm-4">
										<label for="inputEmail3" class="control-label">Telefone</label>
										<input type="text" class="form-control" id="inputAdd_dddTelefone" placeholder="(0XX)" ng-model="TelefoneAdd.dddtelefone" >
									</div>
									<div class="col-sm-8">
										<label for="inputEmail3" class="control-label">&nbsp</label>
										<input type="text" class="form-control" id="inputAdd_numeroTelefone" placeholder="99999-9999" ng-model="TelefoneAdd.numtelefone" >
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Observações*</label>
									<input type="text" class="form-control" id="inputAdd_observacoes" placeholder="Observações úteis" ng-model="TelefoneAdd.observacoes" required>
								</div>
							</div>
							<div class="well">
								<h4>Endereço</h4>
								
								<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Logradouro*</label>
									<input type="text" class="form-control" id="inputAdd_logradouro" placeholder="Rua / Avenida ... " ng-model="TelefoneAdd.enderecoLogradouro" required>
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Complemento</label>
									<input type="text" class="form-control" id="inputAdd_complemento" placeholder="Qd. XX, Lt. YYY, Apt 0..." ng-model="TelefoneAdd.enderecoComplemento" >
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="control-label">Número</label>
									<input type="text" class="form-control" id="inputAdd_numero" placeholder="Usuário" ng-model="TelefoneAdd.enderecoNumero" >
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Bairro*</label>
									<input type="text" class="form-control" id="inputAdd_bairro" placeholder="Bairro / Setor" ng-model="TelefoneAdd.enderecoBairro" required>
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Cidade*</label>
									<select ng-model="TelefoneAdd.enderecoCidadeId"  class="form-control">
									       <option ng-repeat="cidade in listaCidades" value="{{cidade.id}}" > {{cidade.descricao}} </option>
								    </select>
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="control-label">Cep</label>
									<input type="text" class="form-control" id="inputAdd_cep" placeholder="Cep" ng-model="TelefoneAdd.enderecoCep">
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-6">
								<label for="inputEmail3" class="control-label">Ponto de Referencia</label>
									<input type="text" class="form-control" id="inputAdd_ponto_referencia" placeholder="Ponto de Referencia" ng-model="TelefoneAdd.enderecoPontoReferencia" >
								</div>
														
								<div class="col-sm-3">
									<label for="inputEmail3" class="control-label">Longetude</label>
									<input type="text" class="form-control" id="inputAdd_longetude" placeholder="Longetude" ng-model="TelefoneAdd.enderecoLongetude" >
								</div>
														
								<div class="col-sm-3">
									<label for="inputEmail3" class="control-label">Latitude</label>
									<input type="text" class="form-control" id="inputAdd_latitude" placeholder="Latitude" ng-model="TelefoneAdd.enderecoLatitude" >
								</div>
							</div>

							<div class="form-group">
							<div class="col-sm-9">
								
							</div>
							
							</div>
							</div>
							<div class="col-sm-10">
								<button type="submit" class="btn btn-default">Cadastrar Telefone</button>
							</div>
							
							                                    
                                    <td>{{model.ddd}}</td>
                                    <td>{{model.numero}}</td>
									<td>{{model.ramal}}</td>
									<td>{{model.observacao}}</td>
						</form>
                    </div>
                </div>
				<div class="panel-body" ng-show="updtTelefone">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="alterarTelefone()">
							<div class="form-group">
								<div class="col-sm-12">
									<div class="col-sm-2">
										<label for="inputEmail3" class="control-label">DDD</label>
										<input type="text" class="form-control" id="input_dddTelefone" placeholder="DDD" ng-model="Telefone.ddd" >
									</div>
									<div class="col-sm-4">
										<label for="inputEmail3" class="control-label">Telefone</label>
										<input type="text" class="form-control" id="input_numeroTelefone" placeholder="Número do Telefone" ng-model="Telefone.numero" >
									</div>
									<div class="col-sm-2">
										<label for="inputEmail3" class="control-label">Ramal</label>
										<input type="text" class="form-control" id="input_numeroTelefone" placeholder="Ramal do Telefone" ng-model="Telefone.ramal" >
									</div>
									<div class="col-sm-4">
										<label for="inputEmail3" class="control-label">Observações</label>
										<input type="text" class="form-control" id="input_numeroTelefone" placeholder="Observação" ng-model="Telefone.observacao" >
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-9">
								
								</div>
								<div class="col-sm-10">
									<button type="submit" class="btn btn-default">Atualizar Telefone</button>
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


		
