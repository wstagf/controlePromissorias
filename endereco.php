<div ng-controller="enderecoController">  
	<div class="panel-body">
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Localização</h4>
					</div>
					<div class="modal-body">
						{{Endereco.logradouro}}, nº{{Endereco.numero}}, {{Endereco.complemento}} - {{Endereco.bairro}}. {{Endereco.cidade_id}}
						<br/>
						{{Endereco.ponto_referencia}}
						<div id="mapa" style="height: 300px; width: 300px; background-color: red;">
							
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
	</div>
	<!-- .panel-body -->
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Endereços</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
	<ui-gmap-google-map center="map.center" zoom="map.zoom">
            
								<ui-gmap-marker coords="marker.coords" idkey="marker.id"></ui-gmap-marker>
                
							</ui-gmap-google-map>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
					<div class="row">
						<div class="col-lg-8">
						</div>
						<div class="col-lg-4">
							<a href="#" ng-click="showAddEndereco()" ng-show="lstEndereco"><i class="fa fa-plus-circle fa-fw"></i>Adicionar Endereco</a>
							<a href="#" ng-click="showListEndereco()" ng-show="addEndereco"><i class="fa fa-times-circle fa-fw"></i>Cancelar Adição</a>
							<a href="#" ng-click="showListEndereco()" ng-show="updtEndereco"><i class="fa fa-times-circle fa-fw"></i>Cancelar Atualização</a>
							
						</div>
					</div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" ng-show="lstEndereco"> 
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Endereço</th>
									<th>Bairro</th>
									<th>Cidade</th>
                                    <th>Ponto de Referencia</th>
									<th>Lat / Long</th>
									<th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX" ng-repeat="model in listaEnderecos track by model.id">
                                    <td>{{model.id}}</td>
                                    <td>{{model.logradouro}}, nº{{model.numero}}, {{model.complemento}} </td>
                                    <td>{{model.bairro}}</td>
                                    <td>{{model.cidade_id}}</td>
									<td>{{model.ponto_referencia}}</td>
                                    <td>
										<a href="#"  ng-click="buscarEndereco(model.id, model.latitude, model.longetude)" data-toggle="modal" data-target="#myModal"><i class="fa fa-info-circle fa-fw"></i> Localização</a>
									</td>
                                    <td class="center">
										<a href="#"  ng-click="editarEndereco(model.id)"><i class="fa fa-info-circle fa-fw"></i> Editar</a>
										<a href="#" ng-click="excluirEndereco(model.id)"><i class="fa fa-minus-circle fa-fw"></i> Excluir</a>
									</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="panel-body" ng-show="addEndereco">
                    <div class="dataTable_wrapper">
						<form class="form-horizontal" ng-submit="inserirEndereco()">
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Logradouro*</label>
									<input type="text" class="form-control" id="inputAdd_logradouro" placeholder="Rua / Avenida ... " ng-model="EnderecoAdd.logradouro" required>
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Complemento</label>
									<input type="text" class="form-control" id="inputAdd_complemento" placeholder="Qd. XX, Lt. YYY, Apt 0..." ng-model="EnderecoAdd.complemento" >
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="control-label">Número</label>
									<input type="text" class="form-control" id="inputAdd_numero" placeholder="Usuário" ng-model="EnderecoAdd.numero" >
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Bairro*</label>
									<input type="text" class="form-control" id="inputAdd_bairro" placeholder="Bairro / Setor" ng-model="EnderecoAdd.bairro" required>
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Cidade*</label>
									<input type="text" class="form-control" id="inputAdd_cidade_id" placeholder="Cidade" ng-model="EnderecoAdd.cidade_id" required>
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="control-label">Cep</label>
									<input type="text" class="form-control" id="inputAdd_cep" placeholder="Cep" ng-model="EnderecoAdd.cep">
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-6">
								<label for="inputEmail3" class="control-label">Ponto de Referencia</label>
									<input type="text" class="form-control" id="inputAdd_ponto_referencia" placeholder="Ponto de Referencia" ng-model="EnderecoAdd.ponto_referencia" >
								</div>
														
								<div class="col-sm-3">
									<label for="inputEmail3" class="control-label">Longetude</label>
									<input type="text" class="form-control" id="inputAdd_longetude" placeholder="Longetude" ng-model="EnderecoAdd.longetude" >
								</div>
														
								<div class="col-sm-3">
									<label for="inputEmail3" class="control-label">Latitude</label>
									<input type="text" class="form-control" id="inputAdd_latitude" placeholder="Latitude" ng-model="EnderecoAdd.latitude" >
								</div>
							</div>

							<div class="form-group">
							<div class="col-sm-9">
								
							</div>
							<div class="col-sm-10">
								<button type="submit" class="btn btn-default">Cadastrar Endereco</button>
							</div>
							</div>
						</form>
                    </div>
                </div>
				<div class="panel-body" ng-show="updtEndereco">
                    <div class="dataTable_wrapper">
                        <label>Formulario de Edição de Endereco</label>
						<form class="form-horizontal" ng-submit="alterarEndereco()">
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Logradouro*</label>
									<input type="text" class="form-control" id="input_logradouro" placeholder="Rua / Avenida ... " ng-model="Endereco.logradouro" required>
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Complemento</label>
									<input type="text" class="form-control" id="input_complemento" placeholder="Qd. XX, Lt. YYY, Apt 0..." ng-model="Endereco.complemento" >
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="control-label">Número</label>
									<input type="text" class="form-control" id="input_numero" placeholder="Usuário" ng-model="Endereco.numero" >
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<label for="inputEmail3" class="control-label">Bairro*</label>
									<input type="text" class="form-control" id="input_bairro" placeholder="Bairro / Setor" ng-model="Endereco.bairro" required>
								</div>
								<div class="col-sm-4">
									<label for="inputEmail3" class="control-label">Cidade*</label>
									<input type="text" class="form-control" id="input_cidade_id" placeholder="Cidade" ng-model="Endereco.cidade_id" required>
								</div>
								<div class="col-sm-2">
									<label for="inputEmail3" class="control-label">Cep</label>
									<input type="text" class="form-control" id="input_cep" placeholder="Cep" ng-model="Endereco.cep">
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-6">
								<label for="inputEmail3" class="control-label">Ponto de Referencia</label>
									<input type="text" class="form-control" id="input_ponto_referencia" placeholder="Ponto de Referencia" ng-model="Endereco.ponto_referencia" >
								</div>
														
								<div class="col-sm-3">
									<label for="inputEmail3" class="control-label">Longetude</label>
									<input type="text" class="form-control" id="input_longetude" placeholder="Longetude" ng-model="Endereco.longetude" >
								</div>
														
								<div class="col-sm-3">
									<label for="inputEmail3" class="control-label">Latitude</label>
									<input type="text" class="form-control" id="input_latitude" placeholder="Latitude" ng-model="Endereco.latitude" >
								</div>
							</div>

							<div class="form-group">
							<div class="col-sm-9">
								
							</div>
							<div class="col-sm-10">
								<button type="submit" class="btn btn-default">Atualizar Endereco</button>
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



