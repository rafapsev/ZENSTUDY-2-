<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../dao/AgendaDAO.php';

$agendaDAO = new AgendaDAO();

// Salva um evento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['id_cadastro'])) {
        redirecionar('/views/login.php');
        exit;
    }

    $id_cadastro = $_SESSION['id_cadastro'];
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $data = $_POST['dt_data'];
    $horario = $_POST['horario'];
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
    $cor = $_POST['cor'];

    if ($titulo && $data && $horario) {
        $agendaDAO->salvarEvento($id_cadastro, $titulo, $data, $horario, $descricao, $cor);
        flash('Evento adicionado com sucesso!', 'sucesso');
    } else {
        flash('Preencha os campos obrigatórios.', 'erro');
    }

    redirecionar('/views/ferramentas/calendario.php');
    exit;
}

// Retorna os eventos em JSON para o FullCalendar
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['api'])) {

    header('Content-Type: application/json');

    if (!isset($_SESSION['id_cadastro'])) {
        echo json_encode([]);
        exit;
    }

    $eventos = $agendaDAO->buscarEventosPorUsuario($_SESSION['id_cadastro']);

    echo "<pre>";
    print_r($eventos);
    exit;
}