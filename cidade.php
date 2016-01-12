<div ng-controller="cidadeController">  
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Cidades</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
					<div class="row">
						<div class="col-lg-10">
						</div>
						<div class="col-lg-2">
							<a href="#" ng-click="showAddCidade()" ng-show="lstCidade"><i class="fa fa-plus-circle fa-fw"></i>Adicionar Cidade</a>
							<a href="#" ng-click="showListCidade()" ng-show="addCidade"><i class="fa fa-times-circle fa-fw"></i>Cancelar Adição</a>
							<a href="#" ng-click="showListCidade()" ng-show="updtCidade"><i class="fa fa-times-circle fa-fw"></i>Cancelar Atualização</a>
							
						</div>
					</div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" ng-show="lstCidade"> 
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Descrição</th>
									<th>Estado</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX" ng-repeat="model in listaCidades track by model.id">
                                    <td>{{model.id}}</td>
                                    <td>{{model.descricao}}</td>
									<td>{{model.estadoName}}</td>
                                    <td class="center">
										<a href="#"  ng-click="editarCidade(model.id)"><i class="fa fa-info-circle fa-fw"></i> Editar</a>
										<a href="#" ng-click="excluirCidade(model.id)"><i class="fa fa-minus-circle fa-fw"></i> Excluir</a>
									</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="panel-body" ng-show="addCidade">
                    <div class="dataTable_wrapper">
                        <label>Formulario de Registro de Cidades</label>
						<form class="form-horizontal" ng-submit="inserirCidade()">
							<div class="form-group">
								<div class="col-sm-10">
									<label for="inputEmail3" class="col-sm-2">Descricao</label>
									<input type="text" class="form-control" id="inputEmail3" placeholder="Nome da Cidade" ng-model="CidadeAdd.descricao" required>
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="col-sm-2">Estado</label>
									<select ng-model="CidadeAdd.estadoId"  class="form-control">
									       <option ng-repeat="estado in listaEstados" value="{{estado.id}}" > {{estado.descricao}} </option>
								    </select>
								</div>
							</div>
							<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Cadastrar Cidade</button>
							</div>
							</div>
						</form>
                    </div>
                </div>
				<div class="panel-body" ng-show="updtCidade">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="alterarCidade()">
							<div class="form-group">
								<div class="col-sm-10">
									<label for="inputEmail3" class="col-sm-2">Descricao</label>
									<input type="text" class="form-control" id="inputEmail3" placeholder="Nome do Cidade" ng-model="Cidade.descricao" required>
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="col-sm-2">Estado</label>
									<select ng-model="Cidade.estadoId"  class="form-control">
									       <option ng-repeat="estado in listaEstados" value="{{estado.id}}" > {{estado.descricao}} </option>
								    </select>
								</div>
							</div>
							
							<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Atualizar Cidade</button>
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
