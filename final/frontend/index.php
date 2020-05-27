<?php 
	session_start();

	include "modelo.php";
	include "vista.php";


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

	if (!isset($accion)) {
		$accion = "inicio";
		$id = 1;
	}

	if ($accion == "inicio") {
		switch ($id) {
			case '1':
				//Mostrar inicio
				vmostrarinicio(mdatosInicio());
				break;
		}
	} 
	//Poner antes del else los sitios donde se puede acceder sin estar logueado
	/*
		$valor = mcomprobarUsuarioSesion();
		if ($valor ==1) {
			//Meter todos los sitios donde hay que acceder estando logueado
		} else {
			Location();
		}
	}
	*/

	if ($accion == "informacion") {
		if (isset($_GET["pagina"])) {
			$pagina = $_GET["pagina"];	
		} else {
			$pagina=1;
		}
		switch ($id) {
			case '1':
				//Mostrar informacion
				vmostrarInformacion(mdatosPublicaciones(),$pagina);
				break;
		}
	}

	if ($accion=="contacto") {
		switch ($id) {
			case '1':
				//Mostrar contacto
				vmostrarContacto();
				break;
			case '2':
				if (mcomprobarUsuarioSesion()==1) {
					//Enviar email y mostrar mensaje OK
					vmostrarEstadoContacto(mdatosCorreo());
					break;
				} else {
					vmensajeRegistrarse();
				}
				
		}
	}

	if ($accion=="ejercicios") {
		switch ($id) {
			case '1':
				//Mostrar ejercicios
				vmostrarEjercicios(mdatosEjercicios());
				break;
			case '2':
				//Mostrar ejercicio individual
				vmostrarEjercicioInformacion(mdatosEjercicioInformacion());
				break;
			case '3':
				//Actualizar la lista de ejercicios
				vmostrarEjercicios(mdatosEjercicioActualizar());
				break;
		}
	}

	if ($accion=="login") {
		switch ($id) {
			case '1':
				//Mostrar vista para registrarse
				vmostrarRegistrar();
				break;
			case '2':
				//Recibe datos al registrarse
				vmostrarEstadoRegistro(mvalidarRegistro());
				break;
			case '3':
				//Mostrar login
				vmostrarLogin();
				break;
			case '4':
				//Verificar login
				vmostrarEstadoLogin(mvalidarLogin());
				break;
			case '5':
				//Cambiar contraseña
				vcambiarContraseña();
				break;
			case '6':
				//Enviar la contraseña
				vmostrarEstadoEnviarContraseña(menviarContraseña());
				break;
			case '7':
				//Enviar la contraseña
				vmostrarEstadoEnviarContraseña(menviarContraseñaNueva());
				break;
		}
	}

	if ($accion=="cerrarSesion") {
		switch ($id) {
			case '1':
				vmostrarinicio(mCerrarSesion());
				break;
		}
	}

	if ($accion=="perfil") {
		switch ($id) {
			case '1':
				vmostrarPerfil(mDatosUsuarioPerfil());
				break;
			case '2':
				//El usuario añade un ejercicio

				break;
			case '3':
				//El usuario añade un ejercicio
			
				break;
		}
	}

	if ($accion=="rutinas") {
		switch ($id) {
		case '1':
			//Mostrar rutinas
			vmostrarRutinas(mDatosRutinas());
			break;
		case '2':
			//Mostrar informacion rutinas
			vmostrarRutinas(mdatosRutinaActualizar());
			break;
		case '3':
			//Mostrar informacion rutinas
			vmostrarRutinaInfo(mdatosRutinaInfo());
			break;
		}
	}

	if ($accion=="foro") {
		switch ($id) {
		case '1':
			//Mostrar foro
			vmostrarForo(mdatosForo(), mdatosLikes(),mDatosUsuario());
			break;
		case '2':
			//Mostrar menjajes del tema
			vmostrarMensajesTema(mdatosTema(), mdatosMensajeSecundarios(),mDatosUsuario());
			break;
		case '3':
			vmostarEstado(manadirTema());
			break;
		}
	}
	
	if ($accion=="BBDD") {
		if (mcomprobarUsuarioSesion()==1) {
			switch ($id) {
			case '1':
				mInsertarLike();
				break;
			case '2':
				mBorrarLike();
				break;
			case '3':
				vmostrarMensajePrincipal(mInsertarMensajePrincipal());
				break;
			case '4':
				vmostrarMensajeSecundario(mInsertarMensajeSecundario());
				break;
			}
		} else {
			vmensajeRegistrarse();
		}
	}
	
	if ($accion=="pdf") {
		switch ($id) {
			case '1':
				//vmostrarEstadoPDF(mdatosPDF());
				mdatosPDF();
				break;
		}
	}
	if ($accion=="tools") {
		switch ($id) {
			case '1':
				mactualizarFotoPerfil();
				break;
		}
	}


	
?>