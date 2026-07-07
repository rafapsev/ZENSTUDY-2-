<?php

$acertos = 0;
$total = 0;

echo "<!DOCTYPE html>";
echo "<html lang='pt-br'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Resultado do Quiz</title>";

echo "<style>

body{
    font-family:Arial,Helvetica,sans-serif;
    background:#f5f5f5;
    max-width:900px;
    margin:auto;
    padding:30px;
}

.caixa{
    background:white;
    padding:20px;
    margin-bottom:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.1);
}

.correta{
    color:green;
    font-weight:bold;
}

.errada{
    color:red;
    font-weight:bold;
}

.resultado{
    background:#2563eb;
    color:white;
    padding:20px;
    border-radius:10px;
    text-align:center;
    margin-top:30px;
}

a{
    text-decoration:none;
    color:white;
}

</style>";

echo "</head>";
echo "<body>";

echo "<h1>📚 Resultado do Quiz</h1>";

foreach ($_POST as $campo => $valor){

    if(strpos($campo,"q") !== 0){
        continue;
    }

    $numero = str_replace("q","",$campo);

    $gabarito = $_POST["gabarito_$numero"] ?? "";

    $total++;

    echo "<div class='caixa'>";

    echo "<h3>Questão ".($numero+1)."</h3>";

    echo "<p><strong>Sua resposta:</strong> ".$valor."</p>";

    echo "<p><strong>Resposta correta:</strong> ".$gabarito."</p>";

    if(strtoupper(trim($valor)) == strtoupper(trim($gabarito))){

        echo "<p class='correta'>✅ Correta</p>";

        $acertos++;

    }else{

        echo "<p class='errada'>❌ Incorreta</p>";

    }

    echo "</div>";

}

$percentual = 0;

if($total>0){

    $percentual = ($acertos/$total)*100;

}

echo "<div class='resultado'>";

echo "<h2>Acertos: $acertos / $total</h2>";

echo "<h2>Nota: ".number_format($percentual,1)." %</h2>";

echo "<br>";

echo "<a href='quiz.php'>⬅ Fazer outro Quiz</a>";

echo "</div>";

echo "</body>";
echo "</html>";

?>