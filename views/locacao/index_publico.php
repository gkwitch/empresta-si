<?php
$titulo_pagina = 'Consulta de Empréstimos Ativos';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/nav.php';
?>

<div class="content-box">
    <h2>Consulta de Empréstimos Ativos</h2>
    <p>Esta é uma página pública de transparência. Abaixo constam os livros da sala de convivência acadêmica que estão emprestados no momento.</p>

    <div class="table-responsive">
        <table class="basic-table">
            <thead>
                <tr>
                    <th>Livro</th>
                    <th>Exemplar</th>
                    <th>Aluno Locatário</th>
                    <th>Data de Empréstimo</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ativas)): ?>
                    <tr>
                        <td colspan="4" class="text-center">Todos os livros e exemplares do acervo estão disponíveis no momento!</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($ativas as $ativa): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ativa['titulo_livro']); ?></td>
                            <td><span class="badge-exemplar"><?php echo htmlspecialchars($ativa['nome_exemplar']); ?></span></td>
                            <td><?php echo htmlspecialchars($ativa['nome_aluno']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($ativa['data_emprestimo'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <br><hr class="section-separator"><br>

    <h3>Livros Disponíveis para Empréstimo</h3>
    <p class="section-help">Confira quais exemplares estão atualmente disponíveis no acervo para aluguel.</p>
    <div class="table-responsive">
        <table class="basic-table">
            <thead>
                <tr>
                    <th>Livro</th>
                    <th>Exemplar</th>
                    <th>Autor(es)</th>
                    <th>Editora</th>
                    <th>Edição / Ano</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($disponiveis)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Infelizmente, todos os exemplares estão emprestados no momento!</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($disponiveis as $disp): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($disp['titulo']); ?></strong></td>
                            <td><span class="badge-exemplar"><?php echo htmlspecialchars($disp['exemplar']); ?></span></td>
                            <td><?php echo htmlspecialchars($disp['autores']); ?></td>
                            <td><?php echo htmlspecialchars($disp['editora']); ?></td>
                            <td><?php echo htmlspecialchars($disp['edicao']); ?>ª ed. / <?php echo htmlspecialchars($disp['ano_publicacao']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($devolvidos)): ?>
        <br><hr class="section-separator"><br>
        <h3>Últimas Devoluções (Histórico de Devolvidos)</h3>
        <div class="table-responsive">
            <table class="basic-table table-history-public">
                <thead>
                    <tr>
                        <th>Livro</th>
                        <th>Exemplar</th>
                        <th>Aluno</th>
                        <th>Data Empréstimo</th>
                        <th>Data Devolução</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($devolvidos, 0, 5) as $h): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($h['titulo_livro']); ?></td>
                            <td><?php echo htmlspecialchars($h['nome_exemplar']); ?></td>
                            <td><?php echo htmlspecialchars($h['nome_aluno']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($h['data_emprestimo'])); ?></td>
                            <td><span class="status-tag devolvido"><?php echo date('d/m/Y', strtotime($h['data_devolucao'])); ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
