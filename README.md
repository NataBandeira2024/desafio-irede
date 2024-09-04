# Projeto Laravel + Vue.js com Docker

Este projeto é um sistema CRUD desenvolvido com Laravel no backend e Vue.js no frontend. Ele utiliza Docker para simplificar a configuração do ambiente, garantindo que todas as dependências e configurações necessárias estejam isoladas e prontas para uso.

## Tecnologias Utilizadas

-   **Laravel 9.x** - Backend PHP Framework
-   **Vue.js 3.x** - Frontend JavaScript Framework
-   **MySQL 8.0** - Banco de Dados Relacional
-   **Docker** - Containerização para ambiente de desenvolvimento
-   **PHP 8.1** - Linguagem de Programação para o backend
-   **Node.js 18.x e NPM** - Gerenciamento de pacotes para o frontend

## Funcionalidades

-   **CRUD de Produtos**
    -   Nome (Máximo de 50 caracteres)
    -   Descrição (Máximo de 200 caracteres)
    -   Preço (Valor positivo, double)
    -   Data de validade (Não pode ser anterior à data atual)
    -   Imagem (upload com nome único do arquivo)
-   **Relacionamento com Categorias**
-   **Autenticação JWT** para proteger as rotas
-   **Paginação e busca** na listagem de produtos
-   **Edição e exclusão** de produtos

## Pré-requisitos

Certifique-se de ter os seguintes softwares instalados em seu sistema:

-   Docker: [Instalação do Docker](https://docs.docker.com/get-docker/)
-   Docker Compose: [Instalação do Docker Compose](https://docs.docker.com/compose/install/)

## Passo a Passo para Configuração

### 1. Clonar o Repositório

Clone o repositório do projeto no seu ambiente de desenvolvimento:

```bash
git clone git@github.com:NataBandeira2024/desafio-irede.git
cd desafio-irede
```

### 2. Configurar Variáveis de Ambiente

Clone o repositório do projeto no seu ambiente de desenvolvimento:

```bash
cp .env.example .env

```

Configure as seguintes variáveis no arquivo .env:

```bash
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=root
```

### 3. Subir os Contêineres com Docker

Construa e inicie os contêineres:

```bash
docker-compose up -d --build
```

Execute o comando para criar as tabelas de banco de dados:

```bash
docker-compose exec backend php artisan migrate
```

Execute o comando para pupular a tabela de categoria:

```bash
docker-compose exec backend php artisan db:seed
```
