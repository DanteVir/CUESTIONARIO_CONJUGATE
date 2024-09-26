<?php
session_start();

$questions = [
    1 => ['question' => '¿Cuál es el sinónimo de "big"?', 'answers' => ['a' => 'Small', 'b' => 'Huge', 'c' => 'Tiny', 'd' => 'Short'], 'correct' => 'b'],
    2 => ['question' => 'Elige la opción correcta: "She (___) to school every day."', 'answers' => ['a' => 'go', 'b' => 'goes', 'c' => 'going', 'd' => 'gone'], 'correct' => 'b'],
    3 => ['question' => 'After reading the passage, what is the main theme of the text?', 'answers' => ['a' => 'Los deportes', 'b' => 'La amistad', 'c' => 'El juego en el parque', 'd' => 'La escuela'], 'correct' => 'c'],
    4 => ['question' => '¿Cuál es la forma correcta de escribir la palabra?', 'answers' => ['a' => 'Beatiful', 'b' => 'Beutiful', 'c' => 'Beautifull', 'd' => 'Beautiful'], 'correct' => 'd'],
    5 => ['question' => 'Completa la oración: "Yesterday, they (___) soccer."', 'answers' => ['a' => 'play', 'b' => 'playing', 'c' => 'played', 'd' => 'plays'], 'correct' => 'c'],
    6 => ['question' => '¿Cuál es el pronombre correcto para reemplazar "Maria y Juan"?', 'answers' => ['a' => 'He', 'b' => 'She', 'c' => 'They', 'd' => 'It'], 'correct' => 'c'],
    7 => ['question' => '¿Cuál es la contracción de "they are"?', 'answers' => ['a' => 'they\'re', 'b' => 'theyre', 'c' => 'their', 'd' => 'there'], 'correct' => 'a'],
    8 => ['question' => 'Completa la oración: "The cat is (___) the table."', 'answers' => ['a' => 'on', 'b' => 'in', 'c' => 'between', 'd' => 'under'], 'correct' => 'a'],
    9 => ['question' => '¿Cuál es el adjetivo en la oración: "The small dog barked loudly"?', 'answers' => ['a' => 'Dog', 'b' => 'Small', 'c' => 'Barked', 'd' => 'Loudly'], 'correct' => 'b'],
    10 => ['question' => '¿Cuál es un sinónimo de "happy"?', 'answers' => ['a' => 'Sad', 'b' => 'Joyful', 'c' => 'Angry', 'd' => 'Tired'], 'correct' => 'b'],
    11 => ['question' => 'Elige la opción correcta: "(___) you going to the store?"', 'answers' => ['a' => 'Are', 'b' => 'Is', 'c' => 'Do', 'd' => 'Does'], 'correct' => 'a'],
    12 => ['question' => '¿Cuál es el pasado del verbo "to eat"?', 'answers' => ['a' => 'Eats', 'b' => 'Ate', 'c' => 'Eating', 'd' => 'Eat'], 'correct' => 'b'],
    13 => ['question' => 'Elige la opción correcta: "The dogs (___) fast."', 'answers' => ['a' => 'run', 'b' => 'runs', 'c' => 'running', 'd' => 'runned'], 'correct' => 'a'],
    14 => ['question' => '¿Cuál es la forma comparativa de "tall"?', 'answers' => ['a' => 'Tall', 'b' => 'Taller', 'c' => 'Tallest', 'd' => 'Most tall'], 'correct' => 'b'],
    15 => ['question' => '¿Cuál es el antónimo de "cold"?', 'answers' => ['a' => 'Hot', 'b' => 'Cool', 'c' => 'Warm', 'd' => 'Freezing'], 'correct' => 'a'],
];

$message = '';
$score = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quiz'])) {
    $student_name = htmlspecialchars($_POST['student_name']);
    foreach ($_POST as $question => $answer) {
        if (isset($questions[intval($question)]) && $questions[intval($question)]['correct'] === $answer) {
            $score++;
        }
    }
    
    $percentage = ($score / count($questions)) * 100;
    
    if ($percentage > 90) {
        $message = "<div class='success'>¡Felicidades, $student_name! Has completado más del 90% correctamente.</div>";
        $_SESSION['certificate_data'] = [
            'name' => $student_name,
            'score' => $score,
            'total_questions' => count($questions)
        ];
        $message .= "<a href='generate_certificate.php' target='_blank' class='btn btn-primary'>Ver y Descargar Certificado</a>";
    } else {
        $message = "<div class='error'>Has completado $percentage% correctamente. Necesitas más del 90% para obtener el certificado.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz 6to Grado</title>
    <link rel="stylesheet" href="quiz-styles.css">
</head>
<body>
    <div class="container">
        <h1>Quiz 6to Grado</h1>
        
        <?php echo $message; ?>
        
        <form method="post" action="">
            <div class="form-group">
                <label for="student_name">Tu nombre:</label>
                <input type="text" id="student_name" name="student_name" required>
            </div>

            <?php foreach ($questions as $id => $q): ?>
                <div class="question">
                    <p><?php echo $id; ?>. <?php echo $q['question']; ?></p>
                    <div class="answers">
                        <?php foreach ($q['answers'] as $letter => $answer): ?>
                            <div class="answer">
                                <input type="radio" id="q<?php echo $id; ?>_<?php echo $letter; ?>" name="<?php echo $id; ?>" value="<?php echo $letter; ?>" required>
                                <label for="q<?php echo $id; ?>_<?php echo $letter; ?>"><?php echo $letter; ?>) <?php echo $answer; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <input type="submit" name="submit_quiz" value="Enviar respuestas">
        </form>
    </div>
</body>
</html>