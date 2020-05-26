<?php
    # REVISAR GUARDAR SESION PROLAMGADA

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

    switch ($accion) {
        case "ini_sesi":
            switch ($id) {
                case '1':# mostrar inicio sesion por primer vez
                    viw_mostrar_iniSesion(null);
                    break;
                case '2':# verificacion de los datos de sesion
                    $code = mo_verificaConstrasena();
                    if ($code == 1){
                        viw_mostrar_dashBoard(mo_data_dashBoard());
                    } else {
                        viw_mostrar_iniSesion($code);
                    }
                    break;
            }
            break;
        case "recuperarKey":
            switch ($id) {
                case '1':# Comprobar si existe el email introducido y eviar un email con la nueva contraseña
                    viw_mostrar_resetKey(null);
                    break;
                case '2':# Comprobar si existe el email introducido y eviar un email con la nueva contraseña
                    viw_mostrar_resetKey(mo_resetConstrasena());
                    break;
            }
            break;
        case 'dashBoard':
            switch ($id) {
                case '0':
                    viw_mostrar_dashBoard(mo_data_dashBoard());
                    break;
                case '1':
                    # Cerrar sesion Accion
                    viw_mostrar_iniSesion(mo_cerrarSesion());
                    break;
                case '2':
                    # Mostrar Perfil
                    break;
            }
            break;
        case "gestionbbdd":
            switch ($id) {
                case '1':
                    viw_build_lisMod_User(mo_creaTAblaUsers());
                    break;
                case '2':
                    viw_build_lisMod_Foro(mo_creaTAblaForo());
                    break;
                case '3':
                    viw_build_lisMod_Rutinas(mo_creaTAblaRutinas());
                    break;
                case '4':
                    viw_build_lisMod_Ejer(mo_creaTAblaEjers());
                    break;
                case '5':
                    viw_build_lisMod_Public(mo_creaTAblaPublica());
                    break;
                case '10':
                    viw_mostrar_Tabla(mo_creaTAblaUsers());
                    break;
                case '20':
                    viw_mostrar_Tabla(mo_creaTAblaForo());
                    break;
                case '30':
                    viw_mostrar_Tabla(mo_creaTAblaRutinas());
                    break;
                case '40':
                    viw_mostrar_Tabla(mo_creaTAblaEjers());
                    break;
                case '50':
                    viw_mostrar_Tabla(mo_creaTAblaPublica());
                    break;
            }
            break;
        case 'insertbbdd':
                switch ($id) {
                    case '1':
                        viw_mostrar_CreaEjer();
                        break;
                    case '2':
                        break;
                    case '3':
                        break;
                    case '4':
                        viw_mostrar_CreaPubli();
                        break;
                    case '5':
                        viw_mostrar_DropZone();
                        break;
                    case '10':
                        mo_subirEjer();
                        break;
                    case '20':
                        break;
                    case '30':
                        break;
                    case '40':
                        mo_creaPublic();
                        break;
                }
                break;
        
        case 'gestion_admin':
            switch ($id) {
                case '1':
                    viw_build_lisMod_modadmin(mo_creaTAblaAdmins());
                    break;
                case '2':
                    viw_mostrar_creaAdmin();
                    break;
                case '10':
                    viw_mostrar_Tabla(mo_creaTAblaAdmins());
                    break;
                case '20':
                    mo_altaAdminNew();
                    break;
            }
            break;
        case 'tools':
            switch ($id) {
                case '0':
                    mo_delteFile();
                    break;
            }
    }
?>