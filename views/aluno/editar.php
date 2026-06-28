<?php
$titulo_pagina = 'Editar Aluno';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/nav.php';
?>

<div class="content-box">
    <h2>Editar Cadastro de Aluno</h2>
    <p>Modifique os dados cadastrais do aluno. Conforme regra do sistema, a matrícula é imutável.</p>

    <?php if (!empty($erro)): ?>
        <div class="error-msg">
            <strong>Erro:</strong> <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php endif; ?>

    <form action="aluno.php?acao=editar&id=<?php echo $aluno['id']; ?>" method="POST" id="formAluno" class="basic-form">
        <div class="form-group">
            <label for="nome">Nome Completo: *</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($dados['nome'] ?? ''); ?>" required maxlength="255">
        </div>

        <div class="form-group">
            <label for="matricula_display">Matrícula (Bloqueada para Edição):</label>
            <input type="text" id="matricula_display" value="<?php echo htmlspecialchars($aluno['matricula']); ?>" disabled class="input-disabled">
            <small class="form-help">Por motivos de segurança acadêmica, a matrícula não pode ser editada.</small>
        </div>

        <div class="form-group">
            <label for="usuario">Nome de Usuário (Username): *</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($dados['usuario'] ?? ''); ?>" required maxlength="50">
        </div>

        <div class="form-group">
            <label for="email">E-mail: *</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($dados['email'] ?? ''); ?>" required maxlength="100">
        </div>

        <div class="form-group">
            <label for="celular">Celular (com DDD):</label>
            <input type="text" id="celular" name="celular" value="<?php echo htmlspecialchars($dados['celular'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="usuario_discord">Usuário Discord:</label>
            <input type="text" id="usuario_discord" name="usuario_discord" value="<?php echo htmlspecialchars($dados['usuario_discord'] ?? ''); ?>">
        </div>

        <div class="form-group checkbox-group">
            <label>
                <input type="checkbox" id="gestor" name="gestor" value="1" <?php echo (isset($dados['gestor']) && $dados['gestor'] == 1) ? 'checked' : ''; ?>>
                Este aluno é gestor do sistema (tem acesso administrativo).
            </label>
        </div>

        <div id="secao-senha" class="form-group" style="display: <?php echo (isset($dados['gestor']) && $dados['gestor'] == 1) ? 'block' : 'none'; ?>;">
            <label for="senha">Nova Senha para Acesso:</label>
            <input type="password" id="senha" name="senha" placeholder="Deixe em branco para manter a senha atual">
            <small class="form-help">Preencha apenas se desejar trocar a senha do gestor ou se estiver promovendo o aluno a gestor agora.</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="aluno.php?acao=listar" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>

document.getElementById('gestor').addEventListener('change', function() {
    var secaoSenha = document.getElementById('secao-senha');
    if (this.checked) {
        secaoSenha.style.display = 'block';
    } else {
        secaoSenha.style.display = 'none';
        document.getElementById('senha').value = '';
    }
});
</script>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
