<!DOCTYPE html>  <!-- Vistas/plantilla.php-->
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>CRUD</title>

	<link rel="stylesheet" type="text/css" href="Vistas/css/estilos.css">
	<link rel="stylesheet" href="Vistas/css/bootstrap.min.css">  
	<link rel="stylesheet" href="Vistas/css/sweetalert2.min.css">

</head>
<body>
	<?php
		$rutasC = new RutasC();
		include 'Modulos/menu.php';
	?>	
	<section>
	<?php
		$modulo = $rutasC->procesaRutasC();
		include $modulo;
	?>	
	</section>
	<script src="Vistas/js/bootstrap.min.js"></script>
	<script src="Vistas/js/sweetalert2.min.js"></script>
	<script src="Vistas/js/modal.js"></script>
	<script src="Vistas/js/funcionalidades.js"></script>
	<script src="Vistas/js/chart.js"></script>
	<script src="Vistas/js/chartjs-adapter-date-fns.js"></script>
</body>
</html>