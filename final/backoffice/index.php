<?php
    session_start();
    include "back__modelo.php";
    include "back__views.php";
    
    if (!isset($accion)) {
		$accion = "ini_sesi";
		$id = 1;
	} else{
        if (isset($_GET["id"])) {
            $id = $_GET["id"];	
        } else if (isset($_POST["id"])) {
            $id = $_POST["id"];
        }

        if (isset($_GET["accion"])) {
            $accion = $_GET["accion"];	
        } else if (isset($_POST["accion"])) {
            $accion = $_POST["accion"];
        }
    }

    if ($accion == "ini_sesi") {
		switch ($id) {
            case '1':# mostrar inicio sesion por primer vez
				echo mostrar_iniSesion(null);
                break;
            case '2':# veridficacion de los datos de sesion
                break;
            case '3': # abrir vista de ventana para recuperar contraseña
                break;
		}
	} 

    # Caso en el que la session ya ubiese estado activa y guradada
    if (isset($_SESSION["logged"])){
        echo mostrar_iniSesion($_SESSION["id"],$_SESSION["key"]);
    } else {
    }
?>