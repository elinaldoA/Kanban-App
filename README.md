# 📋 README - Sistema Kanban (Trello Clone)

## Kanban App - Gerenciamento de Tarefas estilo Trello

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-336791?style=for-the-badge&logo=postgresql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap)
![jQuery](https://img.shields.io/badge/jQuery-3.6-0769AD?style=for-the-badge&logo=jquery)

---

## 📑 Sobre o Projeto

**Kanban App** é um sistema completo de gerenciamento de tarefas inspirado no Trello, desenvolvido com Laravel 11 e PostgreSQL. O projeto permite que usuários criem quadros personalizados, organizem tarefas em colunas (categorias) e realizem drag-and-drop para mover itens entre as etapas do fluxo de trabalho.

---

## ✨ Funcionalidades Implementadas

### Autenticação
- ✅ Registro de novos usuários com validação
- ✅ Login com geração de token via Laravel Sanctum
- ✅ Logout com invalidação de token
- ✅ Proteção de rotas por autenticação
- ✅ Persistência de sessão via localStorage

### Quadros (Boards)
- ✅ Criar quadros com título e descrição
- ✅ Listar todos os quadros do usuário
- ✅ Visualizar quadro detalhado com categorias e tarefas
- ✅ Excluir quadros (com todas categorias e tarefas)
- ✅ Contador de categorias e tarefas por board

### Categorias (Colunas)
- ✅ Criar categorias com título e cor personalizada (formato HEX)
- ✅ Reordenar categorias via drag-and-drop
- ✅ Excluir categorias (com todas tarefas)
- ✅ Persistência automática da ordem

### Tarefas (Cards)
- ✅ Criar tarefas com título, descrição e data de entrega
- ✅ Arrastar tarefas entre categorias
- ✅ Reordenar tarefas dentro da mesma categoria
- ✅ Excluir tarefas
- ✅ Visualização compacta com preview da descrição

### Interface
- ✅ Design responsivo (mobile/desktop)
- ✅ Modais Bootstrap para todas operações
- ✅ Feedback visual para ações
- ✅ Loading states
- ✅ Mensagens de erro amigáveis
- ✅ Ícones intuitivos (Bootstrap Icons)
- ✅ Cores diferenciadas por categoria

### Drag and Drop
- ✅ Tarefas movidas entre colunas
- ✅ Colunas reordenadas
- ✅ Persistência automática da ordem via AJAX
- ✅ Animações suaves com SortableJS

---

## 🚀 Tecnologias Utilizadas

### Backend
| Tecnologia | Versão | Descrição |
|------------|--------|-----------|
| Laravel | 11.x | Framework PHP |
| PHP | 8.2+ | Linguagem de programação |
| PostgreSQL | 16+ | Banco de dados relacional |
| Laravel Sanctum | 4.x | Autenticação API |
| Eloquent ORM | - | Mapeamento objeto-relacional |

### Frontend
| Tecnologia | Versão | Descrição |
|------------|--------|-----------|
| Bootstrap | 5.3 | Framework CSS |
| jQuery | 3.6 | Biblioteca JavaScript |
| SortableJS | 1.15 | Drag and drop |
| Bootstrap Icons | 1.11 | Biblioteca de ícones |
| HTML5 | - | Estrutura |
| CSS3 | - | Estilização |

---

## 📋 Pré-requisitos

- PHP 8.2 ou superior
- Composer
- PostgreSQL 12 ou superior
- Git (opcional)

---

## 🔧 Instalação

```bash
# 1. Clonar o repositório
git clone https://github.com/elinaldoA/Kanban-App
cd kanban-app

# 2. Instalar dependências
composer install

# 3. Instalar Laravel Sanctum
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

# 4. Configurar ambiente
cp .env.example .env
php artisan key:generate

# 5. Configurar banco de dados no .env
# Edite o arquivo .env com suas configurações do PostgreSQL

# 6. Criar banco de dados
# Via pgAdmin ou terminal:
createdb -U postgres kanban_db

# 7. Executar migrations
php artisan migrate

# 8. Iniciar servidor
php artisan serve
```

---

## ⚙️ Configuração do .env

```env
APP_NAME=KanbanApp
APP_ENV=local
APP_KEY=base64:YOUR_KEY_HERE
APP_DEBUG=true
APP_TIMEZONE=America/Sao_Paulo
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=kanban_db
DB_USERNAME=postgres
DB_PASSWORD=sua_senha

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_DOMAIN=localhost
SANCTUM_STATEFUL_DOMAINS=localhost:8000
```

---

## 🗄️ Estrutura do Banco de Dados

### Tabelas

```sql
users
- id (PK)
- name
- email
- password
- timestamps

boards
- id (PK)
- user_id (FK → users.id)
- title
- description
- timestamps

categories
- id (PK)
- board_id (FK → boards.id)
- title
- color
- order
- timestamps

tasks
- id (PK)
- category_id (FK → categories.id)
- title
- description
- order
- due_date
- timestamps
```

---

## 🔌 API Endpoints

### Autenticação
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| POST | `/api/register` | Registrar novo usuário |
| POST | `/api/login` | Login de usuário |
| POST | `/api/logout` | Logout |
| GET | `/api/user` | Dados do usuário atual |

### Boards
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | `/api/boards` | Listar boards do usuário |
| POST | `/api/boards` | Criar novo board |
| GET | `/api/boards/{id}` | Detalhes do board |
| DELETE | `/api/boards/{id}` | Excluir board |

### Categorias
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| POST | `/api/boards/{boardId}/categories` | Criar categoria |
| PUT | `/api/categories/{id}` | Atualizar categoria |
| DELETE | `/api/categories/{id}` | Excluir categoria |
| POST | `/api/boards/{boardId}/categories/reorder` | Reordenar categorias |

### Tarefas
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| POST | `/api/categories/{categoryId}/tasks` | Criar tarefa |
| PUT | `/api/tasks/{id}` | Atualizar tarefa |
| DELETE | `/api/tasks/{id}` | Excluir tarefa |
| POST | `/api/tasks/{id}/move` | Mover tarefa |
| POST | `/api/categories/{categoryId}/tasks/reorder` | Reordenar tarefas |

---

## 📁 Estrutura de Diretórios

```
kanban-app/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php
│   │       ├── BoardController.php
│   │       ├── CategoryController.php
│   │       └── TaskController.php
│   └── Models/
│       ├── User.php
│       ├── Board.php
│       ├── Category.php
│       └── Task.php
├── bootstrap/
│   └── app.php
├── config/
│   ├── cors.php
│   └── sanctum.php
├── database/
│   └── migrations/
│       ├── 0001_01_01_000000_create_users_table.php
│       ├── 2024_01_01_000001_create_boards_table.php
│       ├── 2024_01_01_000002_create_categories_table.php
│       └── 2024_01_01_000003_create_tasks_table.php
├── resources/
│   └── views/
│       └── index.blade.php
├── routes/
│   ├── api.php
│   └── web.php
└── .env
```

---

## 💻 Como Usar

### 1. Acessar o sistema
```
http://localhost:8000
```

### 2. Criar conta
- Clique em "Registrar"
- Preencha nome, email e senha (mínimo 8 caracteres)

### 3. Criar um Board
- Clique em "Novo Quadro"
- Digite título e descrição
- Clique em "Criar Board"

### 4. Criar Categorias (Colunas)
- Dentro do board, clique em "Nova Coluna"
- Digite título e escolha uma cor
- Clique em "Criar Categoria"

### 5. Criar Tarefas
- Clique no "+" na coluna desejada
- Digite título, descrição e data (opcional)
- Clique em "Criar Tarefa"

### 6. Organizar
- **Arraste tarefas** entre colunas
- **Arraste colunas** para reordenar
- Clique no "X" para excluir itens

---

## 🔒 Segurança

- Autenticação via tokens Laravel Sanctum
- Senhas hasheadas com Bcrypt
- Proteção contra SQL Injection (Eloquent ORM)
- Validação de dados em todas requisições
- Verificação de propriedade dos recursos
- CSRF protection nas rotas web
- CORS configurado para desenvolvimento

---

## ❗ Solução de Problemas

### Erro: "Token not provided"
```bash
# Verifique se o token está no header Authorization
# Faça login novamente para gerar novo token
```

### Erro: "Unauthorized"
```bash
# Verifique se o recurso pertence ao usuário logado
# Confirme se o board/category/task existe
```

### Erro de conexão com banco
```bash
# Verifique se o PostgreSQL está rodando
# Confirme as credenciais no .env
# Execute: php artisan config:clear
```

### Drag and drop não funciona
```bash
# Verifique o console do navegador (F12)
# Recarregue a página
# Confirme se SortableJS foi carregado
```

---

## 📊 Comandos Úteis

```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Recriar banco de dados
php artisan migrate:fresh

# Ver rotas
php artisan route:list

# Criar migration
php artisan make:migration nome_da_migration

# Criar controller
php artisan make:controller NomeController

# Criar model
php artisan make:model Nome
```

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

