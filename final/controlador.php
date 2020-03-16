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
		


	if ($accion == "informacion") {
		switch ($id) {
			case '1':
				//Mostrar informacion
				vmostrarinformacion(mdatospublicaciones(),$pagina);
				break;
		}
	}




?>