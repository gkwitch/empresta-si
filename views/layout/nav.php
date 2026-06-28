<nav class="main-nav">
    <div class="nav-container">
        <a class="nav-link" href="index.php">Empréstimos Ativos</a> | 
        <a class="nav-link" href="livro.php?acao=buscar">Pesquisar Livros</a> | 
        <a class="nav-link" href="aluno.php?acao=buscar">Pesquisar Alunos</a>

        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['gestor_logged']) && $_SESSION['gestor_logged'] === true):
        ?>
            <span class="nav-divider">||</span>
            <span class="admin-label">Gestão:</span>
            <a class="nav-link admin-link" href="aluno.php?acao=listar">Alunos</a> | 
            <a class="nav-link admin-link" href="livro.php?acao=listar">Livros</a> | 
            <a class="nav-link admin-link" href="locacao.php?acao=listar">Empréstimos</a> | 
            <a class="nav-link admin-link" href="locacao.php?acao=emprestar">Novo Empréstimo</a> | 
            <a class="nav-link admin-link" href="locacao.php?acao=devolver">Devoluções</a> | 
            <a class="nav-link logout-link" href="login.php?acao=logout">Sair (<strong><?php echo htmlspecialchars($_SESSION['gestor_usuario']); ?></strong>)</a>
        <?php else: ?>
            <span class="nav-divider">|</span>
            <a class="nav-link login-link" href="login.php">Login Gestor</a>
        <?php endif; ?>
    </div>
</nav>
<hr class="nav-separator">
<main class="main-content">
