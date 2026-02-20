<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f4f5f7;
        }

        .navbar {
            background-color: #026aa7 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 0.8rem 1rem;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 600;
            color: white !important;
        }

        .kanban-board {
            min-height: calc(100vh - 70px);
            background-color: #f4f5f7;
            padding: 20px;
        }

        .board-column {
            background-color: #ebecf0;
            border-radius: 8px;
            min-width: 280px;
            max-width: 280px;
            margin-right: 16px;
            padding: 12px;
            height: fit-content;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .board-column:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .task-list {
            min-height: 100px;
            transition: background-color 0.2s;
        }

        .task-item {
            background-color: white;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
            cursor: move;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .task-item:hover {
            background-color: #f8f9fa;
            box-shadow: 0 3px 6px rgba(0,0,0,0.16);
            transform: translateY(-2px);
        }

        .board-header {
            background: linear-gradient(135deg, #026aa7 0%, #0284c7 100%);
            color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .board-card {
            width: 240px;
            height: 120px;
            background: linear-gradient(135deg, #026aa7 0%, #0284c7 100%);
            color: white;
            border-radius: 8px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .board-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .board-card h5 {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            word-wrap: break-word;
        }

        .board-card small {
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .boards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        .auth-container {
            max-width: 400px;
            margin: 60px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .auth-container h2 {
            color: #026aa7;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #026aa7;
            border-color: #026aa7;
            padding: 10px 20px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #0284c7;
            border-color: #0284c7;
        }

        .btn-light {
            background-color: white;
            border: 1px solid #dee2e6;
            color: #026aa7;
        }

        .btn-light:hover {
            background-color: #f8f9fa;
        }

        .modal-header {
            background: linear-gradient(135deg, #026aa7 0%, #0284c7 100%);
            color: white;
            border-bottom: none;
            padding: 15px 20px;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .modal-footer {
            border-top: 1px solid #dee2e6;
            padding: 15px 20px;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #dee2e6;
            padding: 10px;
        }

        .form-control:focus {
            border-color: #026aa7;
            box-shadow: 0 0 0 0.2rem rgba(2,106,167,0.25);
        }

        .task-list-empty {
            color: #6c757d;
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
        }

        .btn-icon {
            background: transparent;
            border: none;
            color: #6c757d;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .btn-icon:hover {
            background-color: rgba(0,0,0,0.05);
            color: #026aa7;
        }

        .category-title {
            font-weight: 600;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 2px solid rgba(0,0,0,0.1);
        }

        .drag-over {
            background-color: #e9ecef;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #026aa7;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-dark">
            <div class="container-fluid">
                <span class="navbar-brand">
                    <i class="bi bi-kanban me-2"></i>
                    Kanban App
                </span>
                <div id="auth-nav" class="d-flex">
                    <!-- Will be populated by JavaScript -->
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container-fluid kanban-board" id="app-content">
            <!-- Dynamic content will be loaded here -->
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Login
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="login-form" onsubmit="event.preventDefault(); handleLogin();">
                        <div class="mb-3">
                            <label for="login-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="login-email" required>
                        </div>
                        <div class="mb-3">
                            <label for="login-password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="login-password" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="handleLogin()">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Entrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus me-2"></i>
                        Registrar
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="register-form" onsubmit="event.preventDefault(); handleRegister();">
                        <div class="mb-3">
                            <label for="register-name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="register-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="register-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="register-email" required>
                        </div>
                        <div class="mb-3">
                            <label for="register-password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="register-password" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="handleRegister()">
                        <i class="bi bi-person-plus me-2"></i>
                        Registrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Board Modal -->
    <div class="modal fade" id="boardModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-square me-2"></i>
                        Novo Board
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="board-form" onsubmit="event.preventDefault(); createBoard();">
                        <div class="mb-3">
                            <label for="board-title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="board-title" required>
                        </div>
                        <div class="mb-3">
                            <label for="board-description" class="form-label">Descrição</label>
                            <textarea class="form-control" id="board-description" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="createBoard()">
                        <i class="bi bi-check-lg me-2"></i>
                        Criar Board
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-square me-2"></i>
                        Nova Categoria
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="category-form" onsubmit="event.preventDefault(); createCategory();">
                        <div class="mb-3">
                            <label for="category-title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="category-title" required>
                        </div>
                        <div class="mb-3">
                            <label for="category-color" class="form-label">Cor</label>
                            <input type="color" class="form-control" id="category-color" value="#007bff" style="height: 50px;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="createCategory()">
                        <i class="bi bi-check-lg me-2"></i>
                        Criar Categoria
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-square me-2"></i>
                        Nova Tarefa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="task-form" onsubmit="event.preventDefault(); createTask();">
                        <div class="mb-3">
                            <label for="task-title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="task-title" required>
                        </div>
                        <div class="mb-3">
                            <label for="task-description" class="form-label">Descrição</label>
                            <textarea class="form-control" id="task-description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="task-due-date" class="form-label">Data de Entrega</label>
                            <input type="date" class="form-control" id="task-due-date">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="createTask()">
                        <i class="bi bi-check-lg me-2"></i>
                        Criar Tarefa
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script>
        // Variáveis globais
        let currentUser = null;
        let currentBoard = null;
        let token = localStorage.getItem('token');
        let currentCategoryId = null;
        let sortableInstances = [];

        // Configuração do AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        // Inicialização
        $(document).ready(function() {
            console.log('App iniciado');
            checkAuth();
        });

        // Funções de Autenticação
        function checkAuth() {
            if (token) {
                $.ajax({
                    url: '/api/user',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    success: function(user) {
                        console.log('Usuário autenticado:', user);
                        currentUser = user;
                        updateNavbar();
                        loadBoards();
                    },
                    error: function(xhr) {
                        console.error('Erro auth:', xhr);
                        localStorage.removeItem('token');
                        token = null;
                        showLoginView();
                    }
                });
            } else {
                showLoginView();
            }
        }

        function updateNavbar() {
            if (currentUser) {
                $('#auth-nav').html(`
                    <span class="navbar-text me-3">
                        <i class="bi bi-person-circle me-2"></i>
                        Olá, ${currentUser.name}
                    </span>
                    <button class="btn btn-outline-light me-2" onclick="logout()">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Sair
                    </button>
                `);
            } else {
                $('#auth-nav').html(`
                    <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Login
                    </button>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#registerModal">
                        <i class="bi bi-person-plus me-2"></i>
                        Registrar
                    </button>
                `);
            }
        }

        function showLoginView() {
            $('#app-content').html(`
                <div class="auth-container">
                    <h2 class="text-center mb-4">
                        <i class="bi bi-kanban me-2"></i>
                        Bem-vindo ao Kanban App
                    </h2>
                    <p class="text-center text-muted mb-4">
                        Organize suas tarefas de forma simples e eficiente
                    </p>
                    <div class="d-grid gap-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Fazer Login
                        </button>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#registerModal">
                            <i class="bi bi-person-plus me-2"></i>
                            Criar Conta
                        </button>
                    </div>
                </div>
            `);
        }

        function handleLogin() {
            const email = $('#login-email').val();
            const password = $('#login-password').val();

            if (!email || !password) {
                alert('Preencha todos os campos');
                return;
            }

            $.ajax({
                url: '/api/login',
                method: 'POST',
                data: JSON.stringify({ email, password }),
                success: function(response) {
                    if (response.success) {
                        token = response.token;
                        localStorage.setItem('token', token);
                        currentUser = response.user;
                        $('#loginModal').modal('hide');
                        $('#login-email').val('');
                        $('#login-password').val('');
                        updateNavbar();
                        loadBoards();
                    } else {
                        alert(response.message || 'Erro no login');
                    }
                },
                error: function(xhr) {
                    let message = 'Erro no login';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    alert(message);
                }
            });
        }

        function handleRegister() {
            const name = $('#register-name').val();
            const email = $('#register-email').val();
            const password = $('#register-password').val();

            if (!name || !email || !password) {
                alert('Preencha todos os campos');
                return;
            }

            if (password.length < 8) {
                alert('A senha deve ter no mínimo 8 caracteres');
                return;
            }

            $.ajax({
                url: '/api/register',
                method: 'POST',
                data: JSON.stringify({ name, email, password }),
                success: function(response) {
                    if (response.success) {
                        token = response.token;
                        localStorage.setItem('token', token);
                        currentUser = response.user;
                        $('#registerModal').modal('hide');
                        $('#register-name').val('');
                        $('#register-email').val('');
                        $('#register-password').val('');
                        updateNavbar();
                        loadBoards();
                    } else {
                        alert(response.message || 'Erro no registro');
                    }
                },
                error: function(xhr) {
                    let message = 'Erro no registro';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    alert(message);
                }
            });
        }

        function logout() {
            $.ajax({
                url: '/api/logout',
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function() {
                    localStorage.removeItem('token');
                    token = null;
                    currentUser = null;
                    updateNavbar();
                    showLoginView();
                },
                error: function() {
                    localStorage.removeItem('token');
                    token = null;
                    currentUser = null;
                    updateNavbar();
                    showLoginView();
                }
            });
        }

        // Funções de Boards
        function loadBoards() {
            $.ajax({
                url: '/api/boards',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(boards) {
                    displayBoards(boards);
                },
                error: function(xhr) {
                    console.error('Erro ao carregar boards:', xhr);
                    if (xhr.status === 401) {
                        logout();
                    } else {
                        alert('Erro ao carregar boards');
                    }
                }
            });
        }

        function displayBoards(boards) {
            let html = `
                <div class="board-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-2">
                                <i class="bi bi-kanban me-3"></i>
                                Meus Quadros
                            </h2>
                            <p class="mb-0 opacity-75">Gerencie seus projetos e tarefas</p>
                        </div>
                        <button class="btn btn-light" onclick="showBoardModal()">
                            <i class="bi bi-plus-lg me-2"></i>
                            Novo Quadro
                        </button>
                    </div>
                </div>
                <div class="boards-container">
            `;

            if (!boards || boards.length === 0) {
                html += `
                    <div class="text-center w-100 py-5">
                        <i class="bi bi-kanban fs-1 text-muted mb-3"></i>
                        <p class="text-muted mb-3">Nenhum quadro criado ainda</p>
                        <button class="btn btn-primary" onclick="showBoardModal()">
                            <i class="bi bi-plus-lg me-2"></i>
                            Criar Primeiro Quadro
                        </button>
                    </div>
                `;
            } else {
                boards.forEach(board => {
                    const taskCount = board.categories?.reduce((acc, cat) => acc + (cat.tasks?.length || 0), 0) || 0;
                    html += `
                        <div class="board-card" onclick="openBoard(${board.id})">
                            <div>
                                <h5>${board.title}</h5>
                                ${board.description ? `<small>${board.description.substring(0, 50)}${board.description.length > 50 ? '...' : ''}</small>` : ''}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-columns-gap me-1"></i>
                                    ${board.categories?.length || 0} colunas
                                </span>
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-check2-square me-1"></i>
                                    ${taskCount} tarefas
                                </span>
                            </div>
                        </div>
                    `;
                });
            }

            html += '</div>';
            $('#app-content').html(html);
        }

        function showBoardModal() {
            $('#board-title').val('');
            $('#board-description').val('');
            $('#boardModal').modal('show');
        }

        function createBoard() {
            const title = $('#board-title').val();
            const description = $('#board-description').val();

            if (!title) {
                alert('O título é obrigatório');
                return;
            }

            $.ajax({
                url: '/api/boards',
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                data: JSON.stringify({ title, description }),
                success: function() {
                    $('#boardModal').modal('hide');
                    loadBoards();
                },
                error: function(xhr) {
                    alert('Erro ao criar board');
                }
            });
        }

        // Funções do Kanban
        function openBoard(boardId) {
            $.ajax({
                url: '/api/boards/' + boardId,
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(board) {
                    console.log('Board carregado:', board);
                    currentBoard = board;
                    displayKanban(board);
                },
                error: function(xhr) {
                    console.error('Erro ao abrir board:', xhr);
                    alert('Erro ao abrir board');
                }
            });
        }

        function displayKanban(board) {
            // Limpar instâncias anteriores do Sortable
            sortableInstances.forEach(instance => instance.destroy());
            sortableInstances = [];

            let html = `
                <div class="board-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <button class="btn btn-light btn-sm me-3" onclick="loadBoards()">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Voltar
                                </button>
                                <h2 class="mb-0">${board.title}</h2>
                            </div>
                            ${board.description ? `<p class="mb-0 opacity-75 ms-5">${board.description}</p>` : ''}
                        </div>
                        <button class="btn btn-light" onclick="showCategoryModal()">
                            <i class="bi bi-plus-lg me-2"></i>
                            Nova Coluna
                        </button>
                    </div>
                </div>
                <div class="d-flex flex-row overflow-auto p-3" id="kanban-container" style="gap: 16px; min-height: 500px;">
            `;

            if (!board.categories || board.categories.length === 0) {
                html += `
                    <div class="text-center w-100 py-5">
                        <i class="bi bi-columns-gap fs-1 text-muted mb-3"></i>
                        <p class="text-muted mb-3">Nenhuma coluna criada</p>
                        <button class="btn btn-primary" onclick="showCategoryModal()">
                            <i class="bi bi-plus-lg me-2"></i>
                            Criar Primeira Coluna
                        </button>
                    </div>
                `;
            } else {
                board.categories.sort((a, b) => a.order - b.order).forEach(category => {
                    html += `
                        <div class="board-column" data-category-id="${category.id}">
                            <div class="category-title d-flex justify-content-between align-items-center">
                                <h6 style="color: ${category.color}; margin: 0;">
                                    <i class="bi bi-circle-fill me-2" style="font-size: 0.6rem; color: ${category.color}"></i>
                                    ${category.title}
                                </h6>
                                <div>
                                    <button class="btn btn-sm btn-icon" onclick="showTaskModal(${category.id})" title="Nova tarefa">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                    <button class="btn btn-sm btn-icon text-danger" onclick="deleteCategory(${category.id})" title="Excluir coluna">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="task-list" id="category-${category.id}">
                    `;

                    if (category.tasks && category.tasks.length > 0) {
                        category.tasks.sort((a, b) => a.order - b.order).forEach(task => {
                            html += `
                                <div class="task-item" data-task-id="${task.id}">
                                    <div class="d-flex justify-content-between">
                                        <strong>${task.title}</strong>
                                        <button class="btn btn-sm btn-link text-danger p-0" onclick="deleteTask(${task.id}, event)">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                    ${task.description ? `<small class="text-muted d-block mt-1">${task.description.substring(0, 50)}${task.description.length > 50 ? '...' : ''}</small>` : ''}
                                    ${task.due_date ? `
                                        <small class="text-muted d-block mt-2">
                                            <i class="bi bi-calendar me-1"></i>
                                            ${new Date(task.due_date).toLocaleDateString('pt-BR')}
                                        </small>
                                    ` : ''}
                                </div>
                            `;
                        });
                    } else {
                        html += `<div class="task-list-empty text-muted">Arraste tarefas para cá</div>`;
                    }

                    html += `
                            </div>
                        </div>
                    `;
                });
            }

            html += '</div>';
            $('#app-content').html(html);

            // Inicializar Sortable após renderizar
            if (board.categories && board.categories.length > 0) {
                initializeSortable();
            }
        }

        function showCategoryModal() {
            $('#category-title').val('');
            $('#category-color').val('#007bff');
            $('#categoryModal').modal('show');
        }

        function createCategory() {
            const title = $('#category-title').val();
            const color = $('#category-color').val();

            if (!title) {
                alert('O título é obrigatório');
                return;
            }

            $.ajax({
                url: `/api/boards/${currentBoard.id}/categories`,
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                data: JSON.stringify({ title, color }),
                success: function() {
                    $('#categoryModal').modal('hide');
                    openBoard(currentBoard.id);
                },
                error: function(xhr) {
                    alert('Erro ao criar categoria');
                }
            });
        }

        function deleteCategory(categoryId) {
            if (confirm('Tem certeza que deseja excluir esta coluna? Todas as tarefas serão perdidas.')) {
                $.ajax({
                    url: `/api/categories/${categoryId}`,
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    success: function() {
                        openBoard(currentBoard.id);
                    },
                    error: function(xhr) {
                        alert('Erro ao excluir categoria');
                    }
                });
            }
        }

        function showTaskModal(categoryId) {
            currentCategoryId = categoryId;
            $('#task-title').val('');
            $('#task-description').val('');
            $('#task-due-date').val('');
            $('#taskModal').modal('show');
        }

        function createTask() {
            const title = $('#task-title').val();
            const description = $('#task-description').val();
            const due_date = $('#task-due-date').val();

            if (!title) {
                alert('O título é obrigatório');
                return;
            }

            $.ajax({
                url: `/api/categories/${currentCategoryId}/tasks`,
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                data: JSON.stringify({ title, description, due_date }),
                success: function() {
                    $('#taskModal').modal('hide');
                    openBoard(currentBoard.id);
                },
                error: function(xhr) {
                    alert('Erro ao criar tarefa');
                }
            });
        }

        function deleteTask(taskId, event) {
            event.stopPropagation();
            if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
                $.ajax({
                    url: `/api/tasks/${taskId}`,
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    success: function() {
                        openBoard(currentBoard.id);
                    },
                    error: function(xhr) {
                        alert('Erro ao excluir tarefa');
                    }
                });
            }
        }

        function initializeSortable() {
            // Sortable para tarefas
            document.querySelectorAll('.task-list').forEach(list => {
                const sortable = new Sortable(list, {
                    group: 'tasks',
                    animation: 150,
                    ghostClass: 'bg-light',
                    dragClass: 'opacity-75',
                    onEnd: function(evt) {
                        const taskId = evt.item.dataset.taskId;
                        const newCategoryId = evt.to.closest('.board-column').dataset.categoryId;
                        const newOrder = evt.newIndex;

                        console.log('Movendo tarefa:', { taskId, newCategoryId, newOrder });

                        $.ajax({
                            url: `/api/tasks/${taskId}/move`,
                            method: 'POST',
                            headers: {
                                'Authorization': 'Bearer ' + token
                            },
                            data: JSON.stringify({
                                category_id: parseInt(newCategoryId),
                                order: newOrder
                            }),
                            success: function() {
                                reorderTasks(newCategoryId);
                                if (evt.from !== evt.to) {
                                    const oldCategoryId = evt.from.closest('.board-column').dataset.categoryId;
                                    reorderTasks(oldCategoryId);
                                }
                            },
                            error: function(xhr) {
                                console.error('Erro ao mover tarefa:', xhr);
                                alert('Erro ao mover tarefa');
                                openBoard(currentBoard.id);
                            }
                        });
                    }
                });
                sortableInstances.push(sortable);
            });

            // Sortable para categorias (colunas)
            const container = document.getElementById('kanban-container');
            if (container) {
                const categorySortable = new Sortable(container, {
                    animation: 150,
                    handle: '.board-column',
                    onEnd: function(evt) {
                        const categories = [];
                        container.querySelectorAll('.board-column').forEach((column, index) => {
                            const categoryId = column.dataset.categoryId;
                            categories.push({
                                id: parseInt(categoryId),
                                order: index
                            });
                        });

                        console.log('Reordenando categorias:', categories);

                        $.ajax({
                            url: `/api/boards/${currentBoard.id}/categories/reorder`,
                            method: 'POST',
                            headers: {
                                'Authorization': 'Bearer ' + token
                            },
                            data: JSON.stringify({ categories: categories }),
                            error: function(xhr) {
                                console.error('Erro ao reordenar categorias:', xhr);
                                alert('Erro ao reordenar categorias');
                                openBoard(currentBoard.id);
                            }
                        });
                    }
                });
                sortableInstances.push(categorySortable);
            }
        }

        function reorderTasks(categoryId) {
            const tasks = [];
            document.querySelectorAll(`#category-${categoryId} .task-item`).forEach((task, index) => {
                const taskId = task.dataset.taskId;
                tasks.push({
                    id: parseInt(taskId),
                    order: index
                });
            });

            console.log('Reordenando tarefas da categoria:', categoryId, tasks);

            $.ajax({
                url: `/api/categories/${categoryId}/tasks/reorder`,
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                data: JSON.stringify({ tasks: tasks }),
                error: function(xhr) {
                    console.error('Erro ao reordenar tarefas:', xhr);
                }
            });
        }
    </script>
</body>
</html>
