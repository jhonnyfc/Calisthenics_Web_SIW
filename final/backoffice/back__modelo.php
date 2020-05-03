<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    // Load Composer's autoloader
    require 'vendor/autoload.php';

    # Conexion con la base de datos
    function mo_conexionbasedatos() {
		$conexion = mysqli_connect("http://webalumnos.tlm.unavarra.es:10800/", "grupo33","KaNgiga9to","db_grupo33");
		return $conexion;
	}

    # Cambio de contraseña de usuario
    #  1: contraseña cambiada correctamente
    # -1: error de conexion con bbdd
    # -2: usuario con encontrado en la base de datos
    # -3: error ala actualizar la contraseña
    # -54: erro al enviar el correo
    function mo_resetConstraseña($email){
        $bbdd = conexionbasedatos();
        if (!$bbdd) {
            return -1;
        }else{
            $queryTx = "select * from final_BK_ADMINISTRADORES AD WHERE AD.CORREO LIKE ".$email;
            if ($bbdd->query($queryTx)){
                // $newKey = mo_getRandomKey(8);
                $newKey = "123456abc";
                $updateTx = "UPDATE final_BK_ADMINISTRADORES AD SET AD.PASSWORDA = ".$newKey." WHERE AD.CORREO LIKE ".$email;
                if ($bbdd->query($updateTx)) {
                    $body = "<h2>Calistenia Web</h2> <br>
                            Se le envia esta nueva contraseña para acceder al BackOffice se recomienda cambiarla: <b>".$newKey."</>";
                    return mo_send_mail($email,$body);
                } else {
                    return -3;
                }
            } else{
                return -2;
            }
        }
    }

    # Envio de mensaje
    #  1: enviado correctamente
    # -54: erro al enviar
    function mo_send_mail($maildes,$bodyTx){
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
            $mail->addAddress($maildes);
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
    function mo_getRandomKey($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
?>