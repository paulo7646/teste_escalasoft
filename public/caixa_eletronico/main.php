<?php

require_once 'Caixa.php';
require_once 'LogNotificacao.php';

// Criar caixa e registrar logger
$caixa = new Caixa();
$logger = new LogNotificacao();
$caixa->registrarNotificador($logger);

// Simulações
echo "=== Depósito Inicial ===\n";
$caixa->depositar([
    200 => 2,
    100 => 1,
    50  => 3,
    10  => 5,
]);

echo "\n=== Estoque Atual ===\n";
foreach ($caixa->consultarEstoque() as $valor => $qtde) {
    echo "R\${$valor}: {$qtde}x\n";
}

echo "\n=== Total no Caixa ===\n";
echo "Total: R$" . $caixa->consultarTotal() . "\n";

echo "\n=== Saque R\$380 ===\n";
$caixa->sacar(380);

echo "\n=== Saque R\$120 (Erro esperado) ===\n";
$caixa->sacar(120);
