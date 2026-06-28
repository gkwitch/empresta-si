<?php
$titulo_pagina = 'Cadastrar Aluno';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/nav.php';
?>

<div class="content-box">
    <h2>Cadastrar Novo Aluno</h2>
    <p>Preencha os dados cadastrais do aluno. Campos marcados com * são obrigatórios.</p>

    <?php if (!empty($erro)): ?>
        <div class="error-msg">
            <strong>Erro:</strong> <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php endif; ?>

    <form action="aluno.php?acao=criar" method="POST" id="formAluno" class="basic-form">
        <div class="form-group">
            <label for="nome">Nome Completo: *</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($dados['nome'] ?? ''); ?>" required maxlength="255" placeholder="Nome completo do estudante">
        </div>

        <div class="form-group">
            <label for="matricula">Matrícula (11 dígitos): *</label>
            <input type="text" id="matricula" name="matricula" value="<?php echo htmlspecialchars($dados['matricula'] ?? ''); ?>" required maxlength="11" pattern="\d{11}" placeholder="Ex: 20210001234">
            <small class="form-help">Insira exatamente 11 dígitos numéricos.</small>
        </div>

        <div class="form-group">
            <label for="usuario">Nome de Usuário (Username): *</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($dados['usuario'] ?? ''); ?>" required maxlength="50" placeholder="Ex: joaosilva">
            <small class="form-help">Nome único para identificação no sistema.</small>
        </div>

        <div class="form-group">
            <label for="email">E-mail de Contato: *</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($dados['email'] ?? ''); ?>" required maxlength="100" placeholder="Ex: joao@ufrrj.br">
        </div>

        <div class="form-group">
            <label for="celular">Celular (com DDD):</label>
            <input type="text" id="celular" name="celular" value="<?php echo htmlspecialchars($dados['celular'] ?? ''); ?>" placeholder="Ex: 21988888888">
            <small class="form-help">Apenas números (de 10 a 11 dígitos).</small>
        </div>

        <div class="form-group">
            <label for="usuario_discord">Usuário Discord:</label>
            <input type="text" id="usuario_discord" name="usuario_discord" value="<?php echo htmlspecialchars($dados['usuario_discord'] ?? ''); ?>" placeholder="Ex: nomeusuario_discord">
        </div>

        <div class="form-group checkbox-group">
            <label>
                <input type="checkbox" id="gestor" name="gestor" value="1" <?php echo (isset($dados['gestor']) && $dados['gestor'] == 1) ? 'checked' : ''; ?>>
                Este aluno também é gestor e pode acessar o painel administrativo.
            </label>
        </div>

        <div id="secao-senha" class="form-group" style="display: <?php echo (isset($dados['gestor']) && $dados['gestor'] == 1) ? 'block' : 'none'; ?>;">
            <label for="senha">Senha para Acesso de Gestor: *</label>
            <input type="password" id="senha" name="senha" placeholder="Escolha uma senha de acesso">
            <small class="form-help">Requerido se o aluno for gestor do sistema.</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar Aluno</button>
            <a href="aluno.php?acao=listar" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>

document.getElementById('gestor').addEventListener('change', function() {
    var secaoSenha = document.getElementById('secao-senha');
    var campoSenha = document.getElementById('senha');
    if (this.checked) {
        secaoSenha.style.display = 'block';
        campoSenha.setAttribute('required', 'required');
    } else {
        secaoSenha.style.display = 'none';
        campoSenha.removeAttribute('required');
        campoSenha.value = '';
    }
});
</script>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
