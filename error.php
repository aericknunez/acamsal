<?php
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);

if (! $error) {
    $error = 'Oops! ucurrio un error desconocido.';
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Upss!! Ha ocurrido un error.. </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="assets/css/style_error.css">
</head>
<body>
<div class="wrap">
	<div class="banner">
		<a href="index.php"><img src="assets/img/imagenes/banner.png" alt="" /></a>
	</div>
	<div class="page">
		<h2>Ha ocurrido un error!</h2>
		<p><?php echo $error; ?></p><p><a href="index.php">Regresar</a></p>
	</div>
</div>
</body>
</html>

