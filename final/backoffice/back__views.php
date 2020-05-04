<?php
    # Mostrar plantilla inicio sesion
    #IN:
    #    iniOk: integer codigo de comprobacion de inicion de sesion
    # restPass: indeger codigo de comporbacion de cambion de contraseñ
    function viw_mostrar_iniSesion($iniOk,$restPass){
        $viewIni = file_get_contents("back_temp_inisesion.html");
        if ($iniOk == null and $restPass == null){
            //echo $viewIni;
        } else {
            if ($iniOk != null){
                switch ($iniOk){
                    case 1:
                        break;
                    case -1:
                        break;
                    case -2:
                        break;
                }
            }elseif ($restPass != null){
                echo $restPass;
                switch ($restPass){
                    case 1:
                        break;
                    case -1:
                        break;
                    case -2:
                        break;
                    case -3:
                        break;
                    case -54:
                        break;
                }
            }
        }
        echo $viewIni;
    }

    function viw_mostrar_resetKey(){
        $viewRecu = file_get_contents("back_temp_forgot-password.html");
        echo $viewRecu;
    }
?>