<?php

require_once 'ICaixaNotificacao.php';

class Caixa
{
    private array $estoque = [];
    private array $denominacoes = [200, 100, 50, 20, 10, 5, 2];
    private array $notificadores = [];

    public function __construct()
    {
        foreach ($this->denominacoes as $valor) {
            $this->estoque[$valor] = 0;
        }
    }

    public function registrarNotificador(ICaixaNotificacao $notificador): void
    {
        $this->notificadores[] = $notificador;
    }

    private function notificar(string $mensagem): void
    {
        foreach ($this->notificadores as $notificador) {
            $notificador->enviarNotificacao($mensagem);
        }
    }

    public function consultarTotal(): int
    {
        $total = 0;
        foreach ($this->estoque as $valor => $quantidade) {
            $total += $valor * $quantidade;
        }
        return $total;
    }

    public function consultarEstoque(): array
    {
        return $this->estoque;
    }

    public function depositar(array $cedulas): void
    {
        $mensagem = "Depósito realizado:";
        foreach ($cedulas as $valor => $quantidade) {
            if (!in_array($valor, $this->denominacoes)) continue;
            $this->estoque[$valor] += $quantidade;
            $mensagem .= " {$quantidade}x R\${$valor},";
        }
        $mensagem = rtrim($mensagem, ',');
        $this->notificar($mensagem);
    }

    public function sacar(int $valor): void
    {
        if ($valor < min($this->denominacoes)) {
            echo "Erro: valor mínimo para saque é R\$" . min($this->denominacoes) . "\n";
            return;
        }

        $originalValor = $valor;
        $resultado = $this->montarSaque($valor, $this->estoque);

        if ($resultado) {
            foreach ($resultado as $cedula => $qtde) {
                $this->estoque[$cedula] -= $qtde;
            }

            $mensagem = "Saque realizado: R\${$originalValor}";
            $this->notificar($mensagem);

            echo "Saque de R\${$originalValor} realizado com sucesso:\n";
            foreach ($resultado as $cedula => $qtde) {
                echo "- {$qtde}x R\${$cedula}\n";
            }
        } else {
            $mensagem = "Erro no saque: Não foi possível montar R\${$originalValor} com as cédulas disponíveis";
            $this->notificar($mensagem);

            echo $mensagem . "\n";

            $sugestao = $this->sugerirSaqueMaximo($originalValor);
            if ($sugestao > 0) {
                echo "Sugestão: você pode sacar até R\${$sugestao}\n";
            } else {
                echo "Nenhum valor disponível para saque com as cédulas existentes.\n";
            }
        }
    }

    private function montarSaque(int $valor, array $estoqueBase): array|null
    {
        $resultado = [];

        foreach ($this->denominacoes as $cedula) {
            $disponivel = $estoqueBase[$cedula];
            $necessario = intdiv($valor, $cedula);
            $usar = min($necessario, $disponivel);

            if ($usar > 0) {
                $resultado[$cedula] = $usar;
                $valor -= $usar * $cedula;
            }
        }

        return $valor === 0 ? $resultado : null;
    }

    private function sugerirSaqueMaximo(int $valorDesejado): int
    {
        for ($valor = $valorDesejado - 1; $valor >= min($this->denominacoes); $valor--) {
            if ($this->montarSaque($valor, $this->estoque)) {
                return $valor;
            }
        }
        return 0;
    }
}
