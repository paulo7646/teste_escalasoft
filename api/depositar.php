<?php
require_once './public/caixa_eletronico/Caixa.php';
require_once './public/caixa_eletronico/LogNotificacao.php';
session_start();

if (!isset($_SESSION['caixa'])) {
    $_SESSION['caixa'] = new Caixa();
}
$caixa = $_SESSION['caixa'];

$data = json_decode(file_get_contents('php://input'), true);
$response = $caixa->depositar($data);
echo json_encode($response);
