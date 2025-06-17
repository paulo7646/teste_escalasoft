<?php
require_once './public/caixa_eletronico/Caixa.php';
require_once './public/caixa_eletronico/LogNotificacao.php';
session_start();

if (!isset($_SESSION['caixa'])) {
    $_SESSION['caixa'] = new Caixa();
    $_SESSION['caixa']->registrarNotificador(new LogNotificacao());
}
$caixa = $_SESSION['caixa'];

$data = json_decode(file_get_contents('php://input'), true);
$caixa->depositar($data);
echo json_encode(['sucesso' => true]);
