# teste EscalaSoft

## 🚀 Começando

Essas instruções permitirão que você obtenha uma cópia do projeto em operação na sua máquina local para fins de desenvolvimento e teste.

### 📋 Pré-requisitos

instale o pnpm de forma global :

```
npm install -g pnpm
```

instale o php 8.4.5 ou maior  :

```
Como instalar PHP no Windows
1. Baixar o PHP
Acesse o site oficial: https://windows.php.net/download/

Escolha a versão Thread Safe (geralmente a última versão estável, por ex: PHP 8.x)

Baixe o arquivo ZIP (não o instalador)

2. Extrair os arquivos
Extraia o conteúdo do ZIP para uma pasta, por exemplo:
C:\php

3. Configurar a variável de ambiente PATH
No Windows, pesquise por Variáveis de Ambiente e abra a configuração

Em Variáveis do sistema, encontre a variável Path e clique em editar

Adicione o caminho da pasta PHP, por exemplo:
C:\php

Salve tudo e feche

4. Testar a instalação
Abra o Prompt de Comando (cmd)

Digite:

bash
Copiar
Editar
php -v
Deve aparecer a versão do PHP instalada

5. (Opcional) Configurar o arquivo php.ini
Dentro da pasta do PHP, copie o arquivo php.ini-development e renomeie para php.ini

Edite esse arquivo para habilitar extensões ou configurações que precisar (ex: extension=mysqli, date.timezone = "America/Sao_Paulo")
```

### 🔧 Instalação

clone o repositorio usando :

```
git clone https://github.com/paulo7646/teste_escalasoft.git
```

instale as dependencias do sistema usando :

```
pnpm install
```

execute o comando :

```
pnpm run dev:full
```

## 🛠️ Construído com

* [Vue3] - Usada para suprir o Front-end
* [Vutify] - O plugin usado para suprir o Front-end
* [Pnpm] - Gerente de Dependência
* [PHP] - Usada para suprir o Back-end

---
⌨️ com ❤️ por [Paulo Henrique](https://gist.github.com/7646) 😊
