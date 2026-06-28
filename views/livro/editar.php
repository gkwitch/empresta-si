<?php
$titulo_pagina = 'Editar Livro';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/nav.php';
?>

<div class="content-box">
    <h2>Editar Exemplar do Acervo</h2>
    <p>Modifique os dados de publicação ou a identificação específica do exemplar físico do livro.</p>

    <?php if (!empty($erro)): ?>
        <div class="error-msg">
            <strong>Erro:</strong> <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php endif; ?>

    <form action="livro.php?acao=editar&id=<?php echo $livro['id']; ?>" method="POST" id="formLivro" class="basic-form">
        <div class="form-group">
            <label for="titulo">Título do Livro: *</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($dados['titulo'] ?? ''); ?>" required maxlength="255">
        </div>

        <div class="form-group">
            <label for="autores">Autor(es): *</label>
            <input type="text" id="autores" name="autores" value="<?php echo htmlspecialchars($dados['autores'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="editora">Editora: *</label>
            <input type="text" id="editora" name="editora" value="<?php echo htmlspecialchars($dados['editora'] ?? ''); ?>" required maxlength="100">
        </div>

        <div class="form-row-double">
            <div class="form-group">
                <label for="edicao">Edição: *</label>
                <input type="number" id="edicao" name="edicao" value="<?php echo htmlspecialchars($dados['edicao'] ?? ''); ?>" required min="1">
            </div>

            <div class="form-group">
                <label for="ano_publicacao">Ano de Publicação: *</label>
                <input type="number" id="ano_publicacao" name="ano_publicacao" value="<?php echo htmlspecialchars($dados['ano_publicacao'] ?? ''); ?>" required min="1500" max="<?php echo date('Y') + 1; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="exemplar">Nome Identificador do Exemplar: *</label>
            <input type="text" id="exemplar" name="exemplar" value="<?php echo htmlspecialchars($dados['exemplar'] ?? ''); ?>" required maxlength="255">
            <small class="form-help">Identificador físico (Ex: Engenharia de Software Moderna – Exemplar 1).</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="livro.php?acao=listar" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
