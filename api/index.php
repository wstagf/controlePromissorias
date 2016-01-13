<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
function createDB() {
    //return mysql_connect("mysql01.aguiarobo.hospedagemdesites.ws", "aguiarobo", "aguiarobo");
	//return mysql_connect("127.0.0.1", "root", "");

	$dblink = mysql_connect("127.0.0.1", "root", "");
	if (mysql_errno($dblink) > 0 ) {
        echo mysql_errno($dblink) . ": " . mysql_error($dblink). "\n";
    } else {
	    //mysql_select_db("aguiarobo", $dblink);
		mysql_select_db("controlepromissoria", $dblink);
		if (mysql_errno($dblink) > 0 ) {
            echo mysql_errno($dblink) . ": " . mysql_error($dblink). "\n";
        } else {
		return $dblink;
		}
	}

}
session_start();
header("Content-Type: application/json");
$app->post(
    '/login',
    function () use ($app) {
        $data = json_decode($app->request()->getBody());
        $usuario = (isset($data->usuario)) ? $data->usuario : "";
        $senha   = (isset($data->senha)) ? $data->senha : "";
        $link =createDB();
        
		$result =  mysql_query("select senha from usuario where usuario = '".$usuario."'", $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("logado"=>false, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link)));
        } else {
            $row = mysql_fetch_assoc($result);
            if (!$row) {
                echo json_encode(array("logado"=>false, "resposta"=> 'usuario não encontrado'));  
            }   else {
                if(md5($senha)==$row['senha']){
                    $_SESSION['logado']=true;
                    echo json_encode(array("logado"=>true));
                } else {
                    echo json_encode(array("logado"=>false));   
                }
            }        
        }
		 mysql_close($link);
    }
);

$app->get(
    '/logout',
    function () use ($app) {
        session_destroy();
        header("Location: index.php");
        exit;
    }
);
function auth(){
    if(isset($_SESSION['logado'])){
        return true;
    } else {
        $app = \Slim\Slim::getInstance();
        echo json_encode(array("loginerror"=>true,"msg"=>"Acesso Negado"));
        $app->stop();
    }
}


// Crud USUARIo
$app->post(
    '/registration',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $usuario = (isset($data->usuario)) ? $data->usuario : "";
        $pass   = (isset($data->senha)) ? $data->senha.'': "" ;
        $senha = md5($pass); 
        $link =createDB();
       
		$sql = "INSERT INTO usuario (usuario, senha, idPerfilUsuario, status) VALUES ('".$usuario."', '".$senha."', 1, 1);";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "usuario"=>$usuario,  "pass"=>$pass, "senha"=>$senha));
            } 
        }
		 mysql_close($link);
    }
);
// READ - 01: Lista Completa
$app->get('/listarUsuarios', 'auth', function () use ($app) {
		$link = createDB();
		$sql = "select usuario.id, usuario.usuario as descricaoUsuario, perfilusuario.descricao as 'descricaoPefil', usuario.status  from usuario inner join perfilusuario on usuario.idPerfilUsuario = perfilusuario.id;";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);
// READ - 02: item unico
$app->get('/getUsuario/:idUsuario', 'auth', function ($idUsuario) use ($app) {
        $idUsuario = (int)$idUsuario;
		$link = createDB();
		$sql = "select usuario.id, usuario.usuario, usuario.idPerfilUsuario, usuario.status from usuario where usuario.id = ".$idUsuario.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);
// Update
$app->post('/alterarUsuario/:idUsuario', 'auth', function ($idUsuario) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idUsuario = (int)$idUsuario;
        $usuario = (isset($data->usuario)) ? $data->usuario : "";
        $idPerfilUsuario = (isset($data->idPerfilUsuario)) ? $data->idPerfilUsuario : "1";
        $status = (isset($data->status)) ? $data->status : "0";
        
		$link =createDB();
        
		$sql = "UPDATE usuario   SET  usuario = '".$usuario."', idPerfilUsuario = ".$idPerfilUsuario.", status = ".$status." WHERE  id = ".$idUsuario.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);
// Delete
$app->get('/excluirUsuario/:idUsuario', 'auth', function ($idUsuario) use ($app) {       
		$idUsuario = (int)$idUsuario;
        $link =createDB();
        
        $sql = "DELETE FROM usuario WHERE id = ".$idUsuario.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud  Usuario




// Crud Perfil Usuario
$app->post(
    '/createPerfilUsuario',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";

        $link =createDB();
       
		$sql = "INSERT INTO perfilusuario (descricao) VALUES ('".$descricao."');";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
            } 
        }
		 mysql_close($link);
    }
);
// READ - 01: Lista Completa
$app->get('/listarPerfilUsuarios', 'auth', function () use ($app) {
		$link = createDB();
		$sql = "select perfilusuario.id, perfilusuario.descricao from perfilusuario order by perfilusuario.id";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);
// READ - 02: item unico
$app->get('/getPerfilUsuario/:idPerfilUsuario', 'auth', function ($idPerfilUsuario) use ($app) {
		$idPerfilUsuario = (int)$idPerfilUsuario;
		$link = createDB();
		$sql = "select perfilusuario.id, perfilusuario.descricao from perfilusuario  where perfilusuario.id = ".$idPerfilUsuario.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);
// Update
$app->post('/alterarPerfilUsuario/:idPerfilUsuario', 'auth', function ($idPerfilUsuario) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idPerfilUsuario = (int)$idPerfilUsuario;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
       
		$link =createDB();
        
		$sql = "UPDATE perfilusuario  SET  descricao = '".$descricao."' WHERE  id = ".$idPerfilUsuario.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);
// Delete
$app->get('/excluirPerfilUsuario/:idPerfilUsuario', 'auth', function ($idPerfilUsuario) use ($app) {       
		$idPerfilUsuario = (int)$idPerfilUsuario;
        $link =createDB();
        
        $sql = "DELETE FROM perfilusuario WHERE id = ".$idPerfilUsuario.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud  Perfil Usuario




// Crud Endereco
$app->post(
    '/createEndereco',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $logradouro = (isset($data->logradouro)) ? $data->logradouro : "";
		$numero = (isset($data->numero)) ? $data->numero : "";
		$complemento = (isset($data->complemento)) ? $data->complemento : "";
		$bairro = (isset($data->bairro)) ? $data->bairro : "";
		$cidade_id = (isset($data->cidade_id)) ? $data->cidade_id : "";
		$cep = (isset($data->cep)) ? $data->cep : "";
		$latitude = (isset($data->latitude)) ? $data->latitude : "";
		$longetude = (isset($data->longetude)) ? $data->longetude : "";
		$ponto_referencia = (isset($data->ponto_referencia)) ? $data->ponto_referencia : "";

        $link =createDB();
       
		$sql = "INSERT INTO endereco (logradouro, numero, complemento, bairro, cidade_id, cep, latitude, "
			." longetude, ponto_referencia  ) VALUES ('".$logradouro."', '".$numero."', '".$complemento."', '".$bairro."', "
		   . $cidade_id  .", ". $cep  .", '". $latitude  ."', '". $longetude  ."', '".$ponto_referencia. "');";
		$result =  mysql_query($sql, $link);
		
		if ($result) {
			if (mysql_errno($link) == 0 ) {
				echo json_encode(array("erro"=>false, "descricao"=>mysql_errno($link), "sql" => $sql));
			} else {
				echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
			}
		} else {
			echo json_encode(array("erro"=>true, "descricao"=>mysql_errno($link), "sql" => $sql));
		}
        //    if ($result) {
		//echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        //        echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
        //    } 
        //}

		 mysql_close($link);
    }
);
// READ - 01: Lista Completa
$app->get('/listarEnderecos', 'auth', function () use ($app) {
		$link = createDB();
		$sql = "SELECT  endereco.id,  endereco.logradouro,  endereco.numero,  endereco.complemento,  endereco.bairro,  endereco.cidade_id, cidade.descricao as 'cidadeName',  endereco.cep,  endereco.latitude,  endereco.longetude,  endereco.ponto_referencia FROM endereco  inner join cidade on cidade.id = endereco.cidade_id order by endereco.id";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);
// READ - 02: item unico
$app->get('/getEndereco/:idEndereco', 'auth', function ($idEndereco) use ($app) {
		$idEndereco = (int)$idEndereco;
		$link = createDB();
		$sql = "select endereco.id,  endereco.logradouro,  endereco.numero,  endereco.complemento,  endereco.bairro,  endereco.cidade_id,  endereco.cep,  endereco.latitude,  endereco.longetude,  endereco.ponto_referencia from endereco  where endereco.id = ".$idEndereco.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);

// READ - 01: Lista Completa
$app->get('/listarMaxIdEnderecos', 'auth', function () use ($app) {
		$link = createDB();
		$sql = "select max(id) as maxId from endereco";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);

// Update
$app->post('/alterarEndereco/:idEndereco', 'auth', function ($idEndereco) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idEndereco = (int)$idEndereco;
        $logradouro = (isset($data->logradouro)) ? $data->logradouro : "";
		$numero = (isset($data->numero)) ? $data->numero : "0";
		$complemento = (isset($data->complemento)) ? $data->complemento : "";
		$bairro = (isset($data->bairro)) ? $data->bairro : "";
		$cidade_id = (int)(isset($data->cidade_id)) ? $data->cidade_id : "";
		$cep = (int)(isset($data->cep)) ? $data->cep : "";
		$latitude = (int)(isset($data->latitude)) ? $data->latitude : 0;
		$longetude = (int)(isset($data->longetude)) ? $data->longetude : 0;
		$ponto_referencia = (isset($data->ponto_referencia)) ? $data->ponto_referencia : "";
       
		$link =createDB();
        
		$sql = "UPDATE endereco SET endereco.logradouro= '".$logradouro."',  endereco.numero= '".$numero.
				"',  endereco.complemento= '".$complemento."',  endereco.bairro= '".$bairro."',  endereco.cidade_id= ".$cidade_id.
				",  endereco.cep= ".$cep.",  endereco.latitude= '".$latitude."',  endereco.longetude= '".$longetude.
				"',  endereco.ponto_referencia = '".$ponto_referencia."' WHERE  id = ".$idEndereco.";";

		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);
// Delete
$app->get('/excluirEndereco/:idEndereco', 'auth', function ($idEndereco) use ($app) {       
		$idEndereco = (int)$idEndereco;
        $link =createDB();
        
        $sql = "DELETE FROM endereco WHERE id = ".$idEndereco.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud  endereco





// Crud Pais
$app->post(
    '/createPais',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";

        $link =createDB();
       
		$sql = "INSERT INTO pais (descricao) VALUES ('".$descricao."');";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
            } 
        }
		 mysql_close($link);
    }
);
// READ - 01: Lista Completa
$app->get('/listarPaises', 'auth', function () use ($app) {
		$link = createDB();
		

		$sql = "select pais.id, pais.descricao from pais order by pais.id";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
		{
				$rows[] = $row;
		}
		echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);
// READ - 02: item unico
$app->get('/getPais/:idPais', 'auth', function ($idPais) use ($app) {
		$idPais = (int)$idPais;
		$link = createDB();
		$sql = "select pais.id, pais.descricao from pais  where pais.id = ".$idPais.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);
// Update
$app->post('/alterarPais/:idPais', 'auth', function ($idPais) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idPais = (int)$idPais;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
       
		$link =createDB();
        
		$sql = "UPDATE pais  SET  descricao = '".$descricao."' WHERE  id = ".$idPais.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);
// Delete
$app->get('/excluirPais/:idPais', 'auth', function ($idPais) use ($app) {       
		$idPais = (int)$idPais;
        $link =createDB();
        
        $sql = "DELETE FROM pais WHERE id = ".$idPais.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud   Pais






// Crud Estado
$app->post(
    '/createEstado',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
		$paisId = (isset($data->paisId)) ? $data->paisId : 1;

        $link =createDB();
       
		$sql = "INSERT INTO Estado (descricao, paisId) VALUES ('".$descricao."', ".$paisId.");";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
            } 
        }
		 mysql_close($link);
    }
);
// READ - 01: Lista Completa
$app->get('/listarEstados', 'auth', function () use ($app) {
		 $link =createDB();
		
		$sql = "select estado.id, estado.descricao, estado.paisId, pais.descricao as 'paisName' from estado inner join pais on pais.id = estado.paisId order by estado.id";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);
// READ - 02: item unico
$app->get('/getEstado/:idEstado', 'auth', function ($idEstado) use ($app) {
		$idEstado = (int)$idEstado;
		$link = createDB();
		$sql = "select estado.id, estado.descricao, estado.paisId from estado  where estado.id = ".$idEstado.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);
// Update
$app->post('/alterarEstado/:idEstado', 'auth', function ($idEstado) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idEstado = (int)$idEstado;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
		$paisId = (isset($data->paisId)) ? $data->paisId : 1;
       
		$link =createDB();
        
		$sql = "UPDATE estado  SET descricao = '".$descricao."', paisId =".$paisId."  WHERE  id = ".$idEstado.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);
// Delete
$app->get('/excluirEstado/:idEstado', 'auth', function ($idEstado) use ($app) {       
		$idEstado = (int)$idEstado;
        $link =createDB();
        
        $sql = "DELETE FROM estado WHERE id = ".$idEstado.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud   Estado





// Crud cidade
$app->post(
    '/createCidade',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
		$estadoId = (isset($data->estadoId)) ? $data->estadoId : 1;

        $link =createDB();
       
		$sql = "INSERT INTO cidade (descricao, estadoId) VALUES ('".$descricao."', ".$estadoId.");";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
            } 
        }
		 mysql_close($link);
    }
);
// READ - 01: Lista Completa
$app->get('/listarCidades', 'auth', function () use ($app) {
		 $link =createDB();
		
		$sql = "select cidade.id, cidade.descricao, cidade.estadoId, estado.descricao as 'estadoName' from cidade inner join estado on estado.id = cidade.estadoId order by estado.id";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);
// READ - 02: item unico
$app->get('/getCidade/:idCidade', 'auth', function ($idCidade) use ($app) {
		$idCidade = (int)$idCidade;
		$link = createDB();
		$sql = "select cidade.id, cidade.descricao, cidade.estadoId from cidade  where cidade.id = ".$idCidade.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);
// Update
$app->post('/alterarCidade/:idCidade', 'auth', function ($idCidade) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idCidade = (int)$idCidade;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
		$estadoId = (isset($data->estadoId)) ? $data->estadoId : 1;
       
		$link =createDB();
        
		$sql = "UPDATE cidade  SET descricao = '".$descricao."', estadoId =".$estadoId."  WHERE  id = ".$idCidade.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);
// Delete
$app->get('/excluirCidade/:idCidade', 'auth', function ($idCidade) use ($app) {       
		$idCidade = (int)$idCidade;
        $link =createDB();
        
        $sql = "DELETE FROM cidade WHERE id = ".$idCidade.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud cidade




// Crud escola
$app->post(
    '/createEscola',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
		$dddtelefone = (isset($data->dddtelefone)) ? $data->dddtelefone : 1;
		$numtelefone = (isset($data->numtelefone)) ? $data->numtelefone : 1;
		$enderecoId = (isset($data->enderecoId)) ? $data->enderecoId : 1;
		$observacoes = (isset($data->observacoes)) ? $data->observacoes : "";
        $link =createDB();
		$sql = "INSERT INTO escola (descricao, dddtelefone, numtelefone, enderecoId, observacoes) VALUES ('".$descricao."', ".$dddtelefone.", ".$numtelefone.", ".$enderecoId.", '".$observacoes."');";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
            } 
        }
		 mysql_close($link);
    }
);
// READ - 01: Lista Completa
$app->get('/listarEscolas', 'auth', function () use ($app) {
		 $link =createDB();
		$sql = "select escola.id, escola.descricao, escola.dddtelefone, escola.numtelefone, escola.enderecoId, escola.observacoes, endereco.logradouro as 'enderecoLogradouro',  endereco.numero as 'enderecoNumero', endereco.complemento as 'enderecoComplemento',  endereco.bairro as 'enderecoBairro', endereco.cidade_id as 'enderecoCidadeId', cidade.descricao as 'enderecoCidadeName',  endereco.cep as 'enderecoCep', endereco.latitude as 'enderecoLatitude',  endereco.longetude as 'enderecoLongetude', endereco.ponto_referencia as 'enderecoPontoReferencia' from escola inner join endereco on escola.enderecoId = endereco.id inner join cidade on endereco.cidade_id = cidade.id order by escola.id";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);
// READ - 02: item unico
$app->get('/getEscola/:idEscola', 'auth', function ($idEscola) use ($app) {
		$idEscola = (int)$idEscola;
		$link = createDB();
		$sql = "select escola.id, escola.descricao, escola.dddtelefone, escola.numtelefone, escola.enderecoId, escola.observacoes, endereco.logradouro as 'enderecoLogradouro',  endereco.numero as 'enderecoNumero', endereco.complemento as 'enderecoComplemento',  endereco.bairro as 'enderecoBairro', endereco.cidade_id as 'enderecoCidadeId', cidade.descricao as 'enderecoCidadeName',  endereco.cep as 'enderecoCep', endereco.latitude as 'enderecoLatitude',  endereco.longetude as 'enderecoLongetude', endereco.ponto_referencia as 'enderecoPontoReferencia' from escola inner join endereco on escola.enderecoId = endereco.id inner join cidade on endereco.cidade_id = cidade.id  where escola.id = ".$idEscola.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);
// Update
$app->post('/alterarEscola/:idEscola', 'auth', function ($idEscola) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idEscola = (int)$idEscola;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
		$dddtelefone = (isset($data->dddtelefone)) ? $data->dddtelefone : 0;
		$numtelefone = (isset($data->numtelefone)) ? $data->numtelefone : 0;
		$observacoes = (isset($data->observacoes)) ? $data->observacoes : "";

		$link =createDB();
        
		$sql = "UPDATE escola  SET descricao = '".$descricao."', dddtelefone =".$dddtelefone.", numtelefone =".$numtelefone.", observacoes ='".$observacoes."'  WHERE  id = ".$idEscola.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);
// Delete
$app->get('/excluirEscola/:idEscola', 'auth', function ($idEscola) use ($app) {       
		$idEscola = (int)$idEscola;
        $link =createDB();
        
        $sql = "DELETE FROM escola WHERE id = ".$idEscola.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud escola




// Crud Pessoa
$app->post(
    '/createPessoa',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $cpf_cnpj = (isset($data->cpf_cnpj)) ? $data->cpf_cnpj : "";
		$razao_social= (isset($data->razao_social)) ? $data->razao_social : "";
		$nome_fantasia = (isset($data->nome_fantasia)) ? $data->nome_fantasia : "";
		$endereco_id = (isset($data->endereco_id)) ? $data->endereco_id : 1;
		
        $link =createDB();
		$sql = "INSERT INTO pessoa (cpf_cnpj, razao_social, nome_fantasia, endereco_id) VALUES ('".$cpf_cnpj."', '".$razao_social."', '".$nome_fantasia."', ".$endereco_id.");";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			 echo json_encode(array("erro"=>true, "descricao"=>"vai a merda", "cpf" => $cpf_cnpj, "razao_social" => $razao_social, "nome_fantasia"=>$nome_fantasia, "endereco_id"=>$endereco_id, "sql" => $sql));
        } else {
            if ($result) {
                 echo json_encode(array("erro"=>false, "descricao"=>"vai a merda", "cpf" => $cpf_cnpj, "razao_social" => $razao_social, "nome_fantasia"=>$nome_fantasia, "endereco_id"=>$endereco_id, "sql" => $sql));
            } 
        }
		mysql_close($link);
    }
);
// READ - 01: Lista Completa
$app->get('/listarPessoas', 'auth', function () use ($app) {
		 $link =createDB();
		$sql = "SELECT  pessoa.id,  pessoa.cpf_cnpj,  pessoa.razao_social,  pessoa.nome_fantasia,  pessoa.endereco_id, endereco.logradouro as 'enderecoLogradouro',  endereco.numero as 'enderecoNumero', endereco.complemento as 'enderecoComplemento',  endereco.bairro as 'enderecoBairro', endereco.cidade_id as 'enderecoCidadeId', cidade.descricao as 'enderecoCidadeName',  endereco.cep as 'enderecoCep', endereco.latitude as 'enderecoLatitude',  endereco.longetude as 'enderecoLongetude', endereco.ponto_referencia as 'enderecoPontoReferencia' FROM controlepromissoria.pessoa  inner join endereco on  pessoa.endereco_id = endereco.id inner join cidade on endereco.cidade_id = cidade.id order by pessoa.id ";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);
// READ - 02: item unico
$app->get('/getPessoa/:idPessoa', 'auth', function ($idPessoa) use ($app) {
		$idPessoa = (int)$idPessoa;
		$link = createDB();
		$sql = "SELECT  pessoa.id,  pessoa.cpf_cnpj,  pessoa.razao_social,  pessoa.nome_fantasia,  pessoa.endereco_id, endereco.logradouro as 'enderecoLogradouro',  endereco.numero as 'enderecoNumero', endereco.complemento as 'enderecoComplemento',  endereco.bairro as 'enderecoBairro', endereco.cidade_id as 'enderecoCidadeId', cidade.descricao as 'enderecoCidadeName',  endereco.cep as 'enderecoCep', endereco.latitude as 'enderecoLatitude',  endereco.longetude as 'enderecoLongetude', endereco.ponto_referencia as 'enderecoPontoReferencia' FROM controlepromissoria.pessoa  inner join endereco on  pessoa.endereco_id = endereco.id inner join cidade on endereco.cidade_id = cidade.id  where pessoa.id = ".$idPessoa.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);
// Update
$app->post('/alterarPessoa/:idPessoa', 'auth', function ($idPessoa) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idPessoa = (int)$idPessoa;
        $cpf_cnpj = (isset($data->cpf_cnpj)) ? $data->cpf_cnpj : "";
		$razao_social = (isset($data->razao_social)) ? $data->razao_social : "";
		$nome_fantasia = (isset($data->nome_fantasia)) ? $data->nome_fantasia : "";
		$endereco_id = (isset($data->endereco_id)) ? $data->endereco_id : 0;

		$link =createDB();
        
		$sql = "UPDATE pessoa  SET cpf_cnpj = '".$cpf_cnpj."', razao_social = '".$razao_social."', nome_fantasia ='".$nome_fantasia."', endereco_id =".$endereco_id."  WHERE  id = ".$idPessoa.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);
// Delete
$app->get('/excluirPessoa/:idPessoa', 'auth', function ($idPessoa) use ($app) {       
		$idPessoa = (int)$idPessoa;
        $link =createDB();
        
        $sql = "DELETE FROM pessoa WHERE id = ".$idPessoa.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud escola




// Crud Telefone 

$app->post(
    '/createTelefone',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $numero = (isset($data->numero)) ? $data->numero : 0;
		$ddd = (isset($data->ddd)) ? $data->ddd : 0;
		$ramal = (isset($data->ramal)) ? $data->ramal : "";
		$observacao = (isset($data->observacao)) ? $data->observacao : "";
		$pessoa_id = (isset($data->pessoa_id)) ? $data->pessoa_id : 0;
		
        $link =createDB();
		$sql = "INSERT INTO telefone (numero, ddd, ramal, observacao, pessoa_id) VALUES (".$numero.", ".$ddd.", '".$ramal."', '".$observacao."', ".$pessoa_id.");";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			 echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                 echo json_encode(array("erro"=>false, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
            } 
        }
		mysql_close($link);
    }
);


// READ - 01: Lista Completa
$app->get('/listarTelefones', 'auth', function () use ($app) {
		 $link =createDB();
		$sql = "SELECT  telefone.id,  telefone.ddd,  telefone.numero,   telefone.ramal,  telefone.observacao,  telefone.pessoa_id,    pessoa.razao_social as 'pessoaName' FROM telefone inner join pessoa on pessoa.id = telefone.pessoa_id order by telefone.id ";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);


// READ - 02: item unico
$app->get('/getTelefone/:idTelefone', 'auth', function ($idTelefone) use ($app) {
		$idTelefone = (int)$idTelefone;
		$link = createDB();
		$sql = "SELECT  telefone.id,  telefone.ddd,  telefone.numero,   telefone.ramal,  telefone.observacao,  telefone.pessoa_id,    pessoa.razao_social as 'pessoaName' FROM telefone inner join pessoa on pessoa.id = telefone.pessoa_id where telefone.id = ".$idTelefone." ;";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);


// Update
$app->post('/alterarTelefone/:idTelefone', 'auth', function ($idTelefone) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idTelefone = (int)$idTelefone;
        $numero = (isset($data->numero)) ? $data->numero : 0;
		$ddd = (isset($data->ddd)) ? $data->ddd : 0;
		$ramal = (isset($data->ramal)) ? $data->ramal : "";
		$observacao = (isset($data->observacao)) ? $data->observacao : "";
		$pessoa_id = (isset($data->pessoa_id)) ? $data->pessoa_id : 0;

		$link =createDB();
        
		$sql = "UPDATE telefone  SET numero = ".$numero.", ddd = ".$ddd.", ramal ='".$ramal."', observacao ='".$observacao."', pessoa_id = ".$pessoa_id. "  WHERE  id = ".$idTelefone.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);


// Delete
$app->get('/excluirTelefone/:idTelefone', 'auth', function ($idTelefone) use ($app) {       
		$idTelefone = (int)$idTelefone;
        $link =createDB();
        
        $sql = "DELETE FROM telefone WHERE id = ".$idTelefone.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud telefone





// Crud Crianca 

$app->post(
    '/createCrianca',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $nome = (isset($data->nome)) ? $data->nome :"";
		$escola_id = (isset($data->escola_id)) ? $data->escola_id : 0;
		$serie = (isset($data->serie)) ? $data->serie : "";
		$observacao = (isset($data->observacao)) ? $data->observacao : "";
		
        $link =createDB();
		$sql = "INSERT INTO crianca (nome, escola_id, serie, observacao) VALUES (".$nome.", ".$escola_id.", '".$serie."', '".$observacao."');";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			 echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                 echo json_encode(array("erro"=>false, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
            } 
        }
		mysql_close($link);
    }
);


// READ - 01: Lista Completa
$app->get('/listarCriancas', 'auth', function () use ($app) {
		$link =createDB();
		$sql = "SELECT crianca.id,  crianca.nome,  crianca.escola_id, escola.descricao as 'escolaName',  crianca.serie,  crianca.observacao FROM crianca inner join escola on escola.id = crianca.escola_id";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);


// READ - 02: item unico
$app->get('/getCrianca/:idCrianca', 'auth', function ($idCrianca) use ($app) {
		$idCrianca = (int)$idCrianca;
		$link = createDB();
		$sql = "SELECT crianca.id,  crianca.nome,  crianca.escola_id, escola.descricao as 'escolaName',  crianca.serie,  crianca.observacao FROM crianca inner join escola on escola.id = crianca.escola_id where crianca.id = ".$idCrianca." ;";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);


// Update
$app->post('/alterarCrianca/:idCrianca', 'auth', function ($idCrianca) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idCrianca = (int)$idCrianca;
        $nome = (isset($data->nome)) ? $data->nome :"";
		$escola_id = (isset($data->escola_id)) ? $data->escola_id : 0;
		$serie = (isset($data->serie)) ? $data->serie : "";
		$observacao = (isset($data->observacao)) ? $data->observacao : "";

		$link =createDB();
        
		$sql = "UPDATE crianca  SET nome = '".$nome."', escola_id = ".$escola_id.", serie ='".$serie."', observacao ='".$observacao."'  WHERE  id = ".$idCrianca.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);


// Delete
$app->get('/excluirCrianca/:idCrianca', 'auth', function ($idCrianca) use ($app) {       
		$idCrianca = (int)$idCrianca;
        $link =createDB();
        
        $sql = "DELETE FROM crianca WHERE id = ".$idCrianca.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud telefone





// Crud responsavel 

$app->post(
    '/createResponsavel',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
		$pessoa_id = (isset($data->pessoa_id)) ? $data->pessoa_id :0;
		$crianca_id = (isset($data->crianca_id)) ? $data->crianca_id :0;
		$link =createDB();
		$sql = "INSERT INTO responsavel (crianca_id, pessoa_id) VALUES (".$crianca_id.", ".$pessoa_id.");";
				
		//echo json_encode(array("erro"=>true, "pessoa_id" => $pessoa_id, "pessoa_id"=> $pessoa_id));
       

		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			 echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                 echo json_encode(array("erro"=>false, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
            } 
        }
		mysql_close($link);
    }
);


// READ - 01: Lista Completa
$app->get('/listarResponsaveis', 'auth', function () use ($app) {
		$link =createDB();
		$sql = "select responsavel.id, responsavel.crianca_id, crianca.nome as 'criancaName', responsavel.pessoa_id, pessoa.razao_social as 'responsavelName' from crianca inner join responsavel on responsavel.crianca_id = crianca.id  inner join pessoa on pessoa.id = responsavel.pessoa_id";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);


// READ - 02: item unico
$app->get('/getResponsavel/:idResponsavel', 'auth', function ($idResponsavel) use ($app) {
		$idResponsavel = (int)$idResponsavel;
		$link = createDB();
		$sql = "select responsavel.id, responsavel.crianca_id, crianca.nome as 'criancaName', responsavel.pessoa_id, pessoa.razao_social as 'responsavelName' from crianca inner join responsavel on responsavel.crianca_id = crianca.id  inner join pessoa on pessoa.id = responsavel.pessoa_id where responsavel.id = ".$idResponsavel." ;";

		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);


// Update
$app->post('/alterarResponsavel/:idResponsavel', 'auth', function ($idResponsavel) use ($app) {
        $data = json_decode($app->request()->getBody());
		$idResponsavel = (int)$idResponsavel;
		$pessoa_id = (isset($data->pessoa_id)) ? $data->pessoa_id :0;
		$crianca_id = (isset($data->crianca_id)) ? $data->crianca_id :0;
		$link =createDB();
		
		$sql = "UPDATE responsavel  SET pessoa_id = ".$pessoa_id.", crianca_id = ".$crianca_id." WHERE  id = ".$idResponsavel.";";
		//echo json_encode(array("erro"=>true, "idResponsavel" => $idResponsavel, "pessoa_id"=> $pessoa_id, "crianca_id"=> $crianca_id, "sql" => $sql ));
	
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		mysql_close($link);
        
    }
);


// Delete
$app->get('/excluirResponsavel/:idCrianca', 'auth', function ($idResponsavel) use ($app) {       
		$idCrianca = (int)$idResponsavel;
        $link =createDB();
        
        $sql = "DELETE FROM responsavel WHERE id = ".$idResponsavel.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud responsavel




$app->run();
