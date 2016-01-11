<div ng-controller="estadoController">  
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Estados</h1>
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
							<a href="#" ng-click="showAddEstado()" ng-show="lstEstado"><i class="fa fa-plus-circle fa-fw"></i>Adicionar Estado</a>
							<a href="#" ng-click="showListEstado()" ng-show="addEstado"><i class="fa fa-times-circle fa-fw"></i>Cancelar Adição</a>
							<a href="#" ng-click="showListEstado()" ng-show="updtEstado"><i class="fa fa-times-circle fa-fw"></i>Cancelar Atualização</a>
							
						</div>
					</div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" ng-show="lstEstado"> 
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Descrição</th>
									<th>Pais</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX" ng-repeat="model in listaEstados track by model.id">
                                    <td>{{model.id}}</td>
                                    <td>{{model.descricao}}</td>
									<td>{{model.paisName}}</td>
                                    <td class="center">
										<a href="#"  ng-click="editarEstado(model.id)"><i class="fa fa-info-circle fa-fw"></i> Editar</a>
										<a href="#" ng-click="excluirEstado(model.id)"><i class="fa fa-minus-circle fa-fw"></i> Excluir</a>
									</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="panel-body" ng-show="addEstado">
                    <div class="dataTable_wrapper">
                        <label>Formulario de Registro de Estados</label>
						<form class="form-horizontal" ng-submit="inserirEstado()">
							<div class="form-group">
								<div class="col-sm-10">
									<label for="inputEmail3" class="col-sm-2">Descricao</label>
									<input type="text" class="form-control" id="inputEmail3" placeholder="Nome do Estado" ng-model="EstadoAdd.descricao" required>
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="col-sm-2">Pais</label>
									<select ng-model="EstadoAdd.paisId"  class="form-control">
									       <option ng-repeat="pais in listaPaises" value="{{pais.id}}" > {{pais.descricao}} </option>
								    </select>
								</div>
							</div>
							<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Cadastrar Estado</button>
							</div>
							</div>
						</form>
                    </div>
                </div>
				<div class="panel-body" ng-show="updtEstado">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="alterarEstado()">
							<div class="form-group">
								<div class="col-sm-10">
									<label for="inputEmail3" class="col-sm-2">Descricao</label>
									<input type="text" class="form-control" id="inputEmail3" placeholder="Nome do Estado" ng-model="Estado.descricao" required>
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="col-sm-2">Pais</label>
									<select ng-model="Estado.paisId"  class="form-control">
									       <option ng-repeat="pais in listaPaises" value="{{pais.id}}" > {{pais.descricao}} </option>
								    </select>
								</div>
							</div>
							
							<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Atualizar Estado</button>
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
