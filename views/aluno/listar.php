<?php
$titulo_pagina = 'Gerenciar Alunos';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/nav.php';
?>

<div class="content-box">
    <div class="box-header">
        <h2>Gerenciamento de Alunos</h2>
        <a href="aluno.php?acao=criar" class="btn btn-add">Cadastrar Novo Aluno</a>
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

    <div class="table-responsive">
        <table class="basic-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Matrícula</th>
                    <th>Usuário</th>
                    <th>E-mail</th>
                    <th>Celular</th>
                    <th>Discord</th>
                    <th>Gestor?</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($alunos)): ?>
                    <tr>
                        <td colspan="8" class="text-center">Nenhum aluno cadastrado no sistema.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                            <td class="font-mono"><?php echo htmlspecialchars($aluno['matricula']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['usuario']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['email']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['celular'] ?? 'Não informado'); ?></td>
                            <td><?php echo htmlspecialchars($aluno['usuario_discord'] ?? 'Não informado'); ?></td>
                            <td><?php echo $aluno['gestor'] == 1 ? '<strong>Sim</strong>' : 'Não'; ?></td>
                            <td class="table-actions">
                                <a href="aluno.php?acao=editar&id=<?php echo $aluno['id']; ?>" class="btn-action edit">Editar</a>
                                <a href="aluno.php?acao=excluir&id=<?php echo $aluno['id']; ?>" class="btn-action delete" onclick="return confirm('Deseja realmente excluir este aluno?');">Excluir</a>
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
