<?php 
	
	/**
	Funcion encargada de mostrar la barra de inicio
	Recibe
		cadena --> El archivo donde hay que montar la barra de inicio 
	**/
	function vmontarbarra_inicio($cadena) {
		$menu = file_get_contents("barra_inicio.html");

		$trozos = explode("##barra_inicio##", $menu);

		$cadena = str_replace("##barra_inicio##", $trozos[1], $cadena);
		
		if (isset($_SESSION["nickname"]) ) {
			$nickname = $_SESSION["nickname"];
			$cadena = str_replace("##registrar##", "
				<li class='nav-item'>
					<a class='nav-link' href='index.php?accion=perfil&id=1'>$nickname</a>
				</li>"
				, $cadena);
			
				/*
			$cadena = str_replace("##registrar##", "
			<li class='nav-item'>
				<script LANGUAGE='JavaScript'>
			    function abreSitio(){
			      var sitio = document.form1.sitio.options[document.form1.sitio.selectedIndex].value;
			      
			      location.href= sitio;
			    }
			  </script>

			  <form name='form1' target='_blank' action='index.php'>
			    <select name='sitio' onChange='javascript:abreSitio()'>
			      <option>$nickname</option>
			      <option value='Perfil'>Perfil</option>
			      <option value='Cambiar contraseña'>Cambiar contraseña</option>
			      <option value='index.php?accion=cerrarSesion&id=1'>Cerrar sesion</option>
			    </select>
			  </form>
			</li>"
			, $cadena);
			*/
		} else {
			$cadena = str_replace("##registrar##","<li class='nav-item'><a class='nav-link' href='index.php?accion=login&id=3'>Login</a></li>" , $cadena);
		}
		
        
		
		
		return $cadena;
	}

	/**
	Funcion encargada de mostrar la barra de inicio
	Recibe
		cadena --> El archivo donde hay que montar la barra del final  
	**/
	function vmontarbarra_final($cadena) {
		$menu = file_get_contents("barra_final.html");
		$trozos = explode("##barra_final##", $menu);

		$cadena = str_replace("##barra_final##", $trozos[1], $cadena);
		
		return $cadena;
	}

	/**
	Funcion encargada de mostrar el inicio
	Recibe 
		resultado --> recibe los tres resultados a las 3 consultas necesarias para montar el inicio
						(publicaciones, ejercicios, foro)
		-1 --> Si existe algun error con la bases de datos
	**/
	function vmostrarinicio($resultado) {
		$fichero = file_get_contents("inicio.html");
		$fichero = vmontarbarra_inicio($fichero);
		$fichero = vmontarbarra_final($fichero);

		$reseñas = array("IDPUBLICACION", "TITULO", "FECHA_PUBLICACION", "CONTENIDO", "AUTOR");
		$cont=0;
		while($fila = $resultado[0]->fetch_assoc()) {
			$reseñas[$cont] = array("IDPUBLICACION"=>$fila["IDPUBLICACION"],
									"TITULO"=>$fila["TITULO"], 
									"FECHA_PUBLICACION"=>$fila["FECHA_PUBLICACION"], 
									"CONTENIDO"=>$fila["CONTENIDO"], 
									"AUTOR"=>$fila["AUTOR"]);
			$cont++;
		}
		$aux = "";

		$aux = $reseñas[0];
		$aux_descripcion2 = substr($aux["CONTENIDO"], 0, 30);
		$fichero=str_replace("##resena_titulo1##", $aux["TITULO"], $fichero);
		$fichero=str_replace("##resena_texto1##", $aux_descripcion2, $fichero);
		$fichero=str_replace("##resena_texto11##", $aux["CONTENIDO"], $fichero);
		$fichero=str_replace("##resena_autor1##", $aux["AUTOR"], $fichero);
		$fichero=str_replace("##resena_fecha1##", $aux["FECHA_PUBLICACION"], $fichero);
		
		$aux = $reseñas[1];
		$aux_descripcion2 = substr($aux["CONTENIDO"], 0, 30);
		$fichero=str_replace("##resena_titulo2##", $aux["TITULO"], $fichero);
		$fichero=str_replace("##resena_texto2##", $aux_descripcion2, $fichero);
		$fichero=str_replace("##resena_texto22##", $aux["CONTENIDO"], $fichero);
		$fichero=str_replace("##resena_autor2##", $aux["AUTOR"], $fichero);
		$fichero=str_replace("##resena_fecha2##", $aux["FECHA_PUBLICACION"], $fichero);

		$aux = $reseñas[2];
		$aux_descripcion2 = substr($aux["CONTENIDO"], 0, 30);
		$fichero=str_replace("##resena_titulo3##", $aux["TITULO"], $fichero);
		$fichero=str_replace("##resena_texto3##", $aux_descripcion2, $fichero);
		$fichero=str_replace("##resena_texto33##", $aux["CONTENIDO"], $fichero);
		$fichero=str_replace("##resena_fecha3##", $aux["FECHA_PUBLICACION"], $fichero);


		$cont=0;
		while($fila = $resultado[1]->fetch_assoc()) {
			$galeria[$cont] = array("IDEJERCICIO"=>$fila["IDEJERCICIO"],
									"NOMBRE_EJERCICIO"=>$fila["NOMBRE_EJERCICIO"], 
									"NOMBRE_MUSCULO"=>$fila["NOMBRE_MUSCULO"], 
									"NIVEL_EJERCICIO"=>$fila["NIVEL_EJERCICIO"], 
									"DESCRIPCION"=>$fila["DESCRIPCION"],
									"IDFOTO"=>$fila["IDFOTO"]);
			$cont++;
		}
		$cont = 0;
		$trozos = explode("##paginaFotos##", $fichero);
		$lista_fotos = "";
		$aux = "";
		$aux = $trozos[1];
		$aux2 = $galeria[$cont];
		$cont++;
		$aux = str_replace("##foto_ejercicio1##", $aux2["IDFOTO"], $aux);
		$aux2 = $galeria[$cont];
		$cont++;
		$aux = str_replace("##foto_ejercicio2##", $aux2["IDFOTO"], $aux);
		$aux2 = $galeria[$cont];
		$cont++;
		$aux = str_replace("##foto_ejercicio3##", $aux2["IDFOTO"], $aux);
		$aux2 = $galeria[$cont];
		$cont++;
		$aux = str_replace("##foto_ejercicio4##", $aux2["IDFOTO"], $aux);
		$aux2 = $galeria[$cont];
		$cont++;
		$aux = str_replace("##foto_ejercicio5##", $aux2["IDFOTO"], $aux);
		$aux2 = $galeria[$cont];
		$cont++;
		$aux = str_replace("##foto_ejercicio6##", $aux2["IDFOTO"], $aux);
		$aux2 = $galeria[$cont];
		$cont++;
		$aux = str_replace("##foto_ejercicio7##", $aux2["IDFOTO"], $aux);
		$aux2 = $galeria[$cont];
		$cont++;
		$aux = str_replace("##foto_ejercicio8##", $aux2["IDFOTO"], $aux);
		$aux2 = $galeria[$cont];
		$cont++;
		$aux = str_replace("##foto_ejercicio9##", $aux2["IDFOTO"], $aux);
		$aux2 = $galeria[$cont];
		$cont++;
		$aux = str_replace("##foto_ejercicio10##", $aux2["IDFOTO"], $aux);
		$aux2 = $galeria[$cont];
		$cont++;
		$aux = str_replace("##foto_ejercicio11##", $aux2["IDFOTO"], $aux);
		$aux2 = $galeria[$cont];
		$cont++;
		$aux = str_replace("##foto_ejercicio12##", $aux2["IDFOTO"], $aux);

		$lista_fotos.=$aux;
		
			
		$trozos3 = explode("##titulo_foro##", $fichero);
		$lista_fotos.=$trozos3[1];

		$cont=0;
		while($fila = $resultado[2]->fetch_assoc()) {
			$temas[$cont] = array("IDTEMA"=>$fila["IDTEMA"],
									"NICKNAME"=>$fila["NICKNAME"], 
									"FECHA_PUBLICACION"=>$fila["FECHA_PUBLICACION"], 
									"NOMBRE"=>$fila["NOMBRE"], 
									"CONTENIDO"=>$fila["CONTENIDO"],
									"likes"=>$fila["likes"]);
			$cont++;
		}
		$trozos2 = explode("##cartaTema##", $fichero);
		$lista_temas = "";
		$aux="";
		$aux2 = "";
		$codigo_corazon = "<b id='numero##idtema##' class='numero' >##numero##</b><button id='corazon' data-toggle='modal' data-target='#exampleModalCenter'><img id='corazon_imagen##idtema##' src = final_fotos/corazon_lleno.png /></button>";
		for ($i=0; $i < 2; $i++) { 
			$aux2 = $temas[$i];
			$aux = $trozos2[1];
			$aux = str_replace("##fecha##", $aux2["FECHA_PUBLICACION"], $aux);
			$aux = str_replace("##titulo##", $aux2["NOMBRE"], $aux);
			$aux = str_replace("##contenido##", $aux2["CONTENIDO"], $aux);
			$aux = str_replace("##corazon##", $codigo_corazon, $aux);
			$aux = str_replace("##numero##", $aux2["likes"], $aux);
			$aux = str_replace("##idtema##", $aux2["IDTEMA"], $aux);
			

			$lista_temas.=$aux;
		}


		echo $trozos[0] . $lista_fotos . $lista_temas . $trozos2[2];
	

	}

	/**
	Funcion encargada de mostrar la informacion.html
	Recibe
		pagina --> El numero de paginas que hay para las publicaciones
		resultado --> La informacion de las publicaciones
		-1 --> Si existe algun error con la bases de datos
	**/
	//https://www.w3schools.com/howto/howto_js_read_more.asp
	//para el read more
	function vmostrarInformacion($resultado, $pagina){

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
				$aux_descripcion = substr($descripcion, 0, 40);
				//$rest = substr("abcdef", -3, -1);
				$autor = $fila['AUTOR'];
				$fecha = $fila['FECHA_PUBLICACION'];

				$aux=str_replace("##resena_titulo1##", $titulo, $aux);
				$aux=str_replace("##resena_texto1##", $aux_descripcion, $aux);
				$aux=str_replace("##resena_texto11##", $descripcion, $aux);
				$aux=str_replace("##resena_autor1##", $autor, $aux);
				$aux=str_replace("##resena_fecha1##", $fecha, $aux);
				
				$fila = $valores[$indice-1];
				$titulo2=$fila['TITULO'];
				$descripcion2 = $fila['CONTENIDO'];
				$aux_descripcion2 = substr($descripcion2, 0, 40);
				$autor2 = $fila['AUTOR'];
				$fecha2 = $fila['FECHA_PUBLICACION'];

				$aux=str_replace("##resena_titulo2##", $titulo2, $aux);
				$aux=str_replace("##resena_texto2##", $aux_descripcion2, $aux);
				$aux=str_replace("##resena_texto22##", $descripcion2, $aux);
				$aux=str_replace("##resena_autor2##", $autor2, $aux);
				$aux=str_replace("##resena_fecha2##", $fecha2, $aux);
				$carta.=$aux;
				
			}
			else{//hay numero impar de publicaciones y es el ultimo(muestro solo una tarjeta)
				$aux=$trozos[1];
				$fila = $valores[$indice-3];
				$titulo=$fila['TITULO'];
				$descripcion = $fila['CONTENIDO'];
				$aux_descripcion = substr($descripcion, 0, 40);
				$autor = $fila['AUTOR'];
				$fecha = $fila['FECHA_PUBLICACION'];

				$aux=str_replace("##resena_titulo1##", $titulo, $aux);
				$aux=str_replace("##resena_texto1##", $aux_descripcion, $aux);
				$aux=str_replace("##resena_texto11##", $descripcion, $aux);
				$aux=str_replace("##resena_autor1##", $autor, $aux);
				$aux=str_replace("##resena_fecha1##", $fecha, $aux);
				
				$fila = $valores[$indice-2];
				$titulo2=$fila['TITULO'];
				$descripcion2 = $fila['CONTENIDO'];
				$aux_descripcion2 = substr($descripcion2, 0, 40);
				$autor2 = $fila['AUTOR'];
				$fecha2 = $fila['FECHA_PUBLICACION'];

				$aux=str_replace("##resena_titulo2##", $titulo2, $aux);
				$aux=str_replace("##resena_texto2##", $aux_descripcion2, $aux);
				$aux=str_replace("##resena_texto22##", $descripcion2, $aux);
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
				echo $fichero;
			}		
		}

	}

	/**
	Funcion encargada de mostrar el contacto.html
	**/
	function vmostrarContacto(){
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
	function vmostrarEstadoContacto($resultado){
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
	function vmostrarEjercicios($resultado){
		if (is_object($resultado)) {
			$fichero = file_get_contents("lista_ejercicios.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);
			$trozos=explode("##carta_ejercicio##", $fichero);

			$lista_ejercicios = "";
			$aux = "";
			
			while($fila = mysqli_fetch_assoc($resultado)) {	
				$aux = $trozos[1];
				$aux=str_replace("##nombreejercicio##", $fila["NOMBRE_EJERCICIO"], $aux);
				$aux=str_replace("##nombre_nivel##", $fila["NIVEL_EJERCICIO"], $aux);
				$aux=str_replace("##nombre_musculo##", $fila["NOMBRE_MUSCULO"], $aux);
				$aux=str_replace("##idfoto##", $fila["IDFOTO"], $aux);
				$aux=str_replace("##idejercicio##", $fila["IDEJERCICIO"], $aux);
				
				if ($fila["NIVEL_EJERCICIO"] == "Principiante") {
					$aux=str_replace("##nombre_color##", "primary", $aux);
				} else if ($fila["NIVEL_EJERCICIO"] == "Intermedio") {
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
			echo $fichero;
		}
	}

	/**
	Funcion encargada de mostrar la informacion de un ejercicio
	Recibe
		resultado --> Si se ha realizado la consulta correctamente
		-1 --> Si existe algun problema con la base de datos
	**/
	function vmostrarEjercicioInformacion($resultado) {
		if (is_object($resultado)) {
			$fichero = file_get_contents("info_ejercicio.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);
			$codigo = "<div class='img-box'>
			            <img style='width: 400px;height: 400px;'src='fotos_ejercicios/##ejercicio_idfoto##' onclick='poIma(this.src)'>
			            <p style= 'margin-left: 80px'>Haz click en la foto para ampliar</p>			      
			          </div>";
			$fila = mysqli_fetch_assoc($resultado);
			$fichero=str_replace("##ejercicio_nombre##", $fila["NOMBRE_EJERCICIO"], $fichero);
			$fichero=str_replace("##ejercicio_descripcion##", $fila["DESCRIPCION"], $fichero);
			
			$fichero=str_replace("##ejercicio_idfoto##", $codigo, $fichero);
			$fichero=str_replace("##ejercicio_idfoto##", $fila["IDFOTO"], $fichero);
			
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

	/**
	Funcion encargada de mostrar registro
	**/
	function vmostrarRegistrar() {
		$fichero = file_get_contents("registrar_usuario.html");
		echo $fichero;
	}

	/**
	Funcion encargada de mostrar estado registro
	Recibe
		 1 --> No hay problemas y se ha guardado el usuario
		-1 --> Si existe algun problema con la base de datos
		-2 --> Si ya existe el nickname elegido por el usuario
	**/
	function vmostrarEstadoRegistro($resultado) {
		$fichero = file_get_contents("mensaje.html");
		$fichero = vmontarbarra_inicio($fichero);
		$fichero = vmontarbarra_final($fichero);
		if ($resultado==1) {
			$fichero = str_replace("##titulo_mensaje##", "Registro usuario nuevo.", $fichero);
			$fichero = str_replace("##contenido_mensaje##","Enhorabuena!!<br> Ha sido registrado sin problemas." , $fichero);
		} else if ($resultado==-1) {
			$fichero = str_replace("##titulo_mensaje##", "Error al registrarse.", $fichero);
			$fichero = str_replace("##contenido_mensaje##","Ha ocurrido un error con la base de datos a la hora de registrarse.<br> Pruebe de nuevo en unos minutos." , $fichero);
		} else {
			$nickname = $_POST["nickname"];
			$fichero = str_replace("##titulo_mensaje##", "Error al registrarse.", $fichero);
			$fichero = str_replace("##contenido_mensaje##","Ya existe un usuario con el mismo nickname: '$nickname'." , $fichero);
		}
		echo $fichero;	
	}

	/**
	Funcion encargada de mostrar login
	**/
	function vmostrarLogin() {
		$fichero = file_get_contents("login.html");
		echo $fichero;
	}

	/**
	Funcion encargada de mostrar la validacion del usuario
	Envia
		 1 --> Login correcto
		-1 --> Si existe algun problema con la base de datos
		-2 --> No existe el usuario
		-3 -> No coincide la contraseña
	**/
	function vmostrarEstadoLogin($resultado) {
		$fichero = file_get_contents("mensaje.html");
		$fichero = vmontarbarra_inicio($fichero);
		$fichero = vmontarbarra_final($fichero);

		switch ($resultado) {
			case '1':
				$fichero = str_replace("##titulo_mensaje##", "Login usuario.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","Ha iniciado sesion con éxito<br><br><br><br><br><br><br><br><br>." , $fichero);
				break;
			case '-1':
				$fichero = str_replace("##titulo_mensaje##", "Error al registrarse.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","Ha ocurrido un error con la base de datos a la hora de registrarse.<br> Pruebe de nuevo en unos minutos<br><br><br><br><br><br><br><br><br>." , $fichero);
				break;
			case '-2':
				$nombre = $_POST["nickname"];
				$fichero = str_replace("##titulo_mensaje##", "Error al registrarse.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","No existe el usuario con el nombre: '$nombre'.<br>Por favor revise el usuario introducido<br><br><br><br><br><br><br><br><br>." , $fichero);
				break;
			case '-3':
				$fichero = str_replace("##titulo_mensaje##", "Error al registrarse.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","No se ha encontrado ningún usuario con esa contraseña.<br> Por favor revise la contraseña introducida<br><br><br><br><br><br><br><br><br>." , $fichero);
				break;
		}

		echo $fichero;	
	}

	function vcambiarContraseña() {
		$fichero = file_get_contents("contrasena_nueva_aleatoria.html");
		echo $fichero;
	}
	function vcambiarContraseñaNueva() {
		$fichero = file_get_contents("cambiar_contrasena.html");
		echo $fichero;
	}

	/**
	Funcion encargada de recoger el estado de la nueva contraseña del usuario
	Envia
		 1 --> Si
		-1 --> Si existe algun problema con la base de datos
		-2 --> El nickname no cumple con las especificaciones 
		-3 --> El email no cumple con las especificacines
		-4 --> El nickname y/o el email no coinciden con la cuenta
	**/
	function vmostrarEstadoEnviarContraseña($resultado) {
		$fichero = file_get_contents("mensaje.html");
		$fichero = vmontarbarra_inicio($fichero);
		$fichero = vmontarbarra_final($fichero);

		switch ($resultado) {
			case '1':
				$fichero = str_replace("##titulo_mensaje##", "Cambiar contraseña.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","La nueva contraseña se ha enviado correctamente al email.<br> Por favor reviselo para obtener su nueva contraseña" , $fichero);
				break;
			case '-1':
				$fichero = str_replace("##titulo_mensaje##", "Error al cambiar la contraseña.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","Ha ocurrido un error con la base de datos a la hora de registrarse.<br> Pruebe de nuevo en unos minutos." , $fichero);
				break;
			case '-2':
				$fichero = str_replace("##titulo_mensaje##", "Error al cambiar la contraseña.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","El nombre debe estar compuesto unicamente por letras y espacios en blanco.<br> Por favor corrija este error para porder mandarnos su correo." , $fichero);
				break;
			case '-3':
				$fichero = str_replace("##titulo_mensaje##", "Error al cambiar la contraseña.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","El email esta mal escrito.<br> Por favor corrija este error para porder mandarnos su correo." , $fichero);
				break;
			case '-4':
				$fichero = str_replace("##titulo_mensaje##", "Error al cambiar la contraseña.", $fichero);
				$fichero = str_replace("##contenido_mensaje##","El nickname o el email no coinciden con ninguna cuenta existente." , $fichero);
				break;
		}
		
		echo $fichero;	
	}

	function vmensajeRegistrarse(){
		$fichero = file_get_contents("mensaje.html");
		$fichero = vmontarbarra_inicio($fichero);
		$fichero = vmontarbarra_final($fichero);

		$fichero = str_replace("##titulo_mensaje##", "Necesitas estar registrado.", $fichero);
		$fichero = str_replace("##contenido_mensaje##","Para poder disfrutar de todas las ventajas que ofrece nuestra página web, deberás estar registrado y haber iniciado sesión previamente.<br> Puedes iniciar sesión haciendo click <a href='index.php?accion=login&id=3' >aquí.</a>" , $fichero);

		echo $fichero;
	}

	function vmostrarPerfil($resultado){
		$fichero = file_get_contents("perfil.html");
		$fichero = vmontarbarra_inicio($fichero);
		$fichero = vmontarbarra_final($fichero);

		$fila = mysqli_fetch_assoc($resultado);
		$fichero=str_replace("##nickname##", $fila["NICKNAME"], $fichero);
		$fichero=str_replace("##nombre##", $fila["NOMBRE"], $fichero);
		$fichero=str_replace("##apellidos##", $fila["APELLIDO"], $fichero);
		$fichero=str_replace("##email##", $fila["CORREO"], $fichero);
		if ($fila["FOTO"] == null) {
			$fichero=str_replace("##foto_perfil##", "final_fotos/foto_perfil_defecto.jpg", $fichero);
		} else {
			$fichero=str_replace("##foto_perfil##", "final_fotos_perfil/".$fila["FOTO"], $fichero);
		}
		

		

		echo $fichero;
	}


	function vmostrarRutinas($resultado) {

		if (is_object($resultado)) {
			$fichero = file_get_contents("lista_rutinas.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);
			$trozos=explode("##carta_rutina##", $fichero);

			$lista_rutinas = "";
			$aux = "";
			while($fila = mysqli_fetch_assoc($resultado)) {	
				$aux = $trozos[1];
				$aux=str_replace("##nombreRutina##", $fila["NOMBRE_RUTINA"], $aux);
				$aux=str_replace("##nombre_nivel##", $fila["NIVEL_RUTINA"], $aux);
				$aux=str_replace("##nombre_musculo##", $fila["NOMBRE_MUSCULO"], $aux);
				//$aux=str_replace("##intervalo_tiempo##", $fila["INTERVALO_TIEMPO"], $aux);
				//$aux=str_replace("##idfoto##", $fila["IDFOTO"], $aux);
				$aux=str_replace("##idrutina##", $fila["IDRUTINA"], $aux);
				
				if ($fila["NIVEL_RUTINA"] == "Principiante") {
					$aux=str_replace("##nombre_color##", "primary", $aux);
				} else if ($fila["NIVEL_RUTINA"] == "Intermedio") {
					$aux=str_replace("##nombre_color##", "warning", $aux);
				} else {
					$aux=str_replace("##nombre_color##", "danger", $aux);
				}
				
				$lista_rutinas.= $aux;
			}
			

			echo $trozos[0] . $lista_rutinas . $trozos[2];
		} else {
			$fichero = file_get_contents("mensaje.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);
			$fichero = str_replace("##titulo_mensaje##", "Listado de rutinas.", $fichero);
			$fichero = str_replace("##contenido_mensaje##","Ha ocurrido un error con la base de datos a la hora de mostrar el listado de rutinas.<br> Pruebe de nuevo en unos minutos." , $fichero);
			echo $fichero;
		}
	}

	function vmostrarRutinaInfo($resultado){
		
		if (is_object($resultado[0])) {
			$fichero = file_get_contents("info_rutina.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);

			$fila = mysqli_fetch_assoc($resultado[0]);
			$fichero=str_replace("##ejercicio_nombre##", $fila["NOMBRE_RUTINA"], $fichero);
			$aux = "Intervalo de descando: &nbsp&nbsp".$fila["INTERVALO_TIEMPO"]."<br><br>Nivel de la rutina: &nbsp&nbsp".$fila["NIVEL_RUTINA"]."<br><br> Musculos implicados: &nbsp&nbsp".$fila["NOMBRE_MUSCULO"]."<br>" ;
			$fichero=str_replace("##ejercicio_descripcion##", $aux, $fichero);
			$fichero=str_replace("##ejercicio_idfoto##", "", $fichero);
			
			$trozos=explode("##carta_ejercicio##", $fichero);

			$lista_ejercicios = "";
			$aux = "";
			
			while($fila = mysqli_fetch_assoc($resultado[1])) {	

				$aux = $trozos[1];
				$aux=str_replace("##nombreejercicio##", $fila["NOMBRE_EJERCICIO"], $aux);
				$aux=str_replace("##nombre_nivel##", $fila["NIVEL_EJERCICIO"], $aux);
				$aux=str_replace("##nombre_musculo##", $fila["NOMBRE_MUSCULO"], $aux);
				$aux=str_replace("##idfoto##", $fila["IDFOTO"], $aux);
				$aux=str_replace("##idejercicio##", $fila["IDEJERCICIO"], $aux);
				
				if ($fila["NIVEL_EJERCICIO"] == "Principiante") {
					$aux=str_replace("##nombre_color##", "primary", $aux);
				} else if ($fila["NIVEL_EJERCICIO"] == "Intermedio") {
					$aux=str_replace("##nombre_color##", "warning", $aux);
				} else {
					$aux=str_replace("##nombre_color##", "danger", $aux);
				}
				
				$lista_ejercicios.= $aux;
			}
			/*
			if ($fila["NIVEL_EJERCICIO"] == "Principiante") {
				$aux=str_replace("##nombre_color##", "primary", $aux);
			} else if ($fila["NINIVEL_EJERCICIOVEL"] == "Intermedio") {
				$aux=str_replace("##nombre_color##", "warning", $aux);
			} else {
				$aux=str_replace("##nombre_color##", "danger", $aux);
			}
			*/
			echo $trozos[0] . $lista_ejercicios . $trozos[2];
		} else {
			$fichero = file_get_contents("mensaje.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);
			$fichero = str_replace("##titulo_mensaje##", "informacion del ejercicio.", $fichero);
			$fichero = str_replace("##contenido_mensaje##","Ha ocurrido un error con la base de datos a la hora de mostrar la infromacion del ejrecicios.<br> Pruebe de nuevo en unos minutos." , $fichero);
			echo $fichero;	
		}


	}
	function vmostrarForo($resultado, $resultado2, $resultado3){
		
		$fichero = file_get_contents("foro.html");
		$fichero = vmontarbarra_inicio($fichero);
		$fichero = vmontarbarra_final($fichero);
		if (isset($_SESSION["nickname"])) {
			$codigo_boton = "<button id='anadirTema' type='button' class='btn btn-secondary' data-toggle='modal' data-target='#exampleModalCenter1'>Añadir tema</button>";
			$fichero = str_replace("##anadir_tema##", $codigo_boton, $fichero);
			$codigo_corazon = "<b id='numero##idtema##' class='numero' >##numero##</b><button id='corazon' type='submit'><img id='corazon_imagen##idtema##' src = ##corazon##  onclick='cambiarCorazon(##idtema##)'/></button>";
		} else {
			$fichero = str_replace("##anadir_tema##", "", $fichero);
			$codigo_corazon = "<b id='numero##idtema##' class='numero' >##numero##</b><button id='corazon' data-toggle='modal' data-target='#exampleModalCenter'><img id='corazon_imagen##idtema##' src = final_fotos/corazon.png onclick='avisarRegistro()'/></button>";
			
		}

		$count_fila3 = 0;
		$usuarios = array("NICKNAME", "FOTO");
		while($fila3 = $resultado3->fetch_assoc()) {
			$usuarios[$count_fila3] = array("NICKNAME"=>$fila3["NICKNAME"],
								  	  "FOTO"=>$fila3["FOTO"]);
			$count_fila3++;
		}

		$lista_temas = "";
		$aux = "";
		$count = 0;
		$numeroLikes = array("IDTEMA", "LIKES");
		while($fila2 = $resultado[1]->fetch_assoc()) {
			$numeroLikes[$count] = array("IDTEMA"=>$fila2["IDTEMA"],
								  		 "LIKES"=>$fila2["LIKES"]);
			$count++;
		}

		$trozos = explode("##cartaTema##", $fichero);
		if (is_object($resultado2)) {
			
			$likes = array("IDTEMA", "NICKNAME");
			$cont=0;

			while($fila2 = $resultado2->fetch_assoc()) {
				$likes[$cont] = array("IDTEMA"=>$fila2["IDTEMA"],
									  "NICKNAME"=>$fila2["NICKNAME"]);
				$cont++;
			}
/*
			$codigo_corazon = "<b id='numero##idtema##' class='numero' >##numero##</b><button id='corazon' type='submit'><img id='corazon_imagen##idtema##' src = ##corazon##  onclick='cambiarCorazon(##idtema##)'/></button>";
*/
			while($fila = $resultado[0]->fetch_assoc()) {
				$aux = $trozos[1];
				$aux=str_replace("##corazon##", $codigo_corazon, $aux);
				$aux=str_replace("##titulo##", $fila["NOMBRE"], $aux);
				$aux=str_replace("##contenido##", $fila["CONTENIDO"], $aux);
				$aux=str_replace("##fecha##", $fila["FECHA_PUBLICACION"], $aux);
				for ($i=0; $i < $count_fila3; $i++) { 
					$usuario = $usuarios[$i];
					if ($usuario["NICKNAME"] == $fila["NICKNAME"]) {
						if ($usuario["FOTO"] == null) {
							$codigo_foto = "final_fotos/foto_perfil_defecto.jpg";
							$aux=str_replace("##foto_perfil##", $codigo_foto, $aux);
						} else {
							$codigo_foto = "final_fotos_perfil/".$usuario["FOTO"];
							$aux=str_replace("##foto_perfil##", $codigo_foto, $aux);
						}
					}
				}

				//$aux=str_replace("##foto_perfil##", "foto_perfil_defecto.jpg", $aux);
				$aux=str_replace("##idtema##", $fila["IDTEMA"], $aux);
				$x=0;
				for ($i=0; $i < $cont; $i++) { 
					$valores_likes = $likes[$i];
					if ( $fila["IDTEMA"]==$valores_likes["IDTEMA"]) {
						$aux=str_replace("##corazon##", "final_fotos/corazon_lleno.png", $aux);
						$x=1;
						break;
					}
					
				}
				if ($x==0) {
					$aux=str_replace("##corazon##", "final_fotos/corazon.png", $aux);
				}
				$x=0;
				for ($i=0; $i < $count; $i++) { 
					$numeroLikesPorTema = $numeroLikes[$i];
					if ( $fila["IDTEMA"]==$numeroLikesPorTema["IDTEMA"]) {
						$aux=str_replace("##numero##", $numeroLikesPorTema["LIKES"], $aux);
						$x++;
						break;
					}
				}
				if ($x==0) {
					$aux=str_replace("##numero##", "0", $aux);
				}
				$lista_temas.= $aux;
			}
		} elseif ($resultado2==-2) {
			/*
			$codigo_corazon = "<b id='numero##idtema##' class='numero' >##numero##</b><button id='corazon' data-toggle='modal' data-target='#exampleModalCenter'><img id='corazon_imagen##idtema##' src = final_fotos/corazon.png onclick='avisarRegistro()'/></button>";
			*/
			while($fila = $resultado[0]->fetch_assoc()) {
				$aux = $trozos[1];
				$aux=str_replace("##corazon##", $codigo_corazon, $aux);
				$aux=str_replace("##titulo##", $fila["NOMBRE"], $aux);
				$aux=str_replace("##contenido##", $fila["CONTENIDO"], $aux);
				$aux=str_replace("##fecha##", $fila["FECHA_PUBLICACION"], $aux);
				for ($i=0; $i < $count_fila3; $i++) { 
					$usuario = $usuarios[$i];
					if ($usuario["NICKNAME"] == $fila["NICKNAME"]) {
						if ($usuario["FOTO"] == null) {
							$codigo_foto = "foto_perfil_defecto.jpg";
							$aux=str_replace("##foto_perfil##", $codigo_foto, $aux);
						} else {
							$codigo_foto = $usuario["FOTO"];
							$aux=str_replace("##foto_perfil##", $codigo_foto, $aux);
						}
					}
				}
				$aux=str_replace("##idtema##", $fila["IDTEMA"], $aux);
				//$aux=str_replace("##corazon##", "", $aux);
				$x=0;
				for ($i=0; $i < $count; $i++) { 
					$numeroLikesPorTema = $numeroLikes[$i];
					if ( $fila["IDTEMA"]==$numeroLikesPorTema["IDTEMA"]) {
						$aux=str_replace("##numero##", $numeroLikesPorTema["LIKES"], $aux);
						$x++;
						break;
					}
				}
				if ($x==0) {
					$aux=str_replace("##numero##", "0", $aux);
				}
				$lista_temas.= $aux;
			}
		}
		echo $trozos[0] . $lista_temas . $trozos[2];
	}	
	

	function vmostrarMensajesTema($resultado1, $resultado2, $resultado3){
		
		if (is_object($resultado1)) {

			$fichero = file_get_contents("tema_informacion.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);
/*
			if (isset($_SESSION["nickname"]) ) {
				$fila3 = $resultado3->fetch_assoc();
				if ($fila3["FOTO"] == null) {
					$codigo_foto = "foto_perfil_defecto.jpg";
				} else {
					$codigo_foto = $fila3["FOTO"];
				}
				
			}else{
				$codigo_foto = "foto_perfil_defecto.jpg";
			}
*/
			$count_fila3 = 0;
			$usuarios = array("NICKNAME", "FOTO");
			while($fila3 = $resultado3->fetch_assoc()) {
				$usuarios[$count_fila3] = array("NICKNAME"=>$fila3["NICKNAME"],
									  	  		"FOTO"=>$fila3["FOTO"]);
				$count_fila3++;
			}

			$cont22=0;

			//mensajes secundarios
			if (is_object($resultado2)) {
				while($fila = $resultado2->fetch_assoc()) {
					$valores2[$cont22] = array("IDMENSAJE_SECUNDARIO"=>$fila["IDMENSAJE_SECUNDARIO"],
											"IDMENSAJE"=>$fila["IDMENSAJE"], 
											 "IDTEMA"=>$fila["IDTEMA"], 
											 "NICKNAME"=>$fila["NICKNAME"], 
											 "FECHA_PUBLICACION_MENSAJE"=>$fila["FECHA_PUBLICACION_MENSAJE"],
											 "CONTENIDO"=>$fila["CONTENIDO"]);
					$cont22++;
				}
			}
			$cont=0;
			//mensajes foro (el primero es la info del mensaje del tema(el primero))
			if ($resultado1->num_rows > 1) {
				while($fila = $resultado1->fetch_assoc()) {
					$valores1[$cont] = array("IDMENSAJE"=>$fila["IDMENSAJE"],
											 "NICKNAME"=>$fila["NICKNAME"], 
											 "IDTEMA"=>$fila["IDTEMA"], 
											 "CONTENIDO"=>$fila["CONTENIDO"], 
											 "NOMBRE"=>$fila["NOMBRE"],
											 "FECHA_PUBLICACION"=>$fila["FECHA_PUBLICACION"],
											 "FECHA_PUBLICACION_MENSAJE"=>$fila["FECHA_PUBLICACION_MENSAJE"],
											 "contenidoTema"=>$fila["contenidoTema"]);
					$cont++;

				}
			} else {
				//si solo hay una fila puede porque devuelva el tema y un mensaje
				// o puede que solo devuelva el tema sin mensajes
				$fila = $resultado1->fetch_assoc();
				if (count($fila) == 8) {
					$valores1[$cont] = array("IDMENSAJE"=>$fila["IDMENSAJE"],
											 "NICKNAME"=>$fila["NICKNAME"], 
											 "IDTEMA"=>$fila["IDTEMA"], 
											 "CONTENIDO"=>$fila["CONTENIDO"], 
											 "NOMBRE"=>$fila["NOMBRE"],
											 "FECHA_PUBLICACION"=>$fila["FECHA_PUBLICACION"],
											 "FECHA_PUBLICACION_MENSAJE"=>$fila["FECHA_PUBLICACION_MENSAJE"],
											 "contenidoTema"=>$fila["contenidoTema"]);
					$cont=1;
				} else {
					$valores1[$cont] = array("IDTEMA"=>$fila["IDTEMA"],
											 "FECHA_PUBLICACION"=>$fila["FECHA_PUBLICACION"], 
											 "NOMBRE"=>$fila["NOMBRE"],
											 "NICKNAME"=>$fila["NICKNAME"], 
											 "contenidoTema"=>$fila["contenidoTema"]);
				}
			}
			$lista_mensaje = "";
			$aux = "";

			$trozos1 = explode("##cartaPrincipal##", $fichero);
			
			$mensaje = $valores1[0];
			$trozos1[0]=str_replace("##idtema##", $mensaje["IDTEMA"], $trozos1[0]);

			$trozos2 = explode("##cartaSecundaria##", $fichero);

			$cont2 = 0;
			foreach ($valores1 as &$valor) {
				if ($cont==0) {
					$aux = $trozos1[1];
					$aux=str_replace("##contenido_tema##", $valor["contenidoTema"], $aux);
					$aux=str_replace("##fecha_tema##", $valor["FECHA_PUBLICACION"], $aux);

					//$aux=str_replace("##foto_perfil##", $codigo_foto, $aux);

					for ($i=0; $i < $count_fila3; $i++) { 
						$usuario = $usuarios[$i];
						if ($usuario["NICKNAME"] == $valor["NICKNAME"]) {
							if ($usuario["FOTO"] == null) {
								$codigo_foto = "final_fotos/foto_perfil_defecto.jpg";
								$aux=str_replace("##foto_perfil##", $codigo_foto, $aux);
							} else {
								$codigo_foto = "final_fotos_perfil/".$usuario["FOTO"];
								$aux=str_replace("##foto_perfil##", $codigo_foto, $aux);
							}
						}
					}
					
					$aux=str_replace("##titulo_tema##", $valor["NOMBRE"], $aux);
					$cont2++;
					$lista_mensaje.= $aux;
					break;
				} else {
					if ($cont2==0) {
						$aux = $trozos1[1];
						$aux=str_replace("##contenido_tema##", $valor["contenidoTema"], $aux);
						$aux=str_replace("##fecha_tema##", $valor["FECHA_PUBLICACION"], $aux);
						//$aux=str_replace("##foto_perfil##", $codigo_foto, $aux);
						for ($i=0; $i < $count_fila3; $i++) { 
							$usuario = $usuarios[$i];
							if ($usuario["NICKNAME"] == $valor["NICKNAME"]) {
								if ($usuario["FOTO"] == null) {
									$codigo_foto = "final_fotos/foto_perfil_defecto.jpg";
									$aux=str_replace("##foto_perfil##", $codigo_foto, $aux);
								} else {
									$codigo_foto = "final_fotos_perfil/".$usuario["FOTO"];
									$aux=str_replace("##foto_perfil##", $codigo_foto, $aux);
								}
							}
						}
						$aux=str_replace("##titulo_tema##", $valor["NOMBRE"], $aux);
						$cont2++;
						$lista_mensaje.= $aux;
						//$aux=str_replace("##idtema##", $fila["IDTEMA"], $aux);
					} 
					$aux = $trozos2[1];
					//$aux=str_replace("##foto_perfil##", $codigo_foto, $aux);
					for ($i=0; $i < $count_fila3; $i++) { 
						$usuario = $usuarios[$i];
						if ($usuario["NICKNAME"] == $valor["NICKNAME"]) {
							if ($usuario["FOTO"] == null) {
								$codigo_foto = "final_fotos/foto_perfil_defecto.jpg";
								$aux=str_replace("##foto_perfil##", $codigo_foto, $aux);
							} else {
								$codigo_foto = "final_fotos_perfil/".$usuario["FOTO"];
								$aux=str_replace("##foto_perfil##", $codigo_foto, $aux);
							}
						}
					}
					$aux=str_replace("##fecha_tema##", $valor["FECHA_PUBLICACION_MENSAJE"], $aux);
					$aux=str_replace("##contenido##", $valor["CONTENIDO"], $aux);
					$aux=str_replace("##idmensaje##", $valor["IDMENSAJE"], $aux);
					

					if ($cont22>0) {
						$contSecundarios = 0;
						$codigo =  "<div id='cardTercera' class='card shadow p-3 mb-5 bg-white rounded' >
										<div class='row no-gutters'>
											<div class='col-md-4'>
												<img id='foto_perfil' class='rounded-circle' src='##foto_perfil_tercera##'  >
												<p id='fecha'>##fecha_tema_tercera##</p>
											</div>
											<div class='col-md-8'>
												<div class='card-body'>
													<p class='card-text'>##contenido_tercera##</p>
												</div>
											</div>
										</div>
									</div>
									##cartaTercera##";
						foreach ($valores2 as &$valor2) {
							$contSecundarios = 0;
							
							if ( ($valor["IDMENSAJE"] == $valor2["IDMENSAJE"]) and ($valor["IDTEMA"] == $valor2["IDTEMA"]) ){

								$aux=str_replace("##cartaTercera##", $codigo, $aux);
								//$aux=str_replace("##foto_perfil_tercera##", $codigo_foto, $aux);
								for ($i=0; $i < $count_fila3; $i++) { 
									$usuario = $usuarios[$i];
									if ($usuario["NICKNAME"] == $valor2["NICKNAME"]) {
										if ($usuario["FOTO"] == null) {
											$codigo_foto = "final_fotos/foto_perfil_defecto.jpg";
											$aux=str_replace("##foto_perfil_tercera##", $codigo_foto, $aux);
										} else {
											$codigo_foto = "final_fotos_perfil/".$usuario["FOTO"];
											$aux=str_replace("##foto_perfil_tercera##", $codigo_foto, $aux);
										}
									}
								}
								$aux=str_replace("##fecha_tema_tercera##", $valor2["FECHA_PUBLICACION_MENSAJE"], $aux);
								$aux=str_replace("##contenido_tercera##", $valor2["CONTENIDO"], $aux);
								$contSecundarios++;
							}
						}
						$aux=str_replace("##cartaTercera##","", $aux);
					} 
					$aux=str_replace("##cartaTercera##","", $aux);
					$lista_mensaje.= $aux;
				}
				
			}


			echo $trozos1[0] . $lista_mensaje . $trozos2[2];
		} else {
			$fichero = file_get_contents("mensaje.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);
			$fichero = str_replace("##titulo_mensaje##", "Mensaje del foro.", $fichero);
			$fichero = str_replace("##contenido_mensaje##","Ha ocurrido un error con la base de datos a la hora de mostrar la informacion de este tema.<br> Pruebe de nuevo en unos minutos.<br>" , $fichero);
			
			echo $fichero;
		}
		
	}

	function vmostrarMensajePrincipal($resultado){
		$fichero = file_get_contents("mensaje.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);
			
		if ($resultado==1) {
			$fichero = str_replace("##titulo_mensaje##", "Responder a un mensaje en el foro", $fichero);
			$fichero = str_replace("##contenido_mensaje##","Su mensaje se ha enviado correctamente.<br>Ya puede verlo en su tema de interés en el foro.<br><br> " , $fichero);
		} else {
			$fichero = str_replace("##titulo_mensaje##", "Responder a un mensaje en el foro", $fichero);
			$fichero = str_replace("##contenido_mensaje##","Ha ocurrido un error con la base de datos a la hora de mostrar la informacion de este tema.<br> Pruebe de nuevo en unos minutos.<br>" , $fichero);
		}

		echo $fichero;
	}

	function vmostrarMensajeSecundario($resultado){
		$fichero = file_get_contents("mensaje.html");
			$fichero = vmontarbarra_inicio($fichero);
			$fichero = vmontarbarra_final($fichero);
			
		if ($resultado==1) {
			$fichero = str_replace("##titulo_mensaje##", "Responder a un mensaje en el foro", $fichero);
			$fichero = str_replace("##contenido_mensaje##","Su mensaje se ha enviado correctamente.<br>Ya puede verlo en su tema de interés en el foro.<br><br> " , $fichero);
		} else {
			$fichero = str_replace("##titulo_mensaje##", "Responder a un mensaje en el foro", $fichero);
			$fichero = str_replace("##contenido_mensaje##","Ha ocurrido un error con la base de datos a la hora de mostrar la informacion de este tema.<br> Pruebe de nuevo en unos minutos.<br>" , $fichero);
		}

		echo $fichero;
	}

	function vmostrarEstadoPDF($resultado){
		$fichero = file_get_contents("mensaje.html");
		$fichero = vmontarbarra_inicio($fichero);
		$fichero = vmontarbarra_final($fichero);

		if ($resultado==-1) {
			$fichero = str_replace("##titulo_mensaje##", "Error al abrir el PDF.", $fichero);
			$fichero = str_replace("##contenido_mensaje##","Ha ocurrido un error con la BBDD. Vuelva a intentarlo en unos minutos.<br>Disculpe las molestias.<br>" , $fichero);
			echo $fichero;
		}
	}

	function vmostarEstado($resultado){
		$fichero = file_get_contents("mensaje.html");
		$fichero = vmontarbarra_inicio($fichero);
		$fichero = vmontarbarra_final($fichero);

		if ($resultado==-1) {
			$fichero = str_replace("##titulo_mensaje##", "Error al añadir un nuevo tema.", $fichero);
			$fichero = str_replace("##contenido_mensaje##","Ha ocurrido un error con la BBDD. Vuelva a intentarlo en unos minutos.<br>Disculpe las molestias.<br>" , $fichero);
			echo $fichero;
		} else {
			$fichero = str_replace("##titulo_mensaje##", "Tema nuevo añadido.", $fichero);
			$fichero = str_replace("##contenido_mensaje##","El tema se ha añadido correctamente.<br>Ya puede verlo en el foro.<br>" , $fichero);
			echo $fichero;
		}
	}
?>