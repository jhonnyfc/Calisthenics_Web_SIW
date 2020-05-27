<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    // Load Composer's autoloader
    require 'vendor/autoload.php';

    set_error_handler(function($errno, $errstr, $errfile, $errline, $errcontext) {
        // error was suppressed with the @-operator
        return 'xd';
    });

    # Conexion con la base de datos
    #OUT:
    # conexion con la base de datos
    function mo_conexionbasedatos() {
        try{
            // return mysqli_connect("dbserver", "grupo33","KaNgiga9to","db_grupo33");
            return mysqli_connect("localhost", "root","", "grupo33");
        }catch (Exception $t) {
            return False;
        }
    }

    #####################################################
    ## LogIn & RestPa ###############
    #####################################################

    # Cambio de contraseña de usuario
    #IN:
    # email: String con el correo
    #OUT:
    #   1: contraseña cambiada correctamente
    #  -1: error de conexion con bbdd
    #  -2: correo electornico errono O usuario no encontrado en la base de datos
    #  -3: error ala actualizar la contraseña
    # -54: erro al enviar el correo
    function mo_resetConstrasena(){
        $email =  $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return -2;
        }

        $bbdd = mo_conexionbasedatos();
        if (!$bbdd) {
            return -1;
        } else {
            $queryTx = "select * from final_BK_ADMINISTRADORES AD WHERE AD.CORREO LIKE '$email';";
            $resu = $bbdd->query($queryTx);
            if ($resu-> num_rows == 1){
                $newKey = mo_getRandomKey(10);
                $passHass = password_hash($newKey, PASSWORD_DEFAULT);
                $updateTx = "UPDATE final_BK_ADMINISTRADORES AD SET AD.PASSWORDA = '$passHass' WHERE AD.CORREO LIKE '$email';";
                if ($bbdd->query($updateTx)) {
                    $body = "<h2>Calistenia Web</h2> <br>
                            Se le envia esta nueva contraseña para acceder al BackOffice se recomienda cambiarla: <b>".$newKey."</>";
                    return mo_send_mail($email,$body);
                } else {
                    return -3;
                }
            } else {
                return -2;
            }
        }
    }

    # Verificacion de la contraseña
    #OUT:
    #   1: sesion correcta
    #  -1: error de conexion con bbdd
    #  -2: correo electornico errono O contraseña no validos
    #  -3: correo no encontrado
    #  -4: contraseña erronea
    function mo_verificaConstrasena(){
        $email =  $_POST["log_email"];
        $pass = $_POST["log_pass"];
        $check = $_POST["log_check"];# Toma el valor 'on' si esta activado

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) or !preg_match("/^[a-zA-Z0-9]*$/",$pass)) {
			return -2;
        }

        $bbdd = mo_conexionbasedatos();
        if (!$bbdd) {
            return -1;
        } else {
            $queryTx = "select * from final_BK_ADMINISTRADORES AD WHERE AD.CORREO LIKE '$email';";
            $resu = $bbdd->query($queryTx);
            if ($resu-> num_rows == 1){
                $row = $resu->fetch_array(MYSQLI_ASSOC);
                if (password_verify($pass, $row["PASSWORDA"])) {
                    // if ($check == 'on'){
                        $_SESSION["id"] = $email;
                    // }
                    return 1;
                } else {
                    return -4;
                }
            } else {
                return -3;
            }
        }
    }

    #####################################################
    ## DashBoard ###############
    #####################################################

    # Obtención de los datos necesarios para la creacion del dashBoard
    #OUT:
    # null: no se a podido conctar con el servidor
    # data: array con los datos necesarios
    function mo_data_dashBoard(){
        $bbdd = mo_conexionbasedatos();
        if (!$bbdd) {
            return -1;
        } else {
            $email = $_SESSION["id"];
            $queryTx = "SELECT * FROM final_BK_ADMINISTRADORES AD WHERE AD.CORREO LIKE '$email';";
            $resu = $bbdd->query($queryTx);
            if ($resu-> num_rows == 1){
                $resu = $resu->fetch_array(MYSQLI_ASSOC);
                $conetoUsuarios = "SELECT COUNT(U.NICKNAME) VAL FROM final_USUARIO U";
                $conetoPosts = "SELECT COUNT(T.IDTEMA) VAL FROM final_TEMA T";
                $resu1 = $bbdd->query($conetoUsuarios);
                $resu2 = $bbdd->query($conetoPosts);
                $resu1 = $resu1->fetch_array(MYSQLI_ASSOC);
                $resu2 = $resu2->fetch_array(MYSQLI_ASSOC);
                
                $datos = array (
                    "nombre" => $resu["NOMBRE"]." ".$resu["APPELLIDO1"],
                    "countuser" => $resu1['VAL'],
                    "countem" => $resu2['VAL'],
                    "pie" => mo_pieCreator());
                $_SESSION["name"] = $resu["NOMBRE"]." ".$resu["APPELLIDO1"];
                return $datos;
            } else {
                return -2;
            }
        }
    }

    # Creacion de pie
    #OUT:
    # pieData: array con los datos de pie
    function mo_pieCreator(){
        $bbdd = mo_conexionbasedatos();
        $conetoSexo = "SELECT U.SEXO, COUNT(U.NICKNAME) VAL FROM final_USUARIO U GROUP BY U.SEXO;";
        $resu = $bbdd->query($conetoSexo);

        $pieData = array();
        $aux = "[\"";
        $count = 0;

        while( $row = $resu->fetch_object()){
            switch ($row->SEXO){
                case 'M':
                    $aux = $aux."Mujer";
                    break;
                case 'H':
                    $aux = $aux."Hombre";
                    break;
                case 'PND':
                    $aux = $aux."Prefiero No Decirlo";
                    break;
                default:
                    $aux = $aux.$row->SEXO;
                    break;
            }
            if ($count < $resu -> num_rows - 1){
                $aux = $aux."\", \"";
            }else{
                $aux = $aux."\"]";
            }
            array_push($pieData,$row->VAL);
            $count++;
        }
        
        $count = 0;
        $aux2 = "[";
        foreach ($pieData as $valor){
            $dato = round($valor/array_sum($pieData) * 100, 1);
            if ($count < $resu -> num_rows-1){
                $aux2 = $aux2.$dato.",";
            }else{
                $aux2 = $aux2.$dato."]";
            }
            $count++;
        }

        $pieData = array();
        $pieData["nombres"] = $aux;
        $pieData["numeros"] = $aux2;
        $pieData["dim"] = $resu -> num_rows;
        return $pieData;
    }

    #####################################################
    ## GESTBBDD ###############
    #####################################################

    # Obtencion de la tabla de Usuarios con Datos
    #OUT:
    # data: datos de los usuarios
    function mo_creaTAblaUsers(){
        $con_numRows = "SELECT COUNT(T.NICKNAME) NUM_FIL FROM final_USUARIO T WHERE T.NICKNAME";
        
        $consulta1 = "SELECT T.NICKNAME, T.NOMBRE, T.APELLIDO, T.CORREO, T.SEXO FROM final_USUARIO T WHERE T.NICKNAME";
        $orderBy = "T.NICKNAME";

        $colNames = array('NICKNAME', 'NOMBRE', 'APELLIDO', 'CORREO', 'SEXO','','final_USUARIO');
        $colnamesSQL = array('NICKNAME', 'NOMBRE', 'APELLIDO', 'CORREO', 'SEXO');
        
        return mo_getTablaData($con_numRows,$consulta1,$colNames,$colnamesSQL,$orderBy);
    }

    # Obtencion de la tabla de Foro con Datos
    #OUT:
    # data: datos de los Foro
    function mo_creaTAblaForo(){
        $con_numRows = "SELECT COUNT(T.IDTEMA) NUM_FIL FROM FINAL_TEMA T WHERE T.NOMBRE";
        
        $consulta1 = "SELECT T.IDTEMA, T.NICKNAME, T.FECHA_PUBLICACION, T.NOMBRE FROM FINAL_TEMA T WHERE T.NOMBRE";
        $orderBy = "T.FECHA_PUBLICACION";

        $colNames = array('IDTEMA', 'NICKNAME', 'FECHA_PUBLICACION', 'NOMBRE','','FINAL_TEMA');
        $colnamesSQL = array('IDTEMA', 'NICKNAME', 'FECHA_PUBLICACION', 'NOMBRE');
        
        return mo_getTablaData($con_numRows,$consulta1,$colNames,$colnamesSQL,$orderBy);
    }

    # Obtencion de la tabla de Rutinas con Datos
    #OUT:
    # data: datos de los Rutinas
    function mo_creaTAblaRutinas(){
        $con_numRows = "SELECT COUNT(T.IDRUTINA) NUM_FIL FROM FINAL_RUTINA T WHERE T.NOMBRE_RUTINA";
        
        $consulta1 = "SELECT T.IDRUTINA, T.NOMBRE_RUTINA, T.IDGRUPO, T.IDUSUARIO, T.INTERVALO_TIEMPO, T.NIVEL_RUTINA FROM FINAL_RUTINA T WHERE T.NOMBRE_RUTINA";
        $orderBy = "T.IDRUTINA";

        $colNames = array('ID RUTINA', 'NOMBRE RUTINA', 'ID GRUPO', 'ID USUARIO', 'INTERVALO TIEMPO','NIVEL RUTINA','','FINAL_RUTINA');
        $colnamesSQL = array('IDRUTINA', 'NOMBRE_RUTINA', 'IDGRUPO', 'IDUSUARIO', 'INTERVALO_TIEMPO','NIVEL_RUTINA');
        
        return mo_getTablaData($con_numRows,$consulta1,$colNames,$colnamesSQL,$orderBy);
    }

    # Obtencion de la tabla de Ejecicios con Datos
    #OUT:
    # data: datos de los Ejercicios
    function mo_creaTAblaEjers(){
        $con_numRows = "SELECT COUNT(T.IDEJERCICIO) NUM_FIL FROM FINAL_EJERCICIO T WHERE T.NOMBRE_EJERCICIO";
        
        $consulta1 = "SELECT T.IDEJERCICIO, T.NOMBRE_EJERCICIO, T.MUSCULO, T.NIVEL_EJERCICIO, T.IDFOTO FROM FINAL_EJERCICIO T WHERE T.NOMBRE_EJERCICIO";
        $orderBy = "T.IDEJERCICIO";

        $colNames = array('ID EJER', 'NOMBRE EJERCICIO', 'MUSCULO IMPLI', 'NIVEL EJERCICIO', 'ID FOTO','','FINAL_EJERCICIO');
        $colnamesSQL = array('IDEJERCICIO', 'NOMBRE_EJERCICIO', 'MUSCULO', 'NIVEL_EJERCICIO', 'IDFOTO');
        
        return mo_getTablaData($con_numRows,$consulta1,$colNames,$colnamesSQL,$orderBy);
    }

    # Obtencion de la tabla de Publicaciones
    #OUT:
    # data: datos de los Ejercicios
    function mo_creaTAblaPublica(){
        $con_numRows = "SELECT COUNT(T.IDPUBLICACION) NUM_FIL FROM FINAL_PUBLICACION T WHERE T.TITULO";
        
        $consulta1 = "SELECT T.IDPUBLICACION, T.TITULO, T.FECHA_PUBLICACION, T.AUTOR FROM FINAL_PUBLICACION T WHERE T.TITULO";
        $orderBy = "T.TITULO";

        $colNames = array('ID PUBLICACION', 'TITULO', 'FECHA PUBLICACION', 'AUTOR','','FINAL_EJERCICIO');
        $colnamesSQL = array('IDPUBLICACION', 'TITULO', 'FECHA_PUBLICACION', 'AUTOR');
        
        return mo_getTablaData($con_numRows,$consulta1,$colNames,$colnamesSQL,$orderBy);
    }

    #####################################################
    ## Insert BBDD ###############
    #####################################################

    # Creacin de Publicaciones
    function mo_subirEjer(){
        $conex = mo_conexionbasedatos();
        $res = array();

        $nameEj =  $_POST["namEjer"];
        $secMusc = $_POST["secMusc"];
        $nivel = $_POST["ejerNiv"];
        $descrip = $_POST["descri"];
        $idFoto = $_POST["idFoto"];

        if (strlen($nameEj) == 0 or strlen($nameEj) > 20){
            $res[0] = -1;
            $res[1] = "Erro en la lnogitud Nombre";
            echo json_encode($res);
        } elseif (strlen($descrip) == 0 or strlen($descrip) > 500){
            $res[0] = -1;
            $res[1] = "Erro en el la longitud de la Descripcion max 500 caracteres";
            echo json_encode($res);
        } elseif ($secMusc == ""){
            $res[0] = -1;
            $res[1] = "Sección muscular no seleccionado";
            echo json_encode($res);
        } elseif ($nivel == ""){
            $res[0] = -1;
            $res[1] = "Nivel no seleccionado";
            echo json_encode($res);
        } else {
            $consulta = "INSERT INTO final_EJERCICIO ( NOMBRE_EJERCICIO, MUSCULO, NIVEL_EJERCICIO, DESCRIPCION, IDFOTO) VALUES ('$nameEj',$secMusc,'$nivel','$descrip','$idFoto');";
            if ($conex->query($consulta)){
                $res[0] = 1;
                $res[1] = "Publicacion hecha con Exito";
                echo json_encode($res);
            } else {
                $res[0] = -1;
                $res[1] = "Erro al intentar hacer la publicacion";
                echo json_encode($res);
            }
        }
    }

    # Creacin de Publicaciones
    function mo_creaPublic(){
        $conex = mo_conexionbasedatos();
        $res = array();

        $titulo =  $_POST["titulo"];
        $contenido = $_POST["contenido"];
        $autor = $_POST["autor"];

        if (strlen($titulo) == 0 or strlen($titulo) > 49){
            $res[0] = -1;
            $res[1] = "Erro en la lnogitud titulo";
            echo json_encode($res);
        } elseif (strlen($contenido) == 0 or strlen($contenido) > 499){
            $res[0] = -1;
            $res[1] = "Erro en el la longitud del contenido";
            echo json_encode($res);
        } elseif (strlen($autor) == 0 or strlen($autor) > 49){
            $res[0] = -1;
            $res[1] = "Erro en el la longitud del Autor";
            echo json_encode($res);
        } else {
            $consulta = "INSERT INTO final_PUBLICACION (TITULO,CONTENIDO,AUTOR) VALUES ('$titulo','$contenido','$autor');";
            if ($conex->query($consulta)){
                $res[0] = 1;
                $res[1] = "Publicacion hecha con Exito";
                echo json_encode($res);
            } else {
                $res[0] = -1;
                $res[1] = "Erro al intentar hacer la publicacion";
                echo json_encode($res);
            }
        }
    }

    #####################################################
    ## GESTADMINS ###############
    #####################################################

    # Creacion de la tabla de Adminstradores
    #OUT:
    # data: datos de la tabla Administraodres
    function mo_creaTAblaAdmins(){
        $con_numRows = "SELECT COUNT(T.ID_ADMIN) NUM_FIL FROM final_BK_ADMINISTRADORES T WHERE T.NOMBRE";

        $consulta1 = "SELECT T.ID_ADMIN, T.NOMBRE, T.APPELLIDO1, T.APPELLIDO2, T.CORREO, T.FECH_ALTA FROM final_BK_ADMINISTRADORES T WHERE T.NOMBRE";
        $orderBy = "T.ID_ADMIN";

        $colNames = array('ID', 'NOMBRE', 'APPELLIDO 1º', 'APPELLIDO 2º', 'CORREO', 'FECHA ALTA','','final_BK_ADMINISTRADORES');
        $colnamesSQL = array("ID_ADMIN", 'NOMBRE', 'APPELLIDO1', 'APPELLIDO2', 'CORREO', 'FECH_ALTA');
        
        return mo_getTablaData($con_numRows,$consulta1,$colNames,$colnamesSQL,$orderBy);
    }

    # Alta admins funciotn
    function mo_altaAdminNew(){
        $conex = mo_conexionbasedatos();
        $res = array();

        $nombre =  $_POST["nombre"];
        $ap1 = $_POST["ap1"];
        $ap2 = $_POST["ap2"];
        $correo =  $_POST["correo"];
        $pass = $_POST["pass"];

        if (strlen($nombre) == 0 or strlen($nombre) > 19){
            $res[0] = -1;
            $res[1] = "Erro en la lnogitud Nombre";
            echo json_encode($res);
        } elseif (strlen($ap1) == 0 or strlen($ap1) > 19){
            $res[0] = -1;
            $res[1] = "Erro en el la longitud del Apellido primero";
            echo json_encode($res);
        } elseif (strlen($correo) == 0 or strlen($correo) > 39 or !filter_var($correo, FILTER_VALIDATE_EMAIL)){
            $res[0] = -1;
            $res[1] = "Erro en el la longitud del correo o foramto";
            echo json_encode($res);
        } elseif (strlen($pass) < 8 or strlen($pass) > 25 or !preg_match("/^[a-zA-Z0-9]*$/",$pass)){
            $res[0] = -1;
            $res[1] = "Erro en el la longitud de la contraseña o fomrato, minimo 8";
            echo json_encode($res);
        } else {
            $key = password_hash($pass, PASSWORD_DEFAULT);
            $consulta = "INSERT INTO final_BK_ADMINISTRADORES (NOMBRE,APPELLIDO1,APPELLIDO2,CORREO,PASSWORDA)
                            VALUES ('$nombre','$ap1','$ap2','$correo','$key'); ";
            if ($conex->query($consulta)){
                $res[0] = 1;
                $res[1] = "Usuario dado de Alta Corretamente";
                echo json_encode($res);
            } else {
                $res[0] = -1;
                $res[1] = "Erro al dar de alta -> Correo ya existente o fallo en conexion";
                echo json_encode($res);
            }
        }
    }

