<div ng-controller="situacaopromissoriaController">  
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Situação de Promissorias</h1>
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
							<a href="#" ng-click="showAddSituacaoPromissoria()" ng-show="lstSituacaoPromissoria"><i class="fa fa-plus-circle fa-fw"></i>Adicionar Situação Promissoria</a>
							<a href="#" ng-click="showListSituacaoPromissoria()" ng-show="addSituacaoPromissoria"><i class="fa fa-times-circle fa-fw"></i>Cancelar Adição</a>
							<a href="#" ng-click="showListSituacaoPromissoria()" ng-show="updtSituacaoPromissoria"><i class="fa fa-times-circle fa-fw"></i>Cancelar Atualização</a>
							
						</div>
					</div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" ng-show="lstSituacaoPromissoria"> 
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Descrição</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX" ng-repeat="model in listaSituacaoPromissoriaes track by model.id">
                                    <td>{{model.id}}</td>
                                    <td>{{model.descricao}}</td>
                                    <td class="center">
										<a href="#"  ng-click="editarSituacaoPromissoria(model.id)"><i class="fa fa-info-circle fa-fw"></i> Editar</a>
										<a href="#" ng-click="excluirSituacaoPromissoria(model.id)"><i class="fa fa-minus-circle fa-fw"></i> Excluir</a>
									</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="panel-body" ng-show="addSituacaoPromissoria">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="inserirSituacaoPromissoria()">
							<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Descrição</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputEmail3" placeholder="Descrição da Situação" ng-model="SituacaoPromissoriaAdd.descricao" required>
							</div>
							</div>
                          
							<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Cadastrar Situação de Promissoria</button>
							</div>
							</div>
						</form>
                    </div>
                </div>
				<div class="panel-body" ng-show="updtSituacaoPromissoria">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="alterarSituacaoPromissoria()">
							<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Descrição</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputEmail3" placeholder="Descrição da Situação" ng-model="SituacaoPromissoria.descricao" required>
							</div>
							</div>
							
							<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Atualizar Situação</button>
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
