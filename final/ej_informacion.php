<?php 

	$conexion = mysqli_connect("localhost", "root", "", "mysql");

	if (!$conexion) {
		die("Conexión fallida: " . mysqli_connect_error());
	}
	//echo "Conexión creada correctamente<br>";




	$consulta = "select * from final_publicacion";
/*
	if ($resultado = $conexion->query($consulta)) {
		print_r("OK<br>");
	} else {
		print_r("mal<br>");
	}

	echo "<br>";

	if ($resultado->num_rows > 0) {
		// sacamos los datos para cada registro
		while($fila = $resultado->fetch_assoc()) {
			echo "IDPUBLICACION: " . $fila["IDPUBLICACION"]. " - FECHA_PUBLICACION: " .
			$fila["FECHA_PUBLICACION"]. "- CONTENIDO: " . $fila["CONTENIDO"]."- AUTOR: ".$fila["AUTOR"]. "<br>";
		}
	} else {
		echo "No hay resultados";
	}
*/
	if ($resultado = $conexion->query($consulta)) {
		//print_r("OK<br>");
	} else {
		//print_r("mal<br>");
	}

	$valores = array("IDPUBLICACION", "FECHA_PUBLICACION", "CONTENIDO", "AUTOR");
	$cont=0;

	/*$miarray = array("titulo"=>"Las legiones malditas",
						  "autor" => "Santiago Posteguillo",
						  "editorial" => "Ediciones B",
						  "fechaPublicacion" => 2008);
  */

	if ($resultado->num_rows > 0) {
		// sacamos los datos para cada registro
		while($fila = $resultado->fetch_assoc()) {
			//$valores[$cont] = $fila["IDPUBLICACION"]."-".$fila["FECHA_PUBLICACION"]."-".$fila["CONTENIDO"]."-".$fila["AUTOR"];
			$valores[$cont] = array("IDPUBLICACION"=>$fila["IDPUBLICACION"],
							 "FECHA_PUBLICACION"=>$fila["FECHA_PUBLICACION"], 
							 "CONTENIDO"=>$fila["CONTENIDO"], 
							 "AUTOR"=>$fila["AUTOR"]);
			$cont++;
			//echo "IDPUBLICACION: " . $fila["IDPUBLICACION"]. " - FECHA_PUBLICACION: " .$fila["FECHA_PUBLICACION"]. "- CONTENIDO: " . $fila["CONTENIDO"]."- AUTOR: ".$fila["AUTOR"]. "<br>";
		}
	} else {
		echo "No hay resultados";
	}
	/*
	foreach ($valores as $key => $value) {
		print_r($value['IDPUBLICACION']."<br>");
		print_r($value["FECHA_PUBLICACION"]."<br>");
		print_r($value["CONTENIDO"]."<br>");
		print_r($value["AUTOR"]."<br>");
	}
	*/

	$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
	$indice = $pagina * 2;

	
	$longitud_valores = count($valores);
	$numero_pagina = $longitud_valores/2;//numeros de paginacion(me dan numeros decimales!!!!!! usar intdiv?)

	$fichero=file_get_contents("informacion.html");
	$trozos=explode("##tarjetaInfo##", $fichero);
	$carta="";

	print_r( "Numero:pagina: ".$numero_pagina."<br>");
	print_r( "PAgina: ".$pagina."<br>");


	if ( ($longitud_valores % 2 == 0) && (($numero_pagina + 1)!=$pagina) ) {//muestro dos tarjetas
		$fila = $valores[$indice-2];
		$titulo="Primera dominada";
		$descripcion = $fila['CONTENIDO'];
		$autor = $fila['AUTOR'];
		$fecha = $fila['FECHA_PUBLICACION'];

		$fila = $valores[$indice-1];
		$titulo2="Primera dominada2";
		$descripcion2 = $fila['CONTENIDO'];
		$autor2 = $fila['AUTOR'];
		$fecha2 = $fila['FECHA_PUBLICACION'];


		
		$aux=$trozos[1];
		$aux=str_replace("##resena_titulo1##", $titulo, $aux);
		$aux=str_replace("##resena_texto1##", $descripcion, $aux);
		$aux=str_replace("##resena_autor1##", $autor, $aux);
		$aux=str_replace("##resena_fecha1##", $fecha, $aux);


		$aux=str_replace("##resena_titulo2##", $titulo2, $aux);
		$aux=str_replace("##resena_texto2##", $descripcion2, $aux);
		$aux=str_replace("##resena_autor2##", $autor2, $aux);
		$aux=str_replace("##resena_fecha2##", $fecha2, $aux);
		$carta.=$aux;

		
	}
	else{//hay numero impar de publicaciones y es el ultimo(muestro solo una tarjeta)
		//print_r("Indice: ".$indice."<br>");
		$fila = $valores[$indice-2];
		$titulo="Primera dominada";
		$descripcion = $fila['CONTENIDO'];
		$autor = $fila['AUTOR'];
		$fecha = $fila['FECHA_PUBLICACION'];

		$aux=$trozos[1];
		$aux=str_replace("##resena_titulo1##", $titulo, $aux);
		$aux=str_replace("##resena_texto1##", $descripcion, $aux);
		$aux=str_replace("##resena_autor1##", $autor, $aux);
		$aux=str_replace("##resena_fecha1##", $fecha, $aux);
		$carta.=$aux;
	}
	
	

	$paginacion="";
	for ($i=0; $i < $numero_pagina; $i++) { 
		$aux=$$aux=$trozos[2];
		$aux=str_replace("##numero_pagina##", $i+1, $aux);
		$paginacion.=$aux;
	}

	

	echo $trozos[0].$carta.$paginacion.$trozos[3];


	


?>

