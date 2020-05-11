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
                $newKey = mo_getRandomKey(8);
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
                    "countem" => $resu1['VAL']);
                return $datos;
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
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
?>