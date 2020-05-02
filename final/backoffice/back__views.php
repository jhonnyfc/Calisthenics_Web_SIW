<?php
    function mostrar_iniSesion($_iniOk){
        if ($_iniOk == null){
            $viewIni = file_get_contents("back_temp_inisesion.html");
            return $viewIni;
        } else if ($_iniOk == 1){

        }else{
            
        }
    }
?>