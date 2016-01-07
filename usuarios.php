<div ng-controller="loginController">  
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Usuários</h1>
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
							Usuários cadastrados no sistema
						</div>
						<div class="col-lg-2">
							<a href="#" ng-click="showAddUsuario()" ng-show="lstUsuario"><i class="fa fa-plus-circle fa-fw"></i>Adicionar Usuario</a>
							<a href="#" ng-click="showListUsuario()" ng-show="addUsuario"><i class="fa fa-times-circle fa-fw"></i>Cancelar Adição</a>
							<a href="#" ng-click="showListUsuario()" ng-show="updtUsuario"><i class="fa fa-times-circle fa-fw"></i>Cancelar Atualização</a>
							
						</div>
					</div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" ng-show="lstUsuario"> 
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Perfil</th>
									<th>Status</th>
                                    <th>Açoes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX" ng-repeat="model in listaUsuarios track by model.id">
                                    <td>{{model.id}}</td>
                                    <td>{{model.descricaoUsuario}}</td>
                                    <td>{{model.descricaoPefil}}</td>
									<td> <span ng-if="model.status == 1" > Ativo  </span> <span ng-if="model.status == 0" > Inativo  </span> </td>
                                    <td class="center">
										<a href="#"  ng-click="editarUsuario(model.id)"><i class="fa fa-info-circle fa-fw"></i> Editar</a>
										<a href="#" ng-click="excluirUsuario(model.id)"><i class="fa fa-minus-circle fa-fw"></i> Excluir</a>
									</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="panel-body" ng-show="addUsuario">
                    <div class="dataTable_wrapper">
                        <label>Formulario de Registro de Usuario</label>
						<form class="form-horizontal" ng-submit="inserirUsuario()">
							<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputEmail3" placeholder="Usuário" ng-model="loginAdd.usuario" required>
							</div>
							</div>
							<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" id="inputPassword3" placeholder="Senha" ng-model="loginAdd.senha" required>
							</div>
							</div>
                          
							<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Cadastrar Usuario</button>
							</div>
							</div>
						</form>
                    </div>
                </div>
				<div class="panel-body" ng-show="updtUsuario">
                    <div class="dataTable_wrapper">
                        <label>Formulario de Edição de Usuario</label>
						<form class="form-horizontal" ng-submit="alterarUsuario()">
							<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">ID</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputEmail3" placeholder="ID" ng-model="usuario.id" required>
							</div>
							</div>
							<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputEmail3" placeholder="Usuário" ng-model="usuario.usuario" required>
							</div>
							</div>
							<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Perfil Usuario</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputEmail3" placeholder="Perfil Usuario" ng-model="usuario.idPerfilUsuario" required>
							</div>
							</div>
							<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputEmail3" placeholder="Status" ng-model="usuario.status" required>
							</div>
							</div>
							<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Atualizar Usuario</button>
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
