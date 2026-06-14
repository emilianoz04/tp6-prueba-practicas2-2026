<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva Hotel</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="contenedor">

        <h1>Reserva tu experiencia</h1>
        <p class="subtitulo">Completá tus datos y elegí cómo querés vivir tu estadía</p>

        <form action="procesar.php" method="POST">

            <h2>Datos personales</h2>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>

            <h2>Reserva</h2>
            <label>Fecha de entrada:</label>
            <input type="date" name="entrada" required>

            <label>Fecha de salida:</label>
            <input type="date" name="salida" required>

            <input type="number" name="personas" placeholder="Cantidad de personas" required>

            <h2>Tipo de experiencia</h2>
            <select name="experiencia">
                <option>Escapada romántica</option>
                <option>Detox digital</option>
                <option>Aventura económica</option>
                <option>Modo gamer</option>
            </select>

            <h2>Extras</h2>

            <div class="checkbox">
                <input type="checkbox" name="extras[]" value="Desayuno">
                <label>Desayuno</label>
            </div>

            <div class="checkbox">
                <input type="checkbox" name="extras[]" value="Spa">
                <label>Spa</label>
            </div>

            <div class="checkbox">
                <input type="checkbox" name="extras[]" value="Late check-out">
                <label>Late check-out</label>
            </div>

            <div class="checkbox">
                <input type="checkbox" name="extras[]" value="Sorpresa">
                <label>Sorpresa</label>
            </div>

            <button type="submit">Reservar</button>

        </form>

    </div>
</body>
</html>
