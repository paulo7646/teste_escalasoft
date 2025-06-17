<?php 

require_once 'ICaixaNotificacao.php';

class LogNotificacao implements ICaixaNotificacao
{
    private string $arquivo;

    public function __construct(string $arquivo = 'log.txt')
    {
        $diretorio = __DIR__ . '/logs';

        // Verifica se a pasta logs existe, se não, cria
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        // Define o caminho completo do arquivo
        $this->arquivo = $diretorio . '/' . $arquivo;
    }

    public function enviarNotificacao(string $mensagem): void
    {
        $dataHora = date('[d/m/Y H:i:s]');
        file_put_contents($this->arquivo, "{$dataHora} {$mensagem}\n", FILE_APPEND);
    }
}
