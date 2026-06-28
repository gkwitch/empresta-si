<?php
$titulo_pagina = 'Gerenciar Empréstimos';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/nav.php';
?>

<div class="content-box">
    <div class="box-header">
        <h2>Gerenciamento de Empréstimos e Devoluções</h2>
        <div class="header-actions">
            <a href="locacao.php?acao=emprestar" class="btn btn-add">Novo Empréstimo</a>
            <a href="locacao.php?acao=devolver" class="btn btn-bulk-return">Registrar Devolução</a>
        </div>
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

    <div class="section-container">
        <h3>Empréstimos Ativos (Em posse de alunos)</h3>
        <p class="section-help">Listagem de exemplares que estão atualmente fora da sala de convivência.</p>
        <div class="table-responsive">
            <table class="basic-table">
                <thead>
                    <tr>
                        <th>Exemplar Alugado</th>
                        <th>Aluno Responsável</th>
                        <th>Matrícula</th>
                        <th>Data do Empréstimo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ativas)): ?>
                        <tr>
                            <td colspan="4" class="text-center">Nenhum livro encontra-se alugado neste momento.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($ativas as $ativa): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($ativa['nome_exemplar']); ?></strong></td>
                                <td><?php echo htmlspecialchars($ativa['nome_aluno']); ?></td>
                                <td class="font-mono"><?php echo htmlspecialchars($ativa['matricula_aluno']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($ativa['data_emprestimo'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <br><hr class="section-separator"><br>

    <div class="section-container">
        <h3>Histórico de Transações</h3>
        <p class="section-help">Histórico geral contendo os empréstimos finalizados (devolvidos) e os pendentes.</p>
        <div class="table-responsive">
            <table class="basic-table">
                <thead>
                    <tr>
                        <th>Exemplar</th>
                        <th>Aluno</th>
                        <th>Matrícula</th>
                        <th>Empréstimo</th>
                        <th>Devolução / Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($historico)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhum empréstimo registrado no histórico do sistema.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($historico as $h): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($h['nome_exemplar']); ?></td>
                                <td><?php echo htmlspecialchars($h['nome_aluno']); ?></td>
                                <td class="font-mono"><?php echo htmlspecialchars($h['matricula_aluno']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($h['data_emprestimo'])); ?></td>
                                <td>
                                    <?php if ($h['data_devolucao'] !== null): ?>
                                        <span class="status-tag devolvido">Devolvido em <?php echo date('d/m/Y', strtotime($h['data_devolucao'])); ?></span>
                                    <?php else: ?>
                                        <span class="status-tag pendente">Pendente</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
