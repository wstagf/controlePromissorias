<div ng-controller="responsavelController">  

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Responsaveis</h1>
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
							<a href="#" ng-click="showAddResponsavel()" ng-show="lstResponsavel"><i class="fa fa-plus-circle fa-fw"></i>Adicionar Reponsavel</a>
							<a href="#" ng-click="showListResponsavel()" ng-show="addResponsavel"><i class="fa fa-times-circle fa-fw"></i>Cancelar Adição</a>
							<a href="#" ng-click="showListResponsavel()" ng-show="updtResponsavel"><i class="fa fa-times-circle fa-fw"></i>Cancelar Atualização</a>
						</div>
					</div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" ng-show="lstResponsavel"> 
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
									<th>Nome Crianca</th>
									<th>Nome Responsavel</th>
									<th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX" ng-repeat="model in listaResponsaveis track by model.id">
                                    <td>{{model.id}}</td>
									<td>{{model.criancaName}}</td>
                                    <td>{{model.responsavelName}}</td>
                                    <td class="center">
										<a href="#"  ng-click="editarResponsavel(model.id)"><i class="fa fa-info-circle fa-fw"></i> Editar</a>
										<a href="#" ng-click="excluirResponsavel(model.id)"><i class="fa fa-minus-circle fa-fw"></i> Excluir</a>
									</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="panel-body" ng-show="addResponsavel">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="inserirResponsavel()">
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Criança</label>
									<select ng-model="ResponsavelAdd.crianca_id"  class="form-control">
									<option ng-repeat="crianca in listaCriancas" value="{{crianca.id}}" > {{crianca.nome}} </option>
									</select>
								</div>
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Responsavel</label>
									<select ng-model="ResponsavelAdd.pessoa_id"  class="form-control">
									<option ng-repeat="pessoa in listaPessoas" value="{{pessoa.id}}" > {{pessoa.razao_social}} </option>
									</select>
								</div>
							</div>
							<div class="form-group">
							<div class="col-sm-10">
									<label for="inputEmail3" class="control-label">&nbsp</label>
									<label for="inputEmail3" class="control-label">&nbsp</label>
									<button type="submit" class="btn btn-default">Cadastrar Responsavel</button>
								</div>
							</div>
						</form>
                    </div>
                </div>
				<div class="panel-body" ng-show="updtResponsavel">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="alterarResponsavel()">
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Criança</label>
									<select ng-model="Responsavel.crianca_id"  class="form-control">
									<option ng-repeat="crianca in listaCriancas" value="{{crianca.id}}" > {{crianca.nome}} </option>
									</select>
								</div>
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Responsavel</label>
									<select ng-model="Responsavel.pessoa_id"  class="form-control">
									<option ng-repeat="pessoa in listaPessoas" value="{{pessoa.id}}" > {{pessoa.razao_social}} </option>
									</select>
								</div>
							</div>
							<div class="form-group">
							<div class="col-sm-10">
									<label for="inputEmail3" class="control-label">&nbsp</label>
									<label for="inputEmail3" class="control-label">&nbsp</label>
									<button type="submit" class="btn btn-default">Alterar Responsavel</button>
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


		

