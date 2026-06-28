<?php
$titulo_pagina = 'Cadastrar Livro';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/nav.php';
?>

<div class="content-box">
    <h2>Cadastrar Novo Livro no Acervo</h2>
    <p>Preencha os dados de publicação do livro. Os campos marcados com * são de preenchimento obrigatório.</p>

    <?php if (!empty($erro)): ?>
        <div class="error-msg">
            <strong>Erro:</strong> <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php endif; ?>

    <form action="livro.php?acao=criar" method="POST" id="formLivro" class="basic-form">
        <div class="form-group">
            <label for="titulo">Título do Livro: *</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($dados['titulo'] ?? ''); ?>" required maxlength="255" placeholder="Ex: Engenharia de Software Moderna">
        </div>

        <div class="form-group">
            <label for="autores">Autor(es) / Escritor(es): *</label>
            <input type="text" id="autores" name="autores" value="<?php echo htmlspecialchars($dados['autores'] ?? ''); ?>" required placeholder="Ex: Marco Tulio Valente (indique os coautores se houver)">
        </div>

        <div class="form-group">
            <label for="editora">Editora: *</label>
            <input type="text" id="editora" name="editora" value="<?php echo htmlspecialchars($dados['editora'] ?? ''); ?>" required maxlength="100" placeholder="Ex: Alta Books">
        </div>

        <div class="form-row-double">
            <div class="form-group">
                <label for="edicao">Número da Edição: *</label>
                <input type="number" id="edicao" name="edicao" value="<?php echo htmlspecialchars($dados['edicao'] ?? '1'); ?>" required min="1" placeholder="Ex: 1">
            </div>

            <div class="form-group">
                <label for="ano_publicacao">Ano de Publicação: *</label>
                <input type="number" id="ano_publicacao" name="ano_publicacao" value="<?php echo htmlspecialchars($dados['ano_publicacao'] ?? ''); ?>" required min="1500" max="<?php echo date('Y') + 1; ?>" placeholder="Ex: 2020">
            </div>
        </div>

        <div class="form-group">
            <label for="quantidade">Quantidade de Exemplares Físicos: *</label>
            <input type="number" id="quantidade" name="quantidade" value="<?php echo (int)($quantidade ?? 1); ?>" required min="1" placeholder="Ex: 3">
            <small class="form-help">Ao definir quantidade maior que 1, o sistema criará múltiplas linhas no banco usando sufixos (Exemplar 1, Exemplar 2...).</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Cadastrar Livro</button>
            <a href="livro.php?acao=listar" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
