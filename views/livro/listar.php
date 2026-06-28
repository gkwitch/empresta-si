<?php
$titulo_pagina = 'Gerenciar Livros';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/nav.php';
?>

<div class="content-box">
    <div class="box-header">
        <h2>Gerenciamento do Acervo de Livros</h2>
        <a href="livro.php?acao=criar" class="btn btn-add">Cadastrar Novo Livro</a>
    </div>

    <?php if (!empty($sucesso)): ?>
        <div class="success-msg">
            <strong>Sucesso:</strong> <?php echo htmlspecialchars($sucesso); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($erro)): ?>
        <div class="error-msg">
            <strong>Erro:</strong> <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php endif; ?>

    <p class="info-note">O acervo do sistema controla individualmente cada cópia física do livro (cada exemplar).</p>

    <div class="table-responsive">
        <table class="basic-table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor(es)</th>
                    <th>Editora</th>
                    <th>Edição</th>
                    <th>Ano</th>
                    <th>Exemplar</th>
                    <th>Disponibilidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($livros)): ?>
                    <tr>
                        <td colspan="8" class="text-center">Nenhum livro ou exemplar cadastrado no acervo.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($livros as $livro): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($livro['autores']); ?></td>
                            <td><?php echo htmlspecialchars($livro['editora']); ?></td>
                            <td><?php echo htmlspecialchars($livro['edicao']); ?>ª ed.</td>
                            <td><?php echo htmlspecialchars($livro['ano_publicacao']); ?></td>
                            <td><span class="badge-exemplar"><?php echo htmlspecialchars($livro['exemplar']); ?></span></td>
                            <td>
                                <?php if ($livro['alugado'] == 1): ?>
                                    <span class="status-tag alugado">Alugado</span>
                                <?php else: ?>
                                    <span class="status-tag disponivel">Disponível</span>
                                <?php endif; ?>
                            </td>
                            <td class="table-actions">
                                <a href="livro.php?acao=editar&id=<?php echo $livro['id']; ?>" class="btn-action edit">Editar</a>
                                <a href="livro.php?acao=excluir&id=<?php echo $livro['id']; ?>" class="btn-action delete" onclick="return confirm('Deseja realmente excluir este exemplar físico?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
