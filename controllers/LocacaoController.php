<?php

class LocacaoController {
    private $locacaoModel;
    private $alunoModel;
    private $livroModel;

    public function __construct() {
        $this->locacaoModel = new Locacao();
        $this->alunoModel = new Aluno();
        $this->livroModel = new Livro();
    }

    public function listar() {
        $ativas = $this->locacaoModel->listarAtivas();
        $historico = $this->locacaoModel->listarHistorico();
        
        $sucesso = $_SESSION['flash_sucesso'] ?? '';
        $erro = $_SESSION['flash_erro'] ?? '';
        unset($_SESSION['flash_sucesso'], $_SESSION['flash_erro']);

        require_once __DIR__ . '/../views/locacao/listar.php';
    }
    public function emprestar() {
        $erro = '';
        $matricula = trim($_GET['matricula_busca'] ?? '');
        $alunoSelecionado = null;

        if (!empty($matricula)) {
            $alunoSelecionado = $this->alunoModel->buscarPorMatricula($matricula);
            if (!$alunoSelecionado) {
                $erro = 'Aluno com a matrícula informada não foi localizado no sistema.';
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_aluno = filter_input(INPUT_POST, 'id_aluno', FILTER_VALIDATE_INT);
            $id_livro = filter_input(INPUT_POST, 'id_livro', FILTER_VALIDATE_INT);
            $matricula_form = trim($_POST['matricula'] ?? '');
            if (!$id_aluno && !empty($matricula_form)) {
                $aluno = $this->alunoModel->buscarPorMatricula($matricula_form);
                if ($aluno) {
                    $id_aluno = $aluno['id'];
                }
            }

            if (!$id_aluno) {
                $erro = 'Por favor, identifique um aluno cadastrado informando uma matrícula válida.';
            } elseif (!$id_livro) {
                $erro = 'Por favor, selecione um exemplar de livro disponível.';
            } else {
                $resultado = $this->locacaoModel->registrarEmprestimo($id_aluno, $id_livro);

                if ($resultado) {
                    $_SESSION['flash_sucesso'] = 'Empréstimo registrado com sucesso!';
                    header('Location: locacao.php?acao=listar');
                    exit;
                } else {
                    $erro = 'Erro: Não foi possível registrar o empréstimo. O livro pode já ter sido alugado.';
                }
            }
        }

        $livrosDisponiveis = $this->livroModel->listarDisponiveis();

        require_once __DIR__ . '/../views/locacao/emprestar.php';
    }

    public function devolver() {
        $erro = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idsLocacao = $_POST['ids_locacao'] ?? [];

            if (empty($idsLocacao) || !is_array($idsLocacao)) {
                $erro = 'Por favor, selecione pelo menos um livro para devolução.';
            } else {
                $sucessos = 0;
                foreach ($idsLocacao as $id_locacao) {
                    $id_locacao = (int)$id_locacao;
                    if ($this->locacaoModel->registrarDevolucao($id_locacao)) {
                        $sucessos++;
                    }
                }

                if ($sucessos > 0) {
                    $_SESSION['flash_sucesso'] = "$sucessos devolução(ões) registrada(s) com sucesso!";
                    header('Location: locacao.php?acao=listar');
                    exit;
                } else {
                    $erro = 'Erro ao processar as devoluções selecionadas.';
                }
            }
        }
        $locacoesAtivas = $this->locacaoModel->listarAtivas();

        require_once __DIR__ . '/../views/locacao/devolver.php';
    }
    public function indexPublico() {
        $ativas = $this->locacaoModel->listarAtivas();
        $historico = $this->locacaoModel->listarHistorico();
        $devolvidos = array_filter($historico, function($loc) {
            return $loc['data_devolucao'] !== null;
        });

        // Carrega a lista de livros que estão atualmente livres para empréstimo
        $disponiveis = $this->livroModel->listarDisponiveis();

        require_once __DIR__ . '/../views/locacao/index_publico.php'; 
    }
}
