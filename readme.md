# Instalación y ejecución del proyecto

## 1. Crear el archivo `.env`

En la raíz del proyecto crear el archivo `.env`:

```
SMTP_HOST=smtp.gmail.com
SMTP_USER=demirandaemiliano@gmail.com
SMTP_PASS=jtdxyafwmuxrhiju
SMTP_PORT=587

PHP_PORT=8090

```

## 2. Levantar los contenedores

Desde la raíz del proyecto ejecutar:

```bash
sudo docker-compose up -d --build
```

## 3. Crear `composer.json`

Ingresar a la carpeta `src` y crear el archivo:

```bash
cd src
nano composer.json
```

Pegar el siguiente contenido:

```json
{
    "require": {
        "phpmailer/phpmailer": "^7.0",
        "fpdf/fpdf": "^1.86",
        "chillerlan/php-qrcode": "^6.0"
    }
}
```

## 4. Crear `composer.lock`

Dentro de la carpeta `src` crear el archivo:

```bash
nano composer.lock
```

y pegar el contenido provisto para `composer.lock`.

## 5. Crear el archivo de datos

Dentro de la carpeta `src` crear:

```bash
touch datos.txt
```

## 6. Asignar permisos

Dar permisos de lectura y escritura a los directorios utilizados por la aplicación.

### Carpeta `data`

```bash
chmod -R 775 data
```

### Carpeta `pdf`

```bash
chmod -R 775 pdf
```

### Archivo `datos.txt`

```bash
chmod 664 datos.txt
```

## 7. Instalar dependencias de Composer

Ingresar al contenedor:

```bash
sudo docker exec -it app_pdf_mail bash
```

Ubicarse en la carpeta donde se encuentra `composer.json` y ejecutar:

```bash
composer install
```

Esto generará la carpeta `vendor`.

## 8. Asignar permisos a `vendor`

Una vez creada la carpeta:

```bash
chmod -R 775 vendor
```

## 9. Acceder a la aplicación

Abrir el navegador y acceder a:

```text
http://localhost:8090/index.php
```

## 10. Verificación

Al enviar una reserva correctamente se deberá:

* Validar los datos ingresados.
* Guardar la reserva en `datos.txt`.
* Generar un PDF en la carpeta correspondiente.
* Generar el código QR.
* Enviar un correo electrónico con el PDF adjunto.
* Mostrar el mensaje de confirmación de reserva.

