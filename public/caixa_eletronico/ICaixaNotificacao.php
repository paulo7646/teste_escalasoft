<?php

interface ICaixaNotificacao
{
    public function enviarNotificacao(string $mensagem): void;
}
