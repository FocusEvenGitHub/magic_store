# Magic Store
Magic Store é um sistema simples de gerenciamento de e-commerce construído com PHP usando a arquitetura MVC e MySQL como banco de dados. O projeto suporta gerenciamento de clientes, processamento de pedidos e registro de e-mails.

## Tecnologias Utilizadas

- **PHP 7+**
- **MySQL**
- **Docker**
- **HTML, CSS, JavaScript and jQuery**
- **Composer** 
- **PHPMailer** 
- **PHPSpreadsheet** 
- **PHP Dotenv** 
- **Docker & Docker Compose** (para facilitar a configuração do ambiente)



## 📦 Dependências

As principais bibliotecas utilizadas são:

| Pacote                         | Descrição |
|--------------------------------|-----------|
| `phpoffice/phpspreadsheet`     | Manipulação de planilhas Excel e CSV |
| `phpmailer/phpmailer`          | Envio de e-mails via SMTP |
| `vlucas/phpdotenv`             | Gerenciamento de variáveis de ambiente |

Dependências adicionais instaladas automaticamente pelo Composer:
- `ezyang/htmlpurifier` - Filtragem segura de HTML
- `psr/http-message` - Padrão PSR para mensagens HTTP
- `symfony/polyfill-*` - Backports de funcionalidades para versões mais antigas do PHP

##  Como Rodar o Projeto

### 1️⃣ Pré-requisitos


- **Docker** e **Docker Compose** instalados.

### 2️⃣ Instalação

Clone o repositório e instale as dependências:

```sh
git clone https://github.com/seu-usuario/magic_store.git
cd magic_store
```
### 3️⃣ Configuração do Ambiente
Crie um arquivo `.env` na raiz do projeto e configure suas credenciais:
```sh
cp .env.example .env
```
Edite o arquivo .env e configure os valores necessários, como credenciais de e-mail e banco de dados.

###  4️⃣ Rodando os containers
Execute o comando abaixo para subir o ambiente:
```sh
docker-compose up -d
```
Isso irá rodar os contêineres com PHP, Apache e MySQL. O Composer será executado automaticamente dentro do contêiner para instalar as dependências.


### 5️⃣ Rodar as Migrations
Acesse o contêiner web
```sh
docker-compose exec web bash
```
Dentro do contênier, execute as migrations:
```bash
php /var/www/html/database/migration.php
```

## Acessando o projeto
Agora, basta acessar no navegador:
```
http://localhost:8000
```

---
#### ➡️ Extras

Caso precise entrar no container para executar comandos PHP:
```sh
docker exec -it magic_store_app bash
```
Dentro do container, você pode rodar comandos como:
```sh
composer install
php -S localhost:8000 -t public
```

## Estrutura do projeto

MAGIC_STORE/<br>
│── app/<br>
│   ├── controllers/            --- Controladores do sistema<br>
│   ├── models/                 --- Modelos do sistema<br>
│   ├── views/                  --- Arquivos de visualização (frontend)<br>
│   ├── services/               --- Arquivos da regra de negócios<br>
├── config/                     --- Configuração do sistema<br>
├── database/                   --- Arquivos relacionados ao banco de dados<br>
├── public/                      --- Arquivos públicos acessíveis pela aplicação<br>
│   ├── assets/                  --- Arquivos .css como tambem .js<br>
│   ├── index.php                     --- Arquivo de entrada principal do sistema<br>
├── utils/                       --- Utilitários da aplicação<br>
├── vendor/                      --- Dependências gerenciadas pelo Composer<br>
├── .env                         --- Arquivo de variáveis de ambiente<br>
├── .env.example                 --- Exemplo de configuração do ambiente<br>
├── .gitignore                    --- Arquivo de exclusões do Git<br>
├── composer.json                 --- Dependências do Composer<br>
├── composer.lock                 --- Arquivo de bloqueio do Composer<br>
├── docker-compose.yml            --- Configuração do Docker Compose<br>
├── Dockerfile                    --- Arquivo Docker<br>
├── readme.md                     --- Documentação do projeto<br>
