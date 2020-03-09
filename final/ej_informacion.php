<?php 

	$titulo="Primera dominada";
	$descripcion="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

	$descripcion =mb_substr($descripcion, 0, 120);

	$autor="vadym";
	$fecha="02/03/2020";

	$titulo2="Primera dominada2";
	$descripcion2="2Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

	$descripcion2 =mb_substr($descripcion2, 0, 120);
	$autor2="vadym2";

	$fecha2="02/03/2022";


	$fichero=file_get_contents("informacion_bueno.html");
	$trozos=explode("##tarjetaInfo##", $fichero);
	$carta="";
	
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

	$paginacion_trozos=explode("##paginacion##", $fichero);

	$aux=$paginacion_trozos[1];
	$aux=str_replace("##numero_pagina##", 1, $aux);

	echo $trozos[0].$carta.$aux.$paginacion_trozos[2];
	
?>