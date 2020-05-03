<?php
    function viw_mostrar_iniSesion($iniOk){
        if ($iniOk == null){
            $viewIni = file_get_contents("back_temp_inisesion.html");
            echo $viewIni;
        } else if ($iniOk == 1){

        }else{

        }
    }

    function viw_mostrar_recuperarKey(){
        $viewRecu = file_get_contents("back_temp_forgot-password.html");
        echo $viewRecu;
    }

?>