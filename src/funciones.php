<?php
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Fpdf\Fpdf;

// ====== PDF ======
function generarPDF($data) {

    $pdf = new Fpdf();
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 18);
    $pdf->SetTextColor(0, 102, 204);
    $pdf->Cell(0, 10, 'Reserva Hotel', 0, 1);

    $pdf->SetTextColor(0, 0, 0);

    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(150, 10);
    $pdf->Cell(40, 5, 'Reserva Nro: ' . rand(100000,999999), 0, 1, 'R');

    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(100, 8, 'Informacion del cliente', 0, 0);

    $pdf->Cell(0, 8, 'Detalles de la reserva', 0, 1);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(100, 6, "Nombre: " . $data['nombre'], 0, 0);
    $pdf->Cell(0, 6, "Entrada: " . $data['entrada'], 0, 1);
    $pdf->Cell(100, 6, "Email: " . $data['email'], 0, 0);
    $pdf->Cell(0, 6, "Salida: " . $data['salida'], 0, 1);
    $pdf->Cell(100, 6, "Telefono: " . $data['telefono'], 0, 0);
    $pdf->Cell(0, 6, "Personas: " . $data['personas'], 0, 1);

    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 8, "Experiencia: " . $data['experiencia'], 0, 1);

    $pdf->Ln(5);

    $extras = !empty($data['extras']) ? implode(", ", $data['extras']) : "Sin extras";
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 8, "Extras: ", 0, 1);

    $pdf->SetFont('Arial', '', 11);
    $pdf->Multicell(0, 6, $extras);

    $pdf->Ln(10);

    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());

    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(150, 10, "Total", 0, 0);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, "$" . $data["total"], 0, 1, 'R');

    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->Cell(0, 6, "Gracias por su reserva.", 0, 1, 'C');

    $ruta = __DIR__ . '/pdf/reserva_' . time() . '.pdf';
    $pdf->Output('F', $ruta);

    return $ruta;
}


// ====== MAIL ======
function enviarMail($data, $pdfPath = null) {

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'profesionalizantes29@gmail.com';
        $mail->Password = 'bhkgqtxxfvbfehfq';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587
;
       //debug de prueba
	//$mail->SMTPDebug = 2;
        // $mail->Debugoutput = 'html';

        $mail->setFrom('profesionalizantes29@gmail.com', 'Hotel');
        $mail->addAddress($data['email']);

        // si no viene PDF, lo genera
        if ($pdfPath === null) {
            $pdfPath = generarPDF($data);
        }

        $mail->addAttachment($pdfPath);

        $mail->isHTML(true);
        $mail->Subject = 'Confirmacion de Reserva';
        $mail->Body = "Hola " . $data['nombre'] . ", tu reserva fue confirmada.";

        $mail->send();

    } catch (Exception $e) {
        error_log("Error al enviar mail: {$mail->ErrorInfo}");
    }
}
