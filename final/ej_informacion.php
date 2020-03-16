<?php 

	$conexion = mysqli_connect("localhost", "root", "", "grupo33");

	if (!$conexion) {
		die("Conexión fallida: " . mysqli_connect_error());
	}

	$consulta = "select * from final_publicacion";
	if ($resultado = $conexion->query($consulta)) {
		//print_r("OK<br>");
	} else {
		echo "Error en la query";
		die(-1);
	}

	$valores = array("IDPUBLICACION", "FECHA_PUBLICACION", "CONTENIDO", "AUTOR");
	$cont=0;


	if ($resultado->num_rows > 0) {
		// sacamos los datos para cada registro
		while($fila = $resultado->fetch_assoc()) {
			$valores[$cont] = array("IDPUBLICACION"=>$fila["IDPUBLICACION"],
							"TITULO"=>$fila["TITULO"], 
							 "FECHA_PUBLICACION"=>$fila["FECHA_PUBLICACION"], 
							 "CONTENIDO"=>$fila["CONTENIDO"], 
							 "AUTOR"=>$fila["AUTOR"]);
			$cont++;
		}
	} else {
		echo "No hay resultados";
	}
	
	$fichero=file_get_contents("informacion.html");
	$trozos=explode("##tarjetaInfo##", $fichero);
	$carta="";

	$longitud_valores = count($valores);//numero filas de tabla
	$numero_pagina = $longitud_valores/2;//numeros de paginacion
	$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
	$indice = $pagina * 2;

	

	if ($pagina<$numero_pagina && $pagina==1) {
		$boton_anterior=$pagina;
		$boton_siguiente=$pagina+1;
	}
	elseif ($pagina>$numero_pagina ) {
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


	


?>

