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
		 .modal-dialog {
			z-index: 99999
		 }
		</style>

    </head>
	<home>
		<div class="panel panel-primary" id="mapaPainel">
			<div class="panel-heading">
				Endereço: {{Endereco.logradouro}}, nº{{Endereco.numero}}, {{Endereco.complemento}} - {{Endereco.bairro}}. {{Endereco.cidade_id}}
			</div>
			<div class="panel-body">
				<div id="mapa" style="height: 70%; width:  95%;" >
				</div>
			</div>
			<div class="panel-footer">
				Ponto de Referencia: <p>{{Endereco.ponto_referencia}}</p>
			</div>
		</div>
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
											<a href="#" ng-click="navegar('endereco');">Escolas</a>
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
		<script src="js/enderecoController.js"></script>

		<!-- Arquivo de inicialização do mapa -->
		
		<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDvYiq57FPB-oKd7hdg-J9_eULLMAnfpMc&amp;sensor=false"></script>
		<script src="js/mapaController.js"></script>
		<script>
			var pontoRerefencia = {}
			
			$('#mapaPainel').hide();
			initialize();
		</script>
	
	</home>
</html>
  
