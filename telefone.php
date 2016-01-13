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
									<th>Pessoa</th>
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
									<td>{{model.pessoaName}}</td>
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
								<div class="col-sm-3">
									<label for="inputEmail3" class="control-label">DDD</label>
									<input type="text" class="form-control" id="input_dddTelefone" placeholder="DDD" ng-model="TelefoneAdd.ddd" >
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Telefone</label>
									<input type="text" class="form-control" id="input_numeroTelefone" placeholder="Número do Telefone" ng-model="TelefoneAdd.numero" >
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Ramal</label>
									<input type="text" class="form-control" id="input_numeroTelefone" placeholder="Ramal do Telefone" ng-model="TelefoneAdd.ramal" >
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Observações</label>
									<input type="text" class="form-control" id="input_numeroTelefone" placeholder="Observação" ng-model="TelefoneAdd.observacao" >
								</div>
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Pessoa</label>
									<select ng-model="TelefoneAdd.pessoa_id"  class="form-control">
									<option ng-repeat="pessoa in listaPessoas" value="{{pessoa.id}}" > {{pessoa.razao_social}} </option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-2">
								
								</div>
								<div class="col-sm-10">
									<button type="submit" class="btn btn-default">Cadastrar Telefone</button>
								</div>
							</div>
						</form>
                    </div>
                </div>
				<div class="panel-body" ng-show="updtTelefone">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="alterarTelefone()">
							<div class="form-group">
								<div class="col-sm-3">
									<label for="inputEmail3" class="control-label">DDD</label>
									<input type="text" class="form-control" id="input_dddTelefone" placeholder="DDD" ng-model="Telefone.ddd" >
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Telefone</label>
									<input type="text" class="form-control" id="input_numeroTelefone" placeholder="Número do Telefone" ng-model="Telefone.numero" >
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Ramal</label>
									<input type="text" class="form-control" id="input_numeroTelefone" placeholder="Ramal do Telefone" ng-model="Telefone.ramal" >
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Observações</label>
									<input type="text" class="form-control" id="input_numeroTelefone" placeholder="Observação" ng-model="Telefone.observacao" >
								</div>
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Pessoa</label>
									<select ng-model="Telefone.pessoa_id"  class="form-control">
									<option ng-repeat="pessoa in listaPessoas" value="{{pessoa.id}}" > {{pessoa.razao_social}} </option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-2">
								
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


		
