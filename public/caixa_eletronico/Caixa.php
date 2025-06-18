<?php

require_once 'LogNotificacao.php';

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

    private function notificar(string $mensagem): void
    {
        $notificador = new LogNotificacao();
        $notificador->enviarNotificacao($mensagem);
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

    public function depositar(array $cedulas): array
    {
        $total = 0;
        $mensagem = "";

        foreach ($cedulas as $valor => $quantidade) {
            if (!in_array($valor, $this->denominacoes)) continue;
            $total += $quantidade;
        }

        if ($total === 0) {
            $mensagem = "Erro no depósito: Nenhuma cédula válida foi informada.";
            $this->notificar($mensagem);

            return [
                'sucesso' => false,
                'mensagem' => $mensagem
            ];
        }

        $mensagem = "Depósito realizado:";
        foreach ($cedulas as $valor => $quantidade) {
            if (!in_array($valor, $this->denominacoes)) continue;
            $this->estoque[$valor] += $quantidade;
            $mensagem .= " {$quantidade}x R\${$valor},";
        }

        $mensagem = rtrim($mensagem, ',');
        $this->notificar($mensagem);

        return [
            'sucesso' => true,
            'mensagem' => $mensagem
        ];
    }

    public function sacar(int $valor): array
    {
        if ($valor < min($this->denominacoes)) {
            return [
                'sucesso' => false,
                'mensagem' => "Erro: valor mínimo para saque é R\$" . min($this->denominacoes)
            ];
        }

        $originalValor = $valor;
        $resultado = $this->montarSaque($valor, $this->estoque);

        if ($resultado) {
            foreach ($resultado as $cedula => $qtde) {
                $this->estoque[$cedula] -= $qtde;
            }

            $mensagem = "Saque de R\${$originalValor} realizado com sucesso.";
            $detalhes = [];

            foreach ($resultado as $cedula => $qtde) {
                $detalhes[] = "{$qtde}x R\${$cedula}";
            }

            $this->notificar($mensagem . ' ' . implode(', ', $detalhes));

            return [
                'sucesso' => true,
                'mensagem' => $mensagem,
                'detalhes' => $detalhes
            ];
        } else {
            $mensagem = "Erro no saque: Não foi possível montar R\${$originalValor} com as cédulas disponíveis";
            $this->notificar($mensagem);

            $resposta = [
                'sucesso' => false,
                'mensagem' => $mensagem
            ];

            $sugestao = $this->sugerirSaqueMaximo($originalValor);
            if ($sugestao > 0) {
                $resposta['sugestao'] = "Você pode sacar até R\${$sugestao}";
            } else {
                $resposta['sugestao'] = "Nenhum valor disponível para saque com as cédulas existentes.";
            }

            return $resposta;
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
