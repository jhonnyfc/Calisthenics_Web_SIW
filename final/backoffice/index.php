<?php
    session_start();
    include "back__modelo.php";
    include "back__views.php";
    
    if (!isset($_GET["accion"]) and !isset($_POST["accion"])) {
		$accion = "ini_sesi";
		$id = 1;
	} else{
        if (isset($_GET["id"])) {
            $id = $_GET["id"];	
        } elseif (isset($_POST["id"])) {
            $id = $_POST["id"];
        }

        if (isset($_GET["accion"])) {
            $accion = $_GET["accion"];	
        } elseif (isset($_POST["accion"])) {
            $accion = $_POST["accion"];
        }
    }

    if ($accion == "ini_sesi") {
		switch ($id) {
            case '1':# mostrar inicio sesion por primer vez
                viw_mostrar_iniSesion(null);
                break;
            case '2':# verificacion de los datos de sesion
                $code; # puede ser 1, -1 corro no encontrado, -2 contrseña erronea
                viw_mostrar_iniSesion($code);
                break;
		}
	} elseif ($accion == "recuperarKey"){
        switch ($id) {
            case '1':# Comprobar si existe el email introducido y eviar un email con la nueva contraseña
                viw_mostrar_resetKey(null);
                break;
            case '2':# Comprobar si existe el email introducido y eviar un email con la nueva contraseña
                viw_mostrar_resetKey(mo_resetConstraseña());
                break;
		}
    }
    # Caso en el que la session ya ubiese estado activa y guradada
    // if (isset($_SESSION["logged"])){
    //     mostrar_iniSesion($_SESSION["id"],$_SESSION["key"]);
    // } else {
    // }
?>