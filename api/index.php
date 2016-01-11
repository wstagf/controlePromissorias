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
		$sql = "SELECT  endereco.id,  endereco.logradouro,  endereco.numero,  endereco.complemento,  endereco.bairro,  endereco.cidade_id,  endereco.cep,  endereco.latitude,  endereco.longetude,  endereco.ponto_referencia FROM endereco order by endereco.id";
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
// Update
$app->post('/alterarPerfilUsuario/:idPerfilUsuario', 'auth', function ($idEndereco) use ($app) {
        
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






$app->run();
