<?php 
	
	/**
	Funcion encargada de mostrar la barra de inicio
	Recibe
		cadena --> El archivo donde hay que montar la barra de inicio 
	**/
	function vmontarbarra_inicio($cadena) {
		$menu = file_get_contents("barra_inicio.html");
		$cadena = str_replace("##barra_inicio##", $menu, $cadena);
		return $cadena;
	}

	/**
	Funcion encargada de mostrar la barra de inicio
	Recibe
		cadena --> El archivo donde hay que montar la barra del final  
	**/
	function vmontarbarra_final($cadena) {
		$menu = file_get_contents("barra_final.html");
		$cadena = str_replace("##barra_final##", $menu, $cadena);
		return $cadena;
	}

	/**
	Funcion encargada de mostrar el inicio
	**/
	function vmostrarinicio() {
		$fichero = file_get_contents("inicio_valpha.html");
		$fichero = vmontarbarra_inicio($fichero);
		$fichero = vmontarbarra_final($fichero);
		echo $fichero;

	}

	/**
	Funcion encargada de mostrar la informacion.html
	Recibe
		pagina --> El numero de paginas que hay para las publicaciones
		resultado --> La informacion de las publicaciones
		-1 --> Si existe algun error con la bases de datos
	**/
	function vmostrarinformacion($resultado, $pagina){
		if (is_object($resultado)) {
			
			$valores = array("IDPUBLICACION", "FECHA_PUBLICACION", "CONTENIDO", "AUTOR");
			$cont=0;


			while($fila = $resultado->fetch_assoc()) {
				$valores[$cont] = array("IDPUBLICACION"=>$fila["IDPUBLICACION"],
										"TITULO"=>$fila["TITULO"], 
										 "FECHA_PUBLICACION"=>$fila["FECHA_PUBLICACION"], 
										 "CONTENIDO"=>$fila["CONTENIDO"], 
										 "AUTOR"=>$fila["AUTOR"]);
				$cont++;
			}

			$fichero = file_get_contents("informacion.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);
			$trozos=explode("##tarjetaInfo##", $fichero);
			$carta="";

			$longitud_valores = count($valores);//numero filas de tabla
			$numero_pagina = $longitud_valores/2;//numeros de paginacion
			
			
			$indice = $pagina * 2;

			if ($pagina<$numero_pagina && $pagina==1) {
				$boton_anterior=$pagina;
				$boton_siguiente=$pagina+1;
			}
			elseif ($pagina>=$numero_pagina ) {
				$boton_anterior=$pagina-1;
				$boton_siguiente=$pagina;
			}
			else{
				$boton_anterior=$pagina-1;
				$boton_siguiente=$pagina+1;
			}

			if ( ($longitud_valores % 2 == 0) || (($numero_pagina)>=$pagina) ) {//muestro dos tarjetas
				$aux=$trozos[1];
				$fila = $valores[$indice-2];
				$titulo=$fila['TITULO'];
				$descripcion = $fila['CONTENIDO'];
				$autor = $fila['AUTOR'];
				$fecha = $fila['FECHA_PUBLICACION'];

				$aux=str_replace("##resena_titulo1##", $titulo, $aux);
				$aux=str_replace("##resena_texto1##", $descripcion, $aux);
				$aux=str_replace("##resena_autor1##", $autor, $aux);
				$aux=str_replace("##resena_fecha1##", $fecha, $aux);
				
				$fila = $valores[$indice-1];
				$titulo2=$fila['TITULO'];
				$descripcion2 = $fila['CONTENIDO'];
				$autor2 = $fila['AUTOR'];
				$fecha2 = $fila['FECHA_PUBLICACION'];

				$aux=str_replace("##resena_titulo2##", $titulo2, $aux);
				$aux=str_replace("##resena_texto2##", $descripcion2, $aux);
				$aux=str_replace("##resena_autor2##", $autor2, $aux);
				$aux=str_replace("##resena_fecha2##", $fecha2, $aux);
				$carta.=$aux;
				
			}
			else{//hay numero impar de publicaciones y es el ultimo(muestro solo una tarjeta)
				$aux=$trozos[1];
				$fila = $valores[$indice-3];
				$titulo=$fila['TITULO'];
				$descripcion = $fila['CONTENIDO'];
				$autor = $fila['AUTOR'];
				$fecha = $fila['FECHA_PUBLICACION'];

				$aux=str_replace("##resena_titulo1##", $titulo, $aux);
				$aux=str_replace("##resena_texto1##", $descripcion, $aux);
				$aux=str_replace("##resena_autor1##", $autor, $aux);
				$aux=str_replace("##resena_fecha1##", $fecha, $aux);
				
				$fila = $valores[$indice-2];
				$titulo2=$fila['TITULO'];
				$descripcion2 = $fila['CONTENIDO'];
				$autor2 = $fila['AUTOR'];
				$fecha2 = $fila['FECHA_PUBLICACION'];

				$aux=str_replace("##resena_titulo2##", $titulo2, $aux);
				$aux=str_replace("##resena_texto2##", $descripcion2, $aux);
				$aux=str_replace("##resena_autor2##", $autor2, $aux);
				$aux=str_replace("##resena_fecha2##", $fecha2, $aux);
				$carta.=$aux;
				
			}

			$paginacion="";
			$aux=$trozos[2];
			$aux=str_replace("##pagina_anterior##", $boton_anterior, $aux);
			$paginacion.=$aux;
			for ($i=0; $i < $numero_pagina; $i++) { 
				$aux=$trozos[3];
				$aux=str_replace("##numero_pagina##", $i+1, $aux);
				$paginacion.=$aux;
			}
			$aux=$trozos[4];
			$aux=str_replace("##pagina_siguiente##", $boton_siguiente, $aux);
			$paginacion.=$aux;


			echo $trozos[0].$carta.$paginacion.$trozos[5];

		} else {
			if ($resultado == -1) {
				$fichero = file_get_contents("mensaje.html");
				$fichero = vmontarbarra_inicio($fichero);
				$fichero = vmontarbarra_final($fichero);
				$fichero = str_replace("##titulo_mensaje##", "Listado de personas.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","Ha ocurrido un error con la base de datos.<br> Pruebe de nuevo en unos minuos." , $fichero);
				echo $fchero;
			}		
		}

	}

	/**
	Funcion encargada de mostrar el contacto.html
	**/
	function vmostrarcontacto(){
		$fichero = file_get_contents("contacto.html");
		$fichero = vmontarbarra_inicio($fichero);
		$fichero = vmontarbarra_final($fichero);
		echo $fichero;
	}

	/**
	Funcion encargada de mostrar la el estado del envio del correo electronico
	Recibe
		 1 --> Se ha mandado correctamente
		-1 --> Ha ocurrido algun error 
		-2 --> El nombre esta mal definido
		-3 --> El email esta mal definido
		-4 --> El telefono esta mal definido
		-5 --> El mensaje esta mal definido
	**/
	function vmostrarcontactook($resultado){
		$fichero = file_get_contents("mensaje.html");
		$fichero = vmontarbarra_inicio($fichero);
		$fichero = vmontarbarra_final($fichero);

		switch ($resultado) {
			case '1':
				$fichero = str_replace("##titulo_mensaje##", "Mensaje enviado correctamente.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","El mensaje ha sido enviado correctamente. Gracias por confiar en calisteniaweb.com" , $fichero);
				break;
			case '-1':
				$fichero = str_replace("##titulo_mensaje##", "Error en el envio del mensaje.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","Ha ocurrido un error a la hora de enviar en el mensaje. Compruebe su conexióna internet y vuelva a intentarlo más tarde. Gracias por confiar en calisteniaweb.com" , $fichero);
				break;
			case '-2':
				$fichero = str_replace("##titulo_mensaje##", "Error en el nombre.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","El nombre debe estar compuesto unicamente por letras y espacios en blanco.<br> Por favor corrija este error para porder mandarnos su correo." , $fichero);
				break;
			case '-3':
				$fichero = str_replace("##titulo_mensaje##", "Error en el email.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","El email esta mal escrito.<br> Por favor corrija este error para porder mandarnos su correo." , $fichero);
				break;
			case '-4':
				$fichero = str_replace("##titulo_mensaje##", "Error en el telefono.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","El telefono debe estar compuesto unicamente por numeros sin espacios en blanco.<br> Por favor corrija este error para porder mandarnos su correo." , $fichero);
				break;
			case '-5':
				$fichero = str_replace("##titulo_mensaje##", "Error en el mensaje.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","El mensaje debe estar formado unicamente por letras y espacios en blanco. Sin caracteres especiales. <br> Por favor corrija este error para porder mandarnos su correo." , $fichero);
				break;
		}

		echo $fichero;
	}

	/**
	Funcion encargada de mostrar el listado de ejercicios
	Recibe
		resultado --> Si se ha realizado la consulta correctamente
		-1 --> Si existe algun problema con la base de datos
	**/
	function vmostrarejercicios($resultado){
		if (is_object($resultado)) {
			$fichero = file_get_contents("lista_ejercicios.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);
			$trozos=explode("##carta_ejercicio##", $fichero);

			$lista_ejercicios = "";
			$aux = "";
			
			while($fila = mysqli_fetch_assoc($resultado)) {	
				$aux = $trozos[1];
				$aux=str_replace("##nombreejercicio##", $fila["NOMBRE"], $aux);
				$aux=str_replace("##nombre_nivel##", $fila["NIVEL"], $aux);
				$aux=str_replace("##nombre_musculo##", $fila["NOMBRE_MUSCULO"], $aux);
				$aux=str_replace("##idfoto##", $fila["IDFOTO"], $aux);
				$aux=str_replace("##idejercicio##", $fila["IDEJERCICIO"], $aux);
				
				if ($fila["NIVEL"] == "Principiante") {
					$aux=str_replace("##nombre_color##", "primary", $aux);
				} else if ($fila["NIVEL"] == "Intermedio") {
					$aux=str_replace("##nombre_color##", "warning", $aux);
				} else {
					$aux=str_replace("##nombre_color##", "danger", $aux);
				}
				
				$lista_ejercicios.= $aux;
			}
			

			echo $trozos[0] . $lista_ejercicios . $trozos[2];
		} else {
			$fichero = file_get_contents("mensaje.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);
			$fichero = str_replace("##titulo_mensaje##", "Listado de ejericicios.", $fichero);
			$fichero = str_replace("##contenido_mensaje##","Ha ocurrido un error con la base de datos a la hora de mostrar el listado de ejercicios.<br> Pruebe de nuevo en unos minutos." , $fichero);
			echo $fchero;
		}
	}

	/**
	Funcion encargada de mostrar la informacion de un ejercicio
	Recibe
		resultado --> Si se ha realizado la consulta correctamente
		-1 --> Si existe algun problema con la base de datos
	**/
	function vmostrarejercicioinformacion($resultado) {
		if (is_object($resultado)) {
			$fichero = file_get_contents("info_ejercicio.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);

			$fila = mysqli_fetch_assoc($resultado);
			$fichero=str_replace("##ejercicio_nombre##", $fila["NOMBRE"], $fichero);
			$fichero=str_replace("##ejercicio_descripcion##", $fila["DESCRIPCION"], $fichero);
			$fichero=str_replace("##ejercicio_idfoto##", $fila["IDFOTO"], $fichero);
			/*
			if ($fila["NIVEL"] == "Principiante") {
				$aux=str_replace("##nombre_color##", "primary", $aux);
			} else if ($fila["NIVEL"] == "Intermedio") {
				$aux=str_replace("##nombre_color##", "warning", $aux);
			} else {
				$aux=str_replace("##nombre_color##", "danger", $aux);
			}
			*/
			echo $fichero;
		} else {
			$fichero = file_get_contents("mensaje.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);
			$fichero = str_replace("##titulo_mensaje##", "informacion del ejercicio.", $fichero);
			$fichero = str_replace("##contenido_mensaje##","Ha ocurrido un error con la base de datos a la hora de mostrar la infromacion del ejrecicios.<br> Pruebe de nuevo en unos minutos." , $fichero);
			echo $fichero;	
		}
	}
?>