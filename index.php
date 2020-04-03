<?php 
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

	if (isset($_GET["pagina"])) {
		$pagina = $_GET["pagina"];	
	} else {
		$pagina=1;
	}

	if (!isset($accion)) {
		$accion = "inicio";
		$id = 1;
	}

	if ($accion == "inicio") {
		switch ($id) {
			case '1':
				//Mostrar inicio
				vmostrarinicio();
				break;
		}
	}

	if ($accion == "informacion") {
		switch ($id) {
			case '1':
				//Mostrar informacion
				vmostrarinformacion(mdatospublicaciones(),$pagina);
				break;
		}
	}

	if ($accion=="contacto") {
		switch ($id) {
			case '1':
				//Mostrar contacto
				vmostrarcontacto();
				break;
			case '2':
				//Enviar email y mostrar mensaje OK
				vmostrarcontactook(mdatoscorreo());
				break;
		}
	}

	if ($accion=="ejercicios") {
		switch ($id) {
			case '1':
				//Mostrar ejercicios
				vmostrarejercicios(mdatosejercicios());
				break;
			case '2':
				//Mostrar ejercicio individual
				vmostrarejercicioinformacion(mdatosejercicioinformacion());
				break;
		}
	}




?>