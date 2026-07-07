<?php

require_once "../config/conexao.php"; // ajuste o caminho se necessário

$materia = $_POST['materia'] ?? '';
$nivel   = $_POST['nivel'] ?? '';
$assunto = $_POST['assunto'] ?? '';

$sql = "SELECT *
        FROM tb_questoes
        WHERE LOWER(materia) = LOWER(?)
        AND LOWER(nivel) = LOWER(?)
        AND LOWER(assunto) = LOWER(?)
        ORDER BY RAND()
        LIMIT 10";

$stmt = $pdo->prepare($sql);
$stmt->execute([$materia, $nivel, $assunto]);

$questoes = $stmt->fetchAll();

if (count($questoes) == 0) {
    die("<h2>Nenhuma questão encontrada para este assunto.</h2>");
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Quiz</title>

<style>

body{
    font-family:Arial,Helvetica,sans-serif;
    max-width:900px;
    margin:auto;
    padding:30px;
    background:#f5f5f5;
}

.caixa{
    background:white;
    padding:20px;
    margin-bottom:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.1);
}

button{

    background:#2563eb;
    color:white;
    border:none;
    padding:15px 30px;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;

}

button:hover{

    background:#1d4ed8;

}

</style>

</head>

<body>

<h1>📚 Quiz</h1>

<form action="corrigir_quiz.php" method="POST">

<?php foreach($questoes as $i => $q): ?>

<div class="caixa">

<h3>Questão <?= $i+1 ?></h3>

<p><?= htmlspecialchars($q['pergunta']) ?></p>

<input
type="hidden"
name="gabarito_<?= $i ?>"
value="<?= $q['resposta_correta'] ?>"
>

<label>

<input
type="radio"
name="q<?= $i ?>"
value="A"
required

>

A) <?= htmlspecialchars($q['alternativa_a']) ?>

</label>

<br><br>

<label>

<input
type="radio"
name="q<?= $i ?>"
value="B"

>

B) <?= htmlspecialchars($q['alternativa_b']) ?>

</label>

<br><br>

<label>

<input
type="radio"
name="q<?= $i ?>"
value="C"

>

C) <?= htmlspecialchars($q['alternativa_c']) ?>

</label>

<br><br>

<label>

<input
type="radio"
name="q<?= $i ?>"
value="D"

>

D) <?= htmlspecialchars($q['alternativa_d']) ?>

</label>

</div>

<?php endforeach; ?>

<button type="submit">

Finalizar Quiz

</button>

</form>

</body>
</html>