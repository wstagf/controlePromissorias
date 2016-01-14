<div ng-controller="trabalhoController">  

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Trabalhos</h1>
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
							<a href="#" ng-click="showAddTrabalho()" ng-show="lstTrabalho"><i class="fa fa-plus-circle fa-fw"></i>Adicionar Trabalho</a>
							<a href="#" ng-click="showListTrabalho()" ng-show="addTrabalho"><i class="fa fa-times-circle fa-fw"></i>Cancelar Adição</a>
							<a href="#" ng-click="showListTrabalho()" ng-show="updtTrabalho"><i class="fa fa-times-circle fa-fw"></i>Cancelar Atualização</a>
						</div>
					</div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" ng-show="lstTrabalho"> 
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
									<th>Nome Crianca</th>
									<th>Valor</th>
									<th>Parcelas</th>
									<th>Saldo</th>
									<th>Observações</th>
									<th>Ações</th>									
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX" ng-repeat="model in listaTrabalhos track by model.id">
                                    <td>{{model.id}}</td>
									<td>{{model.criancaName}}</td>
                                    <td>{{model.valor}}</td>
                                    <td>{{model.parcelas}}</td>
									<td>{{model.saldo}}</td>
									<td>{{model.observacoes}}</td>
                                    <td class="center">
										<a href="#"  ng-click="editarTrabalho(model.id)"><i class="fa fa-info-circle fa-fw"></i> Editar</a>
										<a href="#" ng-click="excluirTrabalho(model.id)"><i class="fa fa-minus-circle fa-fw"></i> Excluir</a>
									</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="panel-body" ng-show="addTrabalho">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="inserirTrabalho()">
							<div class="form-group">
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Criança</label>
									<select ng-model="TrabalhoAdd.crianca_id"  class="form-control">
									<option ng-repeat="crianca in listaCriancas" value="{{crianca.id}}" > {{crianca.nome}} </option>
									</select>
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Valor</label>
									<input type="text" class="form-control" id="input_valor" placeholder="Valor" ng-model="TrabalhoAdd.valor" >
								</div>
								
								<div class="col-sm-2">
									<label for="inputEmail3" class="control-label">Nº Parcelas</label>
									<input type="text" class="form-control" id="input_num_parce" placeholder="Número de parcelas" ng-model="TrabalhoAdd.parcelas" >
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="control-label">Saldo</label>
									<input type="text" class="form-control" id="input_num_parce" placeholder="Saldo" ng-model="TrabalhoAdd.saldo" >
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<label for="inputEmail3" class="control-label">Observações</label>
									<input type="text" class="form-control" id="input_observa" placeholder="Observações" ng-model="TrabalhoAdd.observacoes" >
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-2">
								
								</div>
								<div class="col-sm-10">
									<button type="submit" class="btn btn-default">Cadastrar Trabalho</button>
								</div>
							</div>
						</form>
                    </div>
                </div>
				<div class="panel-body" ng-show="updtTrabalho">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="alterarTrabalho()">
							<div class="form-group">
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Criança</label>
									<select ng-model="Trabalho.crianca_id"  class="form-control">
									<option ng-repeat="crianca in listaCriancas" value="{{crianca.id}}" > {{crianca.nome}} </option>
									</select>
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Valor</label>
									<input type="text" class="form-control" id="input_valor" placeholder="Valor" ng-model="Trabalho.valor" >
								</div>
								
								<div class="col-sm-2">
									<label for="inputEmail3" class="control-label">Nº Parcelas</label>
									<input type="text" class="form-control" id="input_num_parce" placeholder="Número de parcelas" ng-model="Trabalho.parcelas" >
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="control-label">Saldo</label>
									<input type="text" class="form-control" id="input_num_parce" placeholder="Saldo" ng-model="Trabalho.saldo" >
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<label for="inputEmail3" class="control-label">Observações</label>
									<input type="text" class="form-control" id="input_observa" placeholder="Observações" ng-model="Trabalho.observacoes" >
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-2">
								
								</div>
								<div class="col-sm-10">
									<button type="submit" class="btn btn-default">Atualizar Trabalho</button>
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


		
