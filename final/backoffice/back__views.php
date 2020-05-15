<?php
    # Mostrar plantilla inicio sesion o Registro
    #IN:
    #  iniCode: integer codigo de comprobacion de inicion de sesion
    function viw_mostrar_iniSesion($iniCode){
        $view = file_get_contents("back_temp_inisesion.html");
        switch ($iniCode){
            case 0:
                $alert = viw_createAlert("Succes","Cierre de sesión correcto","success");
                break;
           case -1:
                $alert = viw_createAlert("Error","Erro con la conexión con la BBDD","error");
                break;
            case -2:
                $alert = viw_createAlert("Error","Correo electornico errono O contraseña no validos. Formato Erroneo","error");
                break;
            case -3:
                $alert = viw_createAlert("Error","Usuario no registrado","error");
                break;
            case -4:
                $alert = viw_createAlert("Error","Contraseña incorrecta","error");
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
                $alert = viw_createAlert("Succes","Contraseña cambiada correctamente revise su bandeja de entrada ","success");
                break;
            case -1:
                $alert = viw_createAlert("Error","Erorr de conxion con la BBDD","error");
                break;
            case -2:
                $alert = viw_createAlert("Error","Usuario no registrado / Correo erroneo","error");
                break;
            case -3:
                $alert = viw_createAlert("Error","Error al actualizar la contraseña","error");
                break;
            case -54:
                $alert = viw_createAlert("Error","Error al enviar el correro, realice de nuevo la operacion","error");
                break;
            default:
                $alert = "";
                break;
        }
        $trozos = explode("##PutAlterHere##",$view);
        echo $trozos[0].$alert.$trozos[1];
    }

    # Crea la vista principal
    #IN:
    # data: los datos necesarios para la creacion de la vista
    function viw_mostrar_dashBoard($data){
        $fragTop = file_get_contents("back_frag_top.html");
        $fragSide = file_get_contents("back_frag_sidebar.html");
        $fragFoot = file_get_contents("back_frag_bottom.html");

        $view = file_get_contents("back_temp_dashboard.html");

        $view = str_replace("##Top##",  $fragTop, $view);
        $view = str_replace("##SideBar##",  $fragSide, $view);
        $view = str_replace("##Footer##",  $fragFoot, $view);
        
        $view = str_replace("##NombreUser##",  $data["nombre"], $view);
        $view = str_replace("##CoutUs##",  $data["countuser"], $view);
        $view = str_replace("##CoutTem##",  $data["countem"], $view);
        
        $alert = viw_createAlert("Succes","Contraseña cambiada correctamente revise su bandeja de entrada ","success");
        $view = str_replace("##PutAlterHere##", $alert, $view);

        $pieData = $data["pie"];
        $view = str_replace("##LISTA_LABES##", $pieData["nombres"], $view);
        $view = str_replace("##DIM_DON##", $pieData["dim"], $view);
        $view = str_replace("##LISTA_DATA##", $pieData["numeros"], $view);

        echo $view;
    }

    # Cramo la Vista ADmin TAbla
    #IN:
    # data: los datos necesarios para la creacion de la vista
    function viw_mostrar_tabla_modadmin($data){
        $fragTop = file_get_contents("back_frag_top.html");
        $fragSide = file_get_contents("back_frag_sidebar.html");
        $fragFoot = file_get_contents("back_frag_bottom.html");

        $view = file_get_contents("back_temp_show_table.html");

        $view = str_replace("##Top##",  $fragTop, $view);
        $view = str_replace("##SideBar##",  $fragSide, $view);
        $view = str_replace("##Footer##",  $fragFoot, $view);
        $view = str_replace("##TituloTabla##", 'Tabla d\'Usuarios', $view);
        $view = str_replace("##ACCIONCO##",  'gestion_admin', $view);
        $view = str_replace("##IDDATA##",  '10', $view);

        $tab_pag = viw_mostrar_Tabla($data);
        // $tab_pag = json_decode($tab_pag, true);
        $view = str_replace("##TABLA_AQUI##",  $tab_pag[1], $view);
        $view = str_replace("##PAJI_AQUI##",  $tab_pag[0], $view);
        
        $view = str_replace("##NombreUser##",  $data[5], $view);
        echo $view;
    }

    # Crearemos la Tabla Data
    #IN:
    # data: los datos necesarios para la creacion de la vista
    function viw_mostrar_Tabla($data){
        if ($data[0] >= 0){
            $numFilDatos= $data[0];
			$resultado = $data[1];
			$nombre = $data[2];
			$pagina = $data[3];
            $numFilas = $data[4];
            $colNames = $data[6];
            $colNamesSQL = $data[7];
            $way = $data[8];
            
            $numPags = intdiv($numFilDatos,$numFilas);
            $resMod = $numFilDatos % $numFilas;

            if ($resMod > 0)
                $numPags++;

            # Creacion de la paginacion
            $paginacion = viw_creaPaginacion($nombre,$numPags,$pagina);

            #Creacion de la tabla
            $tabla = viw_creaTabla($resultado,$colNames,$colNamesSQL);

            $dataOut = array();
            $dataOut[0] = $paginacion;
            $dataOut[1] = $tabla;

            if ($way == 0)
                return $dataOut;
            else
                echo json_encode($dataOut);
        } else {
            echo "Erro al cargar data";
        }
    }

    # Creacion Tabalas Data
    #OUT:
    # tabla: string con la html de la tabal
    function viw_creaTabla($data,$colNamesTabla,$colNamesSQ){
        $tablaAux = file_get_contents("back_frag_tabla.html");
        $tablaAux = explode("##SPLIT_SEC##", $tablaAux);

        $tabla = $tablaAux[0];
        for ($i = 0; $i < sizeof($colNamesTabla); $i++){
            $aux = $tablaAux[1];
            $tabla .= str_replace("##NAME_COL##",  $colNamesTabla[$i], $aux);
        }
        $tabla .= $tablaAux[2];

        while ($fila = $data->fetch_assoc()) {
            $aux = $tablaAux[3];
            $aux = explode('##FILA_VAR##', $aux);

            $auxRow = $aux[0];
            for ($i = 0; $i < sizeof($colNamesSQ); $i++){
                $auxRow .= str_replace('##FILA_DATA##', $fila[$colNamesSQ[$i]], $aux[1]);
            }
            $auxRow .= $aux[2];
            $tabla.= $auxRow;
        }
        $tabla .= $tablaAux[4];

        return $tabla;
    }

    # Creacion de la paginacion
    #OUT:
    # aux: String con la paginacion ideal HTML
    function viw_creaPaginacion($keyWord,$numPags,$pagNow){
        $paginacion = file_get_contents("back_frag_pagi.html");
        $paginacion = explode("##partes##", $paginacion);
        $aux = '';
        if($numPags > 5){
            if ($pagNow - 2 < 0){
                $dif = $numPags - 2;
                $ini = $pagNow - $dif;
                $fin = $pagNow + (4 - $dif);
            }elseif ($numPags - $pagNow < 2){
                $dif = $numPags - $pagNow;
                $ini = $pagNow - (4 - $dif);
                $fin = $numPags + $dif;
            } else {
                $ini = $pagNow - 2;
                $fin = $pagNow + 2;
            }
            for ($i = $ini; $i <= $fin; $i++){
                if ($i == $pagNow){
                    $auxIn = $paginacion[2];
                    $auxIn = str_replace("##palabra##",  $keyWord, $auxIn);
                    $auxIn = str_replace("##numeroNow##", $pagNow, $auxIn);
                    $aux .= $auxIn;
                } else {
                    $auxIn = $paginacion[1];
                    $auxIn = str_replace('##opcion##',  '', $auxIn);
                    $auxIn = str_replace("##palabra##",   $keyWord, $auxIn);
                    $auxIn = str_replace("##numeroOtro##", $i, $auxIn);
                    $aux .= $auxIn;
                }
            }
        } else {
            for ($i = 1; $i <= $numPags; $i++){
                if ($i == $pagNow){
                    $auxIn = $paginacion[2];
                    $auxIn = str_replace("##palabra##",  $keyWord, $auxIn);
                    $auxIn = str_replace("##numeroNow##", $pagNow, $auxIn);
                    $aux .= $auxIn;
                } else {
                    $auxIn = $paginacion[1];
                    $auxIn = str_replace('##opcion##',  '', $auxIn);
                    $auxIn = str_replace("##palabra##",   $keyWord, $auxIn);
                    $auxIn = str_replace("##numeroOtro##", $i, $auxIn);
                    $aux .= $auxIn;
                }
            }
        }
        if ($numPags == 1){
            $auxIn = $paginacion[0];
            $auxIn = str_replace('##opcion##',  'disabled', $auxIn);
            $auxIn = str_replace("##palabra##",   $keyWord, $auxIn);
            $auxIn = str_replace('##numeroPrev##', ($pagNow - 1), $auxIn);
            $auxIn .= $aux;
            $aux = $auxIn;

            $auxIn = $paginacion[3];
            $auxIn = str_replace('##opcion##',  'disabled', $auxIn);
            $auxIn = str_replace("##palabra##",   $keyWord, $auxIn);
            $auxIn = str_replace('##numeroNext##', ($pagNow + 1), $auxIn);
            $aux .= $auxIn;
        }elseif ($pagNow == $numPags){
            $auxIn = $paginacion[0];
            $auxIn = str_replace('##opcion##',  '', $auxIn);
            $auxIn = str_replace("##palabra##",   $keyWord, $auxIn);
            $auxIn = str_replace('##numeroPrev##', ($pagNow - 1), $auxIn);
            $auxIn .= $aux;
            $aux = $auxIn;

            $auxIn = $paginacion[3];
            $auxIn = str_replace('##opcion##',  'disabled', $auxIn);
            $auxIn = str_replace("##palabra##",   $keyWord, $auxIn);
            $auxIn = str_replace('##numeroNext##', ($pagNow + 1), $auxIn);
            $aux .= $auxIn;
        } elseif ($pagNow == 0){
            $auxIn = $paginacion[0];
            $auxIn = str_replace('##opcion##',  'disabled', $auxIn);
            $auxIn = str_replace("##palabra##",   $keyWord, $auxIn);
            $auxIn = str_replace('##numeroPrev##', ($pagNow - 1), $auxIn);
            $auxIn .= $aux;
            $aux = $auxIn;

            $auxIn = $paginacion[3];
            $auxIn = str_replace('##opcion##',  '', $auxIn);
            $auxIn = str_replace("##palabra##",   $keyWord, $auxIn);
            $auxIn = str_replace('##numeroNext##', ($pagNow + 1), $auxIn);
            $aux .= $auxIn;
        } else {
            $auxIn = $paginacion[0];
            $auxIn = str_replace('##opcion##',  '', $auxIn);
            $auxIn = str_replace("##palabra##",   $keyWord, $auxIn);
            $auxIn = str_replace('##numeroPrev##', ($pagNow - 1), $auxIn);
            $auxIn .= $aux;
            $aux = $auxIn;

            $auxIn = $paginacion[3];
            $auxIn = str_replace('##opcion##',  '', $auxIn);
            $auxIn = str_replace("##palabra##",   $keyWord, $auxIn);
            $auxIn = str_replace('##numeroNext##', ($pagNow + 1), $auxIn);
            $aux .= $auxIn;
        }
        return $aux;
    }

    # Crador de Alertas
    #IN:
    #     titulo: String con el texto
    #    mensaje: String con el texto
    # tipoAlerta: String con el tipo {error,success,info,warning}
    #OUT:
    # String: con la alerta
    function viw_createAlert($titulo,$mesaje,$tipoAlerta){
        $alert = "<script> swal(\"$titulo\", \"$mesaje\", \"$tipoAlerta\");</script>";
        return $alert;
    }
?>