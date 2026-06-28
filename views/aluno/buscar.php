<?php
$titulo_pagina = 'Pesquisar por Aluno';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/nav.php';
?>

<div class="content-box">
    <h2>Pesquisar Empréstimos Ativos por Aluno</h2>
    <p>Consulte quais livros estão emprestados a um aluno específico. Insira o nome do aluno ou seu número de matrícula.</p>

    <?php if (!empty($erro)): ?>
        <div class="error-msg">
            <strong>Erro:</strong> <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php endif; ?>


    <form action="aluno.php" method="GET" class="search-form">
        <input type="hidden" name="acao" value="buscar">
        <div class="form-row-search">
            <input type="text" name="busca" value="<?php echo htmlspecialchars($termo ?? ''); ?>" required placeholder="Digite o nome ou a matrícula..." class="input-search">
            <button type="submit" class="btn btn-search">Pesquisar</button>
        </div>
    </form>

    <?php if (isset($_GET['busca'])): ?>
        <h3 class="search-title">Resultados da Busca</h3>
        
        <?php if (empty($resultados)): ?>
            <div class="info-alert">
                Nenhum empréstimo ativo foi encontrado para o termo pesquisado. Certifique-se de que o nome ou a matrícula estão corretos, ou se o aluno de fato possui livros pendentes de devolução.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="basic-table">
                    <thead>
                        <tr>
                            <th>Nome do Aluno</th>
                            <th>Matrícula</th>
                            <th>Livro Emprestado (Exemplar)</th>
                            <th>Data do Empréstimo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $linha): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($linha['nome_aluno']); ?></td>
                                <td class="font-mono"><?php echo htmlspecialchars($linha['matricula_aluno']); ?></td>
                                <td><strong><?php echo htmlspecialchars($linha['nome_exemplar']); ?></strong></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($linha['data_emprestimo'])); ?></td>
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
