# RecipeHub - Sistema de Gerenciamento de Receitas

Sistema completo para gerenciamento de receitas culinárias desenvolvido com Laravel 12, Vue.js 3 e MySQL.

![Sistema RecipeHub](https://iili.io/KLzxCGe.png)

## 📋 Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Tecnologias](#tecnologias)
- [Funcionalidades](#funcionalidades)
- [Pré-requisitos](#pré-requisitos)
- [Instalação e Execução](#instalação-e-execução)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [API e Documentação](#api-e-documentação)
- [Arquitetura](#arquitetura)

## 🎯 Sobre o Projeto

RecipeHub é uma aplicação web moderna e intuitiva para gerenciar receitas culinárias. O sistema oferece uma interface elegante e profissional, permitindo que usuários organizem, busquem e compartilhem suas receitas favoritas de forma eficiente.

### Principais Características

- Autenticação segura com Laravel Sanctum
- Interface responsiva e moderna com Vue.js 3
- API RESTful documentada com Swagger/OpenAPI
- Busca avançada por nome, ingredientes e modo de preparo
- Organização por categorias
- Impressão otimizada de receitas
- Design profissional sem emojis, com ícones Lucide

## 🚀 Tecnologias

### Backend
- **Laravel 12** - Framework PHP moderno
- **PHP 8.2** - Linguagem de programação
- **MySQL 8.0** - Banco de dados relacional
- **Laravel Sanctum** - Autenticação de API
- **L5-Swagger** - Documentação OpenAPI

### Frontend
- **Vue.js 3** - Framework JavaScript progressivo
- **Vue Router 4** - Roteamento SPA
- **Pinia** - Gerenciamento de estado
- **Axios** - Cliente HTTP
- **Tailwind CSS 4** - Framework CSS utility-first
- **Lucide Icons** - Biblioteca de ícones moderna
- **Vite** - Build tool e dev server

### DevOps
- **Docker** - Containerização
- **Docker Compose** - Orquestração de containers
- **Nginx** - Servidor web
- **Supervisor** - Gerenciador de processos

## ✨ Funcionalidades

- [x] Cadastro e autenticação de usuários
- [x] CRUD completo de receitas
- [x] Categorização de receitas
- [x] Busca inteligente e filtros
- [x] Visualização detalhada com tempo e porções
- [x] Edição inline de receitas
- [x] Impressão formatada
- [x] API RESTful completa
- [x] Documentação Swagger interativa
- [x] Interface responsiva
- [x] Sistema de tokens JWT

## 📦 Pré-requisitos

Para executar este projeto você precisa apenas de:

- [Docker](https://www.docker.com/get-started) (versão 20.10 ou superior)
- [Docker Compose](https://docs.docker.com/compose/install/) (versão 2.0 ou superior)

**Nenhuma outra dependência é necessária!** O Docker cuidará de todo o ambiente (PHP, MySQL, Nginx, Node.js, etc.).

## 🔧 Instalação e Execução

O projeto é executado inteiramente via Docker. Todo o ambiente é configurado automaticamente, sem necessidade de instalar dependências manualmente.

> **💡 Nota**: Mesmo se você nunca usou Docker, basta ter ele instalado e seguir os passos abaixo. Tudo funcionará automaticamente!

### 1. Clone o repositório

```bash
git clone https://github.com/TheVinizzz/receitas
cd recipe-management-system
```

### 2. Execute o projeto

```bash
docker-compose up -d --build
```

**Pronto!** Aguarde aproximadamente 2-3 minutos para a inicialização completa. 

O sistema já vem totalmente pré-configurado:
- ✅ Arquivo `.env` já incluído e configurado
- ✅ Chave da aplicação já gerada
- ✅ Aguarda o MySQL estar pronto (healthcheck)
- ✅ Executa as migrations do banco de dados
- ✅ Popula as categorias iniciais (Sobremesas, Massas, Carnes, etc.)
- ✅ Gera a documentação Swagger automaticamente
- ✅ Compila os assets do frontend (Vue.js + Tailwind)
- ✅ Inicia o Nginx e PHP-FPM

**Zero configuração necessária! Apenas execute e use.**

### 3. Acesse a aplicação

- **Frontend**: http://localhost:8000
- **API Swagger**: http://localhost:8000/api/documentation
- **PHPMyAdmin**: http://localhost:8080 (usuário: `root`, senha: `root`)

### 4. Comandos úteis

```bash
# Ver logs em tempo real
docker-compose logs -f app

# Parar os containers
docker-compose down

# Parar e remover volumes (limpa o banco)
docker-compose down -v

# Acessar o container da aplicação
docker-compose exec app bash

# Executar comandos artisan
docker-compose exec app php artisan [comando]

# Resetar banco de dados
docker-compose exec app php artisan migrate:fresh --seed
```

## 📁 Estrutura do Projeto

```
recipe-management-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── AuthController.php      # Autenticação
│   │   │   │   ├── ReceitaController.php   # CRUD de receitas
│   │   │   │   └── CategoriaController.php # Categorias
│   │   │   └── Controller.php              # Base controller com annotations Swagger
│   │   └── Middleware/
│   └── Models/
│       ├── User.php                         # Model de usuário
│       ├── Receita.php                      # Model de receita
│       └── Categoria.php                    # Model de categoria
├── database/
│   ├── migrations/                          # Migrations do banco
│   └── seeders/
│       └── DatabaseSeeder.php               # Seeder de categorias
├── resources/
│   ├── js/
│   │   ├── components/
│   │   │   ├── App.vue                      # Componente raiz
│   │   │   ├── NavBar.vue                   # Barra de navegação
│   │   │   └── pages/
│   │   │       ├── Home.vue                 # Página inicial
│   │   │       ├── Login.vue                # Login
│   │   │       ├── Register.vue             # Cadastro
│   │   │       ├── RecipeList.vue           # Lista de receitas
│   │   │       ├── RecipeCreate.vue         # Criar receita
│   │   │       ├── RecipeEdit.vue           # Editar receita
│   │   │       └── RecipeView.vue           # Visualizar receita
│   │   ├── stores/
│   │   │   └── auth.js                      # Store Pinia de autenticação
│   │   ├── app.js                           # Entry point Vue
│   │   ├── bootstrap.js                     # Configuração Axios
│   │   └── routes.js                        # Rotas do Vue Router
│   ├── css/
│   │   └── app.css                          # Estilos Tailwind
│   └── views/
│       └── app.blade.php                    # Template principal
├── routes/
│   ├── api.php                              # Rotas da API
│   └── web.php                              # Rotas web (SPA)
├── docker/
│   ├── nginx.conf                           # Configuração Nginx
│   ├── supervisord.conf                     # Configuração Supervisor
│   └── php.ini                              # Configuração PHP
├── docker-compose.yml                       # Orquestração Docker
├── Dockerfile                               # Imagem Docker da aplicação
└── package.json                             # Dependências Node.js
```

## 📚 API e Documentação

### Endpoints Principais

#### Autenticação
- `POST /api/register` - Registrar novo usuário
- `POST /api/login` - Autenticar usuário
- `POST /api/logout` - Deslogar usuário (requer autenticação)
- `GET /api/user` - Obter dados do usuário autenticado

#### Receitas (requer autenticação)
- `GET /api/receitas` - Listar receitas do usuário
- `POST /api/receitas` - Criar nova receita
- `GET /api/receitas/{id}` - Obter receita específica
- `PUT /api/receitas/{id}` - Atualizar receita
- `DELETE /api/receitas/{id}` - Deletar receita
- `GET /api/receitas/search/{term}` - Buscar receitas
- `GET /api/receitas/{id}/print` - Imprimir receita

#### Categorias (público)
- `GET /api/categorias` - Listar todas as categorias
- `GET /api/categorias/{id}` - Obter categoria específica

### Documentação Interativa

Acesse a documentação Swagger completa em:
```
http://localhost:8000/api/documentation
```

A documentação inclui:
- Descrição detalhada de todos os endpoints
- Schemas de request e response
- Exemplos de uso
- Possibilidade de testar diretamente na interface

## 🏗 Arquitetura

### Backend

O backend segue o padrão **MVC** do Laravel com as seguintes camadas:

- **Models**: Representação das entidades do banco de dados
- **Controllers**: Lógica de negócio e manipulação de requisições
- **Middleware**: Autenticação e validação de requisições
- **Migrations**: Versionamento do schema do banco de dados
- **Seeders**: População inicial de dados

#### Autenticação

Utiliza **Laravel Sanctum** para autenticação baseada em tokens:
- Token gerado no login/registro
- Enviado no header `Authorization: Bearer {token}`
- Validado pelo middleware `auth:sanctum`

#### Banco de Dados

Estrutura relacional:
- **users**: Usuários do sistema
- **categorias**: Categorias de receitas
- **receitas**: Receitas cadastradas (FK para users e categorias)

### Frontend

O frontend é uma **SPA (Single Page Application)** Vue.js 3 com:

- **Vue Router**: Navegação entre páginas sem reload
- **Pinia**: Gerenciamento de estado centralizado
- **Composition API**: Padrão moderno de componentes Vue
- **Axios**: Requisições HTTP com interceptors para autenticação

#### Fluxo de Autenticação

1. Usuário faz login
2. Token é armazenado no localStorage
3. Axios interceptor adiciona token em todas as requisições
4. Store Pinia mantém estado de autenticação
5. Router guards protegem rotas privadas

### DevOps

#### Docker

A aplicação roda em containers Docker:

- **app**: Laravel + Nginx + PHP-FPM + Node.js (build do frontend)
- **mysql**: Banco de dados MySQL 8.0
- **phpmyadmin**: Interface web para gerenciar o banco

#### Entrypoint

O script `docker-entrypoint.sh` automatiza:
- Aguarda o MySQL estar disponível
- Copia e configura `.env`
- Gera chave da aplicação
- Executa migrations e seeders
- Gera documentação Swagger
- Limpa caches

## 🎨 Design System

### Identidade Visual

- **Nome**: RecipeHub
- **Logo**: Ícone de chapéu de chef
- **Cores Primárias**: 
  - Laranja: `#F97316` (orange-500)
  - Vermelho: `#DC2626` (red-600)
- **Gradientes**: `from-orange-500 to-red-600`
- **Ícones**: Lucide Icons (moderna e profissional)
- **Tipografia**: Inter (Google Fonts)

### Componentes

- Cards com bordas arredondadas (rounded-xl)
- Sombras suaves (shadow-md, shadow-lg)
- Transições smooth (transition-all)
- Hover states em todos os botões
- Estados de loading com spinners
- Feedback visual de erros

## 🤝 Contribuindo

Este projeto foi desenvolvido como um sistema completo de gerenciamento de receitas seguindo as melhores práticas de desenvolvimento.

## 📄 Licença

Este projeto foi desenvolvido para fins de avaliação técnica.

---

Desenvolvido com Laravel, Vue.js e muito ☕

