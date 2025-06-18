<?php
require_once './public/caixa_eletronico/Caixa.php';
session_start();

if (!isset($_SESSION['caixa'])) {
    $_SESSION['caixa'] = new Caixa();
}
$caixa = $_SESSION['caixa'];
$response = $caixa->consultarEstoque();
echo json_encode($response);
