<?php
    # Mostrar plantilla inicio sesion
    #IN:
    # iniOk:
    #   null: inicio vacio
    #      1:     
    function viw_mostrar_iniSesion($iniOk,$popCode){
        if ($iniOk == null and $popCode == null){
            $viewIni = file_get_contents("back_temp_inisesion.html");
            echo $viewIni;
        } else {
            
        }
    }

    function viw_mostrar_resetKey(){
        $viewRecu = file_get_contents("back_temp_forgot-password.html");
        echo $viewRecu;
    }

?>