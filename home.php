<?php

session_start();
    if(!isset($_SESSION['logado'])){
        header("Location: index.php");
}
  
?>

<html ng-app="app">
<head>
        <title>SACA - Pagina Inicial</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" >
		<link rel="stylesheet" href="css/angular-toastr.min.css" type="text/css" />
        

		<!-- Template-->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- DataTables CSS -->
		<link href="css/dataTables.bootstrap.css" rel="stylesheet">

		<!-- DataTables Responsive CSS -->
		<link href="css/dataTables.responsive.css" rel="stylesheet">


		<!-- Bootstrap Core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- MetisMenu CSS -->
		<link href="css/metisMenu.min.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="css/sb-admin-2.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- Template-->


		<style>
		 * {
			
		 }
		</style>

    </head>
	<home>
<div ng-controller="paginaInicialController">       
			<div id="wrapper">
				<!-- Navigation -->
				<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand">Promissoria Web - Sistema de Controle de Serviços Fotograficos e Promissorias</a>
					</div>
					<!-- /.navbar-header -->

					<ul class="nav navbar-top-links navbar-right">
						<!-- /.dropdown -->
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
							</a>
							<ul class="dropdown-menu dropdown-user">
								<li><a href="#"><i class="fa fa-user fa-fw"></i> Meu Usuario</a>
								</li>
								<li><a href="#"><i class="fa fa-gear fa-fw"></i> Configurações</a>
								</li>
								<li class="divider"></li>
								<li><a href="#" ng-click="sair()"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
								</li>
							</ul>
							<!-- /.dropdown-user -->
						</li>
						<!-- /.dropdown -->
					</ul>
					<!-- /.navbar-top-links -->

					<div class="navbar-default sidebar" role="navigation">
						<div class="sidebar-nav navbar-collapse">
							<ul class="nav" id="side-menu">
								<li>
									<a href="#" ng-click="navegar('homeContent')"><i class="fa fa-dashboard fa-fw"></i>Home</a>
								</li>
								<li>
									<a href="#" ><i class="fa fa-table fa-fw"></i>Cadastros<span class="fa arrow"></span></a>
									<ul class="nav nav-second-level">
										<li>
											<a href="#" ng-click="navegar('usuarios')">Usuários</a>
										</li>
										<li>
											<a href="#" ng-click="navegar('perfilusuario');">Perfil de usuário</a>
										</li>
										<li>
											<a href="#" ng-click="navegar('escola');">Escolas</a>
										</li>
										<li>
											<a href="#" ng-click="navegar('tipoDocumento');">Tipo de Documentos</a>
										</li>
										<li>
											<a href="#" ng-click="navegar('tipoSituacaoContrato');">Tipo de Situação do Contrato</a>
										</li>
										<li>
											<a href="#" ng-click="navegar('tipoVenda');">Tipo de Vendas</a>
										</li>
										<li>
											<a href="#" ng-click="navegar('supervisor');">Supervisor</a>
										</li>
										<li>
											<a href="#" ng-click="navegar('filial');">Filiais</a>
										</li>
										

									</ul>
									<!-- /.nav-second-level -->
								</li>
								<li>
									<a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
									<ul class="nav nav-second-level">
										<li>
											<a href="#">Second Level Item</a>
										</li>
										<li>
											<a href="#">Second Level Item</a>
										</li>
										<li>
											<a href="#">Third Level <span class="fa arrow"></span></a>
											<ul class="nav nav-third-level">
												<li>
													<a href="#">Third Level Item</a>
												</li>
												<li>
													<a href="#">Third Level Item</a>
												</li>
												<li>
													<a href="#">Third Level Item</a>
												</li>
												<li>
													<a href="#">Third Level Item</a>
												</li>
											</ul>
											<!-- /.nav-third-level -->
										</li>
									</ul>
									<!-- /.nav-second-level -->
								</li>
								<li>
									<a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
									<ul class="nav nav-second-level">
										<li>
											<a href="blank.html">Blank Page</a>
										</li>
										<li>
											<a href="login.html">Login Page</a>
										</li>
									</ul>
									<!-- /.nav-second-level -->
								</li>
							</ul>
						</div>
						<!-- /.sidebar-collapse -->
					</div>
					<!-- /.navbar-static-side -->
				</nav>
				<div id="page-wrapper" >
					  <div class="slide-animate-container">
						<div class="slide-animate" ng-include="pagina"></div>
					  </div>
				</div>
				<!-- /#page-wrapper -->

			</div>
		    <!-- /#wrapper -->
		</div>
		<!-- jQuery -->
		<script src="js/jquery.min.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>

		<!-- Metis Menu Plugin JavaScript -->
		<script src="js/metisMenu.min.js"></script>

		<!-- Custom Theme JavaScript -->
		<script src="js/sb-admin-2.js"></script>


		<script src="js/angular/angular.min.js"></script>
		<script src="js/angular/angular-toastr.tpls.min.js"></script>
        <script src="js/app.module.js"></script>
		<script src="js/loginController.js"></script>
        <script src="js/paginaInicialController.js"></script>
		<script src="js/perfilUsuarioController.js"></script>
		<script src="js/tipoAgenciaController.js"></script>
		<script src="js/tipoDocumentoController.js"></script>
		<script src="js/tipoSituacaoContratoController.js"></script>
		<script src="js/tipoVendaController.js"></script>
		<script src="js/supervisorController.js"></script>
		<script src="js/filialController.js"></script>
		
	</home>
</html>
  
