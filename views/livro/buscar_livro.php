<?php
$titulo_pagina = 'Pesquisar Livros';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/nav.php';
?>

<div class="content-box">
    <h2>Pesquisar Livros no Acervo</h2>
    <p>Consulte a disponibilidade de exemplares de livros pelo título.</p>

    <?php if (!empty($erro)): ?>
        <div class="error-msg">
            <strong>Erro:</strong> <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php endif; ?>

    <form action="livro.php" method="GET" class="search-form">
        <input type="hidden" name="acao" value="buscar">
        <div class="form-row-search">
            <input type="text" name="busca" value="<?php echo htmlspecialchars($termo ?? ''); ?>" required placeholder="Digite o título do livro..." class="input-search">
            <button type="submit" class="btn btn-search">Pesquisar</button>
        </div>
    </form>

    <?php if (isset($_GET['busca'])): ?>
        <h3 class="search-title">Resultados da Busca</h3>

        <?php if (empty($resultados)): ?>
            <div class="info-alert">
                Nenhum exemplar correspondente foi encontrado para o termo pesquisado. Verifique a grafia do título digitado.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="basic-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Exemplar</th>
                            <th>Editora/Edição/Ano</th>
                            <th>Disponibilidade</th>
                            <th>Locatário</th>
                            <th>Data do Empréstimo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $linha): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($linha['titulo']); ?></td>
                                <td><span class="badge-exemplar"><?php echo htmlspecialchars($linha['exemplar']); ?></span></td>
                                <td><?php echo htmlspecialchars($linha['editora']); ?>, <?php echo htmlspecialchars($linha['edicao']); ?>ª ed., <?php echo htmlspecialchars($linha['ano_publicacao']); ?></td>
                                <td>
                                    <?php if ($linha['alugado'] == 1): ?>
                                        <span class="status-tag alugado">Emprestado</span>
                                    <?php else: ?>
                                        <span class="status-tag disponivel">Disponível</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                    if ($linha['alugado'] == 1 && !empty($linha['nome_aluno'])) {
                                        echo htmlspecialchars($linha['nome_aluno']) . ' (matrícula: ' . htmlspecialchars($linha['matricula_aluno']) . ')';
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    if ($linha['alugado'] == 1 && !empty($linha['data_emprestimo'])) {
                                        echo date('d/m/Y H:i', strtotime($linha['data_emprestimo']));
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
