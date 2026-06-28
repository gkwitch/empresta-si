<?php
$titulo_pagina = 'Registrar Devoluções';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/nav.php';
?>

<div class="content-box">
    <h2>Registrar Devoluções de Exemplares</h2>
    <p>Selecione um ou mais livros que estão sendo devolvidos e clique no botão para registrar a devolução em lote.</p>

    <?php if (!empty($erro)): ?>
        <div class="error-msg">
            <strong>Erro:</strong> <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($locacoesAtivas)): ?>
        <div class="info-alert">
            Não há nenhum empréstimo ativo pendente de devolução no momento.
        </div>
        <p><a href="locacao.php?acao=listar" class="btn btn-secondary">Voltar ao Painel</a></p>
    <?php else: ?>
        <form action="locacao.php?acao=devolver" method="POST" id="formDevolucao">
            <div class="table-responsive">
                <table class="basic-table">
                    <thead>
                        <tr>
                            <th width="40"><input type="checkbox" id="select-all-devolucoes"></th>
                            <th>Livro (Exemplar)</th>
                            <th>Aluno</th>
                            <th>Matrícula</th>
                            <th>Data do Empréstimo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($locacoesAtivas as $ativa): ?>
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="ids_locacao[]" value="<?php echo (int)$ativa['id_locacao']; ?>" class="check-devolucao">
                                </td>
                                <td><strong><?php echo htmlspecialchars($ativa['nome_exemplar']); ?></strong></td>
                                <td><?php echo htmlspecialchars($ativa['nome_aluno']); ?></td>
                                <td class="font-mono"><?php echo htmlspecialchars($ativa['matricula_aluno']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($ativa['data_emprestimo'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="form-actions" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Registrar Devolução Selecionada(s)</button>
                <a href="locacao.php?acao=listar" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<script>
document.getElementById('select-all-devolucoes')?.addEventListener('change', function() {
    var checkboxes = document.querySelectorAll('.check-devolucao');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = this.checked;
    }
});
</script>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
