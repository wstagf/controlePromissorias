<div ng-controller="criancaController">  

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crianças</h1>
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
							<a href="#" ng-click="showAddCrianca()" ng-show="lstCrianca"><i class="fa fa-plus-circle fa-fw"></i>Adicionar Criança</a>
							<a href="#" ng-click="showListCrianca()" ng-show="addCrianca"><i class="fa fa-times-circle fa-fw"></i>Cancelar Adição</a>
							<a href="#" ng-click="showListCrianca()" ng-show="updtCrianca"><i class="fa fa-times-circle fa-fw"></i>Cancelar Atualização</a>
						</div>
					</div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" ng-show="lstCrianca"> 
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
									<th>Nome</th>
									<th>Escola</th>
									<th>Série</th>
									<th>Observações</th>
									<th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX" ng-repeat="model in listaCriancas track by model.id">
                                    <td>{{model.id}}</td>
									<td>{{model.nome}}</td>
                                    <td>{{model.escolaName}}</td>
                                    <td>{{model.serie}}</td>
									<td>{{model.observacao}}</td>
                                    <td class="center">
										<a href="#"  ng-click="editarCrianca(model.id)"><i class="fa fa-info-circle fa-fw"></i> Editar</a>
										<a href="#" ng-click="excluirCrianca(model.id)"><i class="fa fa-minus-circle fa-fw"></i> Excluir</a>
									</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="panel-body" ng-show="addCrianca">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="inserirCrianca()">
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Nome</label>
									<input type="text" class="form-control" id="input_nome_crianca" placeholder="Nome" ng-model="CriancaAdd.nome" >
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Escola</label>
									<select ng-model="CriancaAdd.escola_id"  class="form-control">
									<option ng-repeat="escola in listaEscola" value="{{escola.id}}" > {{escola.descricao}} </option>
									</select>
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="control-label">Série / Turma</label>
									<input type="text" class="form-control" id="input_numeroCrianca" placeholder="Série / Turma" ng-model="CriancaAdd.serie" >
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<label for="inputEmail3" class="control-label">Observações</label>
									<input type="text" class="form-control" id="input_observa" placeholder="Observações" ng-model="CriancaAdd.observacao" >
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-2">
								
								</div>
								<div class="col-sm-10">
									<button type="submit" class="btn btn-default">Cadastrar Crianca</button>
								</div>
							</div>
						</form>
                    </div>
                </div>
				<div class="panel-body" ng-show="updtCrianca">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="alterarCrianca()">
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Nome</label>
									<input type="text" class="form-control" id="input_nome_crianca" placeholder="Nome" ng-model="Crianca.nome" >
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Escola</label>
									<select ng-model="Crianca.escola_id"  class="form-control">
									<option ng-repeat="escola in listaEscola" value="{{escola.id}}" > {{escola.descricao}} </option>
									</select>
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="control-label">Série / Turma</label>
									<input type="text" class="form-control" id="input_numeroCrianca" placeholder="Série / Turma" ng-model="Crianca.serie" >
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<label for="inputEmail3" class="control-label">Observações</label>
									<input type="text" class="form-control" id="input_observa" placeholder="Observações" ng-model="Crianca.observacao" >
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-2">
								
								</div>
								<div class="col-sm-10">
									<button type="submit" class="btn btn-default">Atualizar Crianca</button>
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


		
