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



$app->run();

$teste = teste();

"erro"=>true
