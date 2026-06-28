<?php
$titulo_pagina = 'Registrar Empréstimo';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/nav.php';
?>

<div class="content-box">
    <h2>Registrar Novo Empréstimo</h2>
    <p>Para registrar o empréstimo, você precisa primeiro localizar o aluno pela matrícula e depois escolher um livro disponível.</p>

    <?php if (!empty($erro)): ?>
        <div class="error-msg">
            <strong>Erro:</strong> <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php endif; ?>

   
    <div class="step-card">
        <h3>Passo 1: Identificação do Aluno</h3>
        <form action="locacao.php" method="GET" class="basic-form inline-form">
            <input type="hidden" name="acao" value="emprestar">
            <div class="form-row-search">
                <input type="text" name="matricula_busca" value="<?php echo htmlspecialchars($matricula ?? ''); ?>" required maxlength="11" placeholder="Matrícula do aluno (11 dígitos)..." class="input-search">
                <button type="submit" class="btn btn-search">Buscar Aluno</button>
            </div>
        </form>
    </div>

    <?php if ($alunoSelecionado): ?>
        <div class="step-card" style="margin-top: 20px;">
            <h3>Passo 2: Detalhes do Empréstimo</h3>
            
            <div class="student-info-badge">
                <p><strong>Aluno Localizado:</strong> <?php echo htmlspecialchars($alunoSelecionado['nome']); ?></p>
                <p><strong>Matrícula:</strong> <?php echo htmlspecialchars($alunoSelecionado['matricula']); ?> | <strong>E-mail:</strong> <?php echo htmlspecialchars($alunoSelecionado['email']); ?></p>
            </div>

            <form action="locacao.php?acao=emprestar" method="POST" class="basic-form">
                
                <input type="hidden" name="id_aluno" value="<?php echo (int)$alunoSelecionado['id']; ?>">
                
                <div class="form-group">
                    <label for="id_livro">Selecione o Exemplar Disponível: *</label>
                    <?php if (empty($livrosDisponiveis)): ?>
                        <div class="info-alert error">Não existem exemplares de livros disponíveis para empréstimo no acervo neste momento.</div>
                        <select id="id_livro" name="id_livro" disabled>
                            <option value="">Nenhum livro disponível</option>
                        </select>
                    <?php else: ?>
                        <select id="id_livro" name="id_livro" required>
                            <option value="">-- Escolha o Livro e o Exemplar --</option>
                            <?php foreach ($livrosDisponiveis as $livro): ?>
                                <option value="<?php echo (int)$livro['id']; ?>">
                                    <?php echo htmlspecialchars($livro['exemplar']); ?> (<?php echo htmlspecialchars($livro['autores']); ?> - Edição: <?php echo htmlspecialchars($livro['edicao']); ?>ª)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" <?php echo empty($livrosDisponiveis) ? 'disabled' : ''; ?>>Confirmar Empréstimo</button>
                    <a href="locacao.php?acao=listar" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    <?php elseif (isset($_GET['matricula_busca']) && !$alunoSelecionado): ?>
        <div class="error-msg" style="margin-top: 20px;">
            <strong>Atenção:</strong> Não foi possível prosseguir para o Passo 2 porque o aluno com a matrícula pesquisada não foi encontrado no sistema. Por favor, cadastre o aluno primeiro ou digite uma matrícula correta.
        </div>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
