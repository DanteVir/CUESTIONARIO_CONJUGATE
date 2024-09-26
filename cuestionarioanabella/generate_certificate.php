<?php
// Asegúrate de que GD esté habilitado en tu servidor PHP
if (!extension_loaded('gd')) {
    die('La extensión GD no está habilitada en este servidor.');
}

function generateCertificate($name, $score, $total_questions) {
    // Crear una imagen de 800x600
    $image = imagecreatetruecolor(800, 600);

    // Definir colores
    $background = imagecolorallocate($image, 255, 255, 200); // Amarillo claro
    $text_color = imagecolorallocate($image, 0, 0, 100); // Azul oscuro
    $accent_color = imagecolorallocate($image, 255, 100, 100); // Rojo claro

    // Llenar el fondo
    imagefill($image, 0, 0, $background);

    // Dibujar un borde colorido
    imagefilledrectangle($image, 0, 0, 799, 20, $accent_color); // Arriba
    imagefilledrectangle($image, 0, 580, 799, 599, $accent_color); // Abajo
    imagefilledrectangle($image, 0, 0, 20, 599, $accent_color); // Izquierda
    imagefilledrectangle($image, 780, 0, 799, 599, $accent_color); // Derecha

    // Cargar una fuente TrueType (asegúrate de que esta ruta sea correcta)
    $font = './path/to/your/font.ttf'; // Cambia esto a la ruta de tu fuente

    // Agregar texto al certificado
    imagettftext($image, 40, 0, 250, 100, $text_color, $font, "Certificado de Logro");
    imagettftext($image, 30, 0, 200, 200, $text_color, $font, "Este certificado se otorga a:");
    imagettftext($image, 40, 0, 250, 300, $accent_color, $font, $name);
    imagettftext($image, 25, 0, 150, 400, $text_color, $font, "Por completar exitosamente el Quiz de 6to Grado");
    imagettftext($image, 20, 0, 250, 450, $text_color, $font, "Puntaje obtenido: $score / $total_questions");

    // Agregar la fecha actual
    $date = date("d/m/Y");
    imagettftext($image, 20, 0, 300, 520, $text_color, $font, "Fecha: $date");

    // Agregar algunas formas divertidas
    // Estrella en la esquina superior izquierda
    $points = array(50,25, 60,50, 85,50, 65,70, 75,95, 50,80, 25,95, 35,70, 15,50, 40,50);
    imagefilledpolygon($image, $points, 10, $accent_color);

    // Círculo en la esquina superior derecha
    imagefilledellipse($image, 750, 50, 60, 60, $accent_color);

    // Triángulo en la esquina inferior izquierda
    $triangle = array(25,550, 75,550, 50,500);
    imagefilledpolygon($image, $triangle, 3, $accent_color);

    // Rectángulo en la esquina inferior derecha
    imagefilledrectangle($image, 725, 525, 775, 575, $accent_color);

    // Enviar la imagen al navegador
    header("Content-type: image/png");
    imagepng($image);

    // Liberar memoria
    imagedestroy($image);
}

// Uso de la función
if (isset($_POST['name']) && isset($_POST['score'])) {
    $name = $_POST['name'];
    $score = $_POST['score'];
    $total_questions = 15; // Asumiendo que son 15 preguntas en total
    generateCertificate($name, $score, $total_questions);
} else {
    echo "Por favor, proporciona un nombre y un puntaje.";
}
?>