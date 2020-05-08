<?php
    # Mostrar plantilla inicio sesion o Registro
    #IN:
    #  iniCode: integer codigo de comprobacion de inicion de sesion
    function viw_mostrar_iniSesion($iniCode){
        $view = file_get_contents("back_temp_inisesion.html");
        switch ($iniCode){
            case 1:############## Mostrar dashboard
                $alert = vi_createAlert("Succes","Session correcta ","success");
                $view = file_get_contents("back_temp_dashboard.html");
                break;
            case -1:
                $alert = vi_createAlert("Error","Erro con la conexion con la BBDD","error");
                break;
            case -2:
                $alert = vi_createAlert("Error","Correo electornico errono O contraseña no validos. Formato Erroneo","error");
                break;
            case -3:
                $alert = vi_createAlert("Error","Usuario no registrado","error");
                break;
            case -4:
                $alert = vi_createAlert("Error","Contraseña incorrecta","error");
                break;
            default:
                $alert = "";
                break;
        }
        $trozos = explode("##PutAlterHere##",$view);
        echo $trozos[0].$alert.$trozos[1];
    }

    # Crea la vista para recuperar la contraseña
    #IN:
    # resetPass: Integer con el codigo de la vista
    function viw_mostrar_resetKey($restCode){
        $view = file_get_contents("back_temp_forgot-password.html");
        switch ($restCode) {
            case 1:
                $view = file_get_contents("back_temp_inisesion.html");
                $alert = vi_createAlert("Succes","Contraseña cambiada correctamente revise su bandeja de entrada ","success");
                break;
            case -1:
                $alert = vi_createAlert("Error","Erorr de conxion con la BBDD","error");
                break;
            case -2:
                $alert = vi_createAlert("Error","Usuario no registrado / Correo erroneo","error");
                break;
            case -3:
                $alert = vi_createAlert("Error","Error al actualizar la contraseña","error");
                break;
            case -54:
                $alert = vi_createAlert("Error","Error al enviar el correro, realice de nuevo la operacion","error");
                break;
            default:
                $alert = "";
                break;
        }
        $trozos = explode("##PutAlterHere##",$view);
        echo $trozos[0].$alert.$trozos[1];
    }

    # Crador de Alertas
    #IN:
    #     titulo: String con el texto
    #    mensaje: String con el texto
    # tipoAlerta: String con el tipo {error,success,info,warning}
    #OUT:
    # String: con la alerta
    function vi_createAlert($titulo,$mesaje,$tipoAlerta){
        $alert = "<script> swal(\"$titulo\", \"$mesaje\", \"$tipoAlerta\");</script>";
        return $alert;
    }
?>