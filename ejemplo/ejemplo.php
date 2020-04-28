<?php 

	if (isset($_GET['offset']) && isset($_GET['limit'])) {
		$offset = $_GET['offset'];
		$limit = $_GET['limit'];
	
		$conexion = mysqli_connect("localhost", "root", "", "grupo33");
		
		$consulta = "select FE.IDEJERCICIO, FE.NOMBRE, FG.NOMBRE_MUSCULO , FE.NIVEL, FE.DESCRIPCION, FE.IDFOTO
					from final_ejercicio FE, final_grupo FG
					where FE.MUSCULO = FG.IDGRUPO LIMIT {$limit} OFFSET{$offset};";

		$data = mysqliquery($conexion,"select * from final_ejercicio LIMIT {$limit} OFFSET{$offset};");
		
		while ($row = mysqli_fetch_array($data) ) {
			echo '<div class = "blog-post"><h1>'. $row['id']. '</h1><p>'.$row['NOMBRE']. '</p></div>';
		}
	}



?>