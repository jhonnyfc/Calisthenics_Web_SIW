<?php 

	$titulo="Primera dominada";
	$descripcion="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

	$autor="vadym";
	$fecha="02/03/2020";

	$titulo2="Primera dominada2";
	$descripcion2="2Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

	$autor2="vadym2";
	$fecha2="02/03/2022";


	$fichero=file_get_contents("informacion.html");
	$trozos=explode("##tarjetaInfo##", $fichero);
	$carta="";
	
	$aux=$trozos[1];

	$aux=str_replace("##resena_titulo##", $titulo, $aux);
	$aux=str_replace("##resena_texto##", $descripcion, $aux);
	$aux=str_replace("##resena_autor##", $autor, $aux);
	$aux=str_replace("##resena_fecha##", $fecha, $aux);
	$carta.=$aux;

	$aux=$trozos[1];
	$aux=str_replace("##resena_titulo##", $titulo2, $aux);
	$aux=str_replace("##resena_texto##", $descripcion2, $aux);
	$aux=str_replace("##resena_autor##", $autor2, $aux);
	$aux=str_replace("##resena_fecha##", $fecha2, $aux);
	$carta.=$aux;

	echo $trozos[0].$carta.$trozos[2];
	
?>