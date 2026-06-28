<?php
$titulo_pagina = 'Login do Gestor';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/nav.php';
?>

<div class="admin-box">
    <h2>Acesso ao Painel do Gestor</h2>
    <p>Insira seu usuário e senha cadastrados para acessar as funcionalidades administrativas do acervo.</p>

    <?php if (!empty($erro)): ?>
        <div class="error-msg">
            <strong>Falha:</strong> <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php endif; ?>

    <form action="login.php" method="POST" id="formLogin" class="basic-form">
        <div class="form-group">
            <label for="usuario">Nome de Usuário: *</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario ?? ''); ?>" required maxlength="50" placeholder="Ex: admin">
        </div>
        
        <div class="form-group">
            <label for="senha">Senha de Acesso: *</label>
            <input type="password" id="senha" name="senha" required placeholder="Digite sua senha">
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Entrar no Sistema</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