#####################################################
## TOOLS ###############
#####################################################

    # Add Files of drop to Foldrs
    #OUT:
    function mo_uploadFile(){
        $dir = dirname( dirname(__FILE__) );
        $dir .= '\\frontend\\fotos_ejercicios\\';

        if(!empty($_FILES)){
            $temp_file = $_FILES['file']['tmp_name'];
            $location = $dir . $_FILES['file']['name'];

            list($ancho, $alto) = getimagesize($temp_file);
            $nuevo_ancho = 500;
            $nuevo_alto = 500;

            // Cargar
            $thumb = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
            header('Content-type: image/jpeg');
            $origen = imagecreatefromjpeg($temp_file);


            // Cambiar el tamaño
            imagecopyresized($thumb, $origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);

            // move_uploaded_file($thumb , $location);
            imagepng($thumb , $location);
        }
    }

    # Get list Fotos
    function mo_listaFotos(){
        $dir = dirname( dirname(__FILE__) );
        $dir .= '\\frontend\\fotos_ejercicios\\';
        $files = scandir($dir);

        $direc = "../frontend/fotos_ejercicios/";
        $output = '<div class="row">';

        if(false !== $files) {
            foreach($files as $file){
                if('.' !=  $file && '..' != $file){
                    $dirAu = $direc.$file;
                    $output .= '<div class="col-md-2">
                                <img src="'.$dirAu.'"  alt="Nada Xd" class="img-thumbnail" width="175" height="175" style="height:175px;" onclick="poIma(this.src)"/>
                                <button type="button" class="btn btn-link remove_image" id="'.$file.'">Remove</button>
                            </div> ';
                }
            }
        }
        $output .= '</div>';
        echo $output;
    }

    function mo_deleteFoto(){
        $dir = dirname( dirname(__FILE__) );
        $dir .= '\\frontend\\fotos_ejercicios\\';
        if(isset($_POST["name"])){
            $filename = $dir . $_POST["name"];
            unlink($filename);
        }
    }

    # Dele File or Row off BBDD
    #OUT:
    #  1: Ok
    # -1: NO Ok
    function mo_deletFile(){
        $conex = mo_conexionbasedatos();
        $res = array();

        $tableName = $_POST["tableNa"];
        $campId = $_POST["campo"];
        $idData =  $_POST["id_Data"];
        $consDelete = "DELETE FROM $tableName WHERE $campId=$idData";

        if ($tableName == 'FINAL_USUARIO'){
            $consDelete = "DELETE FROM $tableName T WHERE T.$campId LIKE '$idData'";
            # Do somethig
            // $dir = dirname( dirname(__FILE__) );

            // $ConsNameFoto = "SELECT T.IDFOTO FROM $tableName T WHERE $campId LIKE '$idData'"; 

            $res[0] = -1;
            $res[1] = "Funcion no Disponible :-(";
            echo json_encode($res);
        }elseif ($tableName == 'FINAL_EJERCICIO'){
            # Do somethig
            $dir = dirname( dirname(__FILE__) );

            $ConsNameFoto = "SELECT T.IDFOTO FROM $tableName T WHERE T.$campId = $idData";
            if ($resul = $conex->query($ConsNameFoto)){
                $row = $resul->fetch_array(MYSQLI_ASSOC);
                $fotName = $row['IDFOTO'];
                $dir .= "\\frontend\\fotos_ejercicios\\$fotName";

                $res[0] = -1;
                $res[1] = "Funcion no Disponible :-( ".$dir.'  ';
                echo json_encode($res);

                // $consDelete = "DELETE FROM $tableName T WHERE T.$campId LIKE '$idData'";
                // if ($conex->query($consDelete)){
                //     $res[0] = 1;
                //     echo json_encode($res);
                // } else {
                //     $res[0] = -1;
                //     $res[1] = "Error al eliminar :-(";
                //     echo json_encode($res);
                // }
            } else {
                $res[0] = -1;
                $res[1] = "Erro de conexion :-(";
                echo json_encode($res);
            }
        } else {
            if ($conex->query($consDelete)){
                $res[0] = 1;
                echo json_encode($res);
            } else {
                $res[0] = -1;
                $res[1] = "Error al eliminar :-(";
                echo json_encode($res);
            }
        }
    }

    # Obtencion de los datos para la cracion de las tablas
    #OUT:
    # data:
    function mo_getTablaData($con_numRows,$consulta1,$colNames,$colnamesSQL,$orderBy){
        $conex = mo_conexionbasedatos();

        if (isset($_GET["palabra"]))
            $keyWord =  $_GET["palabra"];
        else
            $keyWord = '';

        $pagina = $_GET["pagina"];
        $numFilas = $_GET["numerofilas"];
        
        $numFilDatos = 0;
        $con_numRows .= " LIKE '%$keyWord%';";
        if ($resu = $conex->query($con_numRows)){
            $datos = $resu->fetch_assoc();
            $numFilDatos = $datos["NUM_FIL"];
        } else {
            $resu[0] = -1;
            return $resu;
        }

        $consulta = $consulta1." LIKE '%$keyWord%' ORDER BY  $orderBy";
        if ($pagina == 1) {
			$consulta .= " LIMIT $numFilas";
		} else {
			$consulta .= " LIMIT ". (($pagina - 1) *  $numFilas ) . ", " . ($numFilas);
		}

		if ($resultado = $conex->query($consulta)) {
			$res[0] = $numFilDatos;
			$res[1] = $resultado;
			$res[2] = $keyWord;
			$res[3] = $pagina;
            $res[4] = $numFilas;
            $res[5] = $_SESSION["name"];
            $res[6] = $colNames;
            $res[7] = $colnamesSQL;
            if (isset($_GET["way"]))
                $res[8] =  $_GET["way"];
            else
                $res[8] = 1;
  			return $res;
		} else {
			$res[0] = -1;
			return $res;
		}
    }

    # Elimniacion de los datos de sesion
    #OUT:
    # 1: all right
    function mo_cerrarSesion(){
        @session_start();
        session_destroy();
        return 0;
    }

    # Envio de mensaje
    #IN:
    # emailDes: String con correo destino
    # bodyTx: String con el mensaje acepta html
    #OUT:
    #   1: enviado correctamente
    # -54: erro al enviar
    function mo_send_mail($emailDes,$bodyTx){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->IsSMTP();    
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";
            $mail->Host     = "smtp.gmail.com"; // SMTP server
            $mail->Username = "calistenia.web@gmail.com"; // "The account"
            $mail->Password = "123456789diez"; // "The password"
            $mail->Port = 465; // "The port"
            $mail->setFrom('calistenia.web@gmail.com', 'Vadim Bot');
            $mail->addAddress($emailDes);
            $mail->isHTML(true);
            $mail->Subject = 'Calistenia Web _ New Pass';
            $mail->Body    = $bodyTx;
            $mail->send();
            return 1;
        } catch (Exception $e) {
            return -54;
        }
    }

    # Creacion de una nueva contraseña random
    #IN:
    # length: longitud de la contraseña a generar
    #OUT:
    # randomString: nueva contraseña genrada
    function mo_getRandomKey($length) {
        $characters = '01234567890123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
?>