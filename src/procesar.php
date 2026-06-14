<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

ob_start();

$archivoTxt = __DIR__ . "/datos.txt";

// RECIBIR DATOS DEL FORMULARIO
$nombre = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$entrada = $_POST['entrada'] ?? '';
$salida = $_POST['salida'] ?? '';
$personas = $_POST['personas'] ?? '';
$experiencia = $_POST['experiencia'] ?? '';
$extras = isset($_POST['extras']) ? $_POST['extras'] : [];

$validado = true;

$data = [
    "nombre" => $nombre,
    "email" => $email,
    "telefono" => $telefono,
    "entrada" => $entrada,
    "salida" => $salida,
    "personas" => $personas,
    "experiencia" => $experiencia,
    "extras" => $extras
];

//NOMBRE
if (!empty(trim($nombre))) {
    if (preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
        echo "Nombre válido<br>";
    } else {
        echo "Nombre inválido<br>";
        $validado = false;
    }
} else {
    echo "Nombre obligatorio<br>";
    $validado = false;
}

//EMAIL
if (!empty(trim($email))) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email válido<br>";
    } else {
        echo "Email inválido<br>";
        $validado = false;
    }
} else {
    echo "Email obligatorio<br>";
    $validado = false;
}

//TELÉFONO
if (!empty(trim($telefono))) {
    if (preg_match('/^[0-9\s\-]{7,15}$/', $telefono)) {
        echo "Teléfono válido<br>";
    } else {
        echo "Teléfono inválido<br>";
        $validado = false;
    }
}

//FECHAS
if (!empty($entrada) && !empty($salida)) {
    if ($entrada < $salida) {
        echo "Fechas válidas<br>";
    } else {
        echo "La fecha de salida debe ser posterior a la de entrada<br>";
        $validado = false;
    }
} else {
    echo "Fechas obligatorias<br>";
    $validado = false;
}

//PERSONAS
if (!empty($personas)) {
    if (filter_var($personas, FILTER_VALIDATE_INT) && $personas > 0) {
        echo "Cantidad de personas válida<br>";
    } else {
        echo "Cantidad de personas inválida<br>";
        $validado = false;
    }
} else {
    echo "Cantidad de personas obligatoria<br>";
    $validado = false;
}

//EXPERIENCIA
if (empty($experiencia)) {
    echo "Debe seleccionar experiencia<br>";
    $validado = false;
}


//GUARDAR
if ($validado) {

    $extrasStr = !empty($extras) ? implode(",", $extras) : "Sin extras";

    $registro = "$nombre|$email|$telefono|$entrada|$salida|$personas|$experiencia|$extrasStr\n";

    file_put_contents($archivoTxt, $registro, FILE_APPEND);

    require_once 'funciones.php';  // Incluir las funciones.php
    
    var_dump($data);

    // Generar el PDF
    $pdfPath = generarPDF($data);

    // Enviar el correo con el PDF adjunto
    enviarMail($data, $pdfPath);

    $mensajeFinal = "Reserva registrada correctamente";

} else {
    $mensajeFinal = "Errores en el formulario";
}



$detalles = ob_get_clean();
?>
<?php if ($validado): ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva confirmada</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="contenedor">

<h1>Reserva realizada </h1>

<p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
<p><strong>Email:</strong> <?php echo $email; ?></p>
<p><strong>Teléfono:</strong> <?php echo $telefono; ?></p>

<p><strong>Entrada:</strong> <?php echo $entrada; ?></p>
<p><strong>Salida:</strong> <?php echo $salida; ?></p>
<p><strong>Personas:</strong> <?php echo $personas; ?></p>

<p><strong>Experiencia:</strong> <?php echo $experiencia; ?></p>

<p><strong>Extras:</strong></p>
<ul>
<?php foreach ($extras as $extra): ?>
    <li><?php echo $extra; ?></li>
<?php endforeach; ?>
</ul>

<h2> Reserva registrada correctamente</h2>

</div>

</body>
</html>

<?php else: ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error en la reserva</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="contenedor">

<h1> Error en la reserva</h1>

<div>
    <?php echo $detalles; ?>
</div>

<br>
<a href="index.html">Volver al formulario</a>

</div>

</body>
</html>

<?php endif; ?>