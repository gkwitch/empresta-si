<?php

class LivroController {
    private $livroModel;

    public function __construct() {
        $this->livroModel = new Livro();
    }

    public function listar() {
        $livros = $this->livroModel->listarTodos();
        $sucesso = $_SESSION['flash_sucesso'] ?? '';
        $erro = $_SESSION['flash_erro'] ?? '';
        unset($_SESSION['flash_sucesso'], $_SESSION['flash_erro']);

        require_once __DIR__ . '/../views/livro/listar.php';
    }

    public function criar() {
        $erro = '';
        $dados = [
            'titulo' => '', 'autores' => '', 'editora' => '', 
            'edicao' => '', 'ano_publicacao' => ''
        ];
        $quantidade = 1;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados['titulo'] = trim($_POST['titulo'] ?? '');
            $dados['autores'] = trim($_POST['autores'] ?? '');
            $dados['editora'] = trim($_POST['editora'] ?? '');
            $dados['edicao'] = filter_input(INPUT_POST, 'edicao', FILTER_VALIDATE_INT);
            $dados['ano_publicacao'] = filter_input(INPUT_POST, 'ano_publicacao', FILTER_VALIDATE_INT);
            $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);

            $anoAtual = (int)date('Y');

            if (empty($dados['titulo']) || empty($dados['autores']) || empty($dados['editora']) || !$dados['edicao'] || !$dados['ano_publicacao']) {
                $erro = 'Todos os campos devem ser preenchidos com valores válidos.';
            } elseif ($dados['edicao'] <= 0) {
                $erro = 'A edição deve ser um número inteiro maior que zero.';
            } elseif ($dados['ano_publicacao'] < 1500 || $dados['ano_publicacao'] > $anoAtual + 1) {
                $erro = 'O ano de publicação informado é inválido.';
            } elseif (!$quantidade || $quantidade <= 0) {
                $erro = 'A quantidade de exemplares deve ser no mínimo 1.';
            }

            if (empty($erro)) {
                try {
                    if ($this->livroModel->salvar($dados, $quantidade)) {
                        $_SESSION['flash_sucesso'] = "Livro cadastrado com sucesso! ($quantidade exemplares criados)";
                        header('Location: livro.php?acao=listar');
                        exit;
                    }
                } catch (PDOException $e) {
                    $erro = 'Erro no banco de dados: ' . $e->getMessage();
                }
            }
        }

        require_once __DIR__ . '/../views/livro/form.php';
    }
    public function editar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['flash_erro'] = 'ID de livro inválido.';
            header('Location: livro.php?acao=listar');
            exit;
        }

        $livro = $this->livroModel->buscarPorId($id);
        if (!$livro) {
            $_SESSION['flash_erro'] = 'Exemplar não encontrado.';
            header('Location: livro.php?acao=listar');
            exit;
        }

        $erro = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'titulo' => trim($_POST['titulo'] ?? ''),
                'autores' => trim($_POST['autores'] ?? ''),
                'editora' => trim($_POST['editora'] ?? ''),
                'edicao' => filter_input(INPUT_POST, 'edicao', FILTER_VALIDATE_INT),
                'ano_publicacao' => filter_input(INPUT_POST, 'ano_publicacao', FILTER_VALIDATE_INT),
                'exemplar' => trim($_POST['exemplar'] ?? ''),
                'alugado' => $livro['alugado'] 
            ];

            $anoAtual = (int)date('Y');

            if (empty($dados['titulo']) || empty($dados['autores']) || empty($dados['editora']) || !$dados['edicao'] || !$dados['ano_publicacao'] || empty($dados['exemplar'])) {
                $erro = 'Todos os campos devem ser preenchidos com valores válidos.';
            } elseif ($dados['edicao'] <= 0) {
                $erro = 'A edição deve ser um número inteiro maior que zero.';
            } elseif ($dados['ano_publicacao'] < 1500 || $dados['ano_publicacao'] > $anoAtual + 1) {
                $erro = 'O ano de publicação informado é inválido.';
            }

            if (empty($erro)) {
                try {
                    if ($this->livroModel->atualizar($id, $dados)) {
                        $_SESSION['flash_sucesso'] = 'Exemplar de livro atualizado com sucesso!';
                        header('Location: livro.php?acao=listar');
                        exit;
                    }
                } catch (PDOException $e) {
                    $erro = 'Erro no banco de dados: ' . $e->getMessage();
                }
            }
        } else {
            $dados = $livro;
        }

        require_once __DIR__ . '/../views/livro/editar.php';
    }

    public function excluir() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['flash_erro'] = 'ID de livro inválido.';
            header('Location: livro.php?acao=listar');
            exit;
        }

        $livro = $this->livroModel->buscarPorId($id);
        if (!$livro) {
            $_SESSION['flash_erro'] = 'Exemplar não encontrado.';
            header('Location: livro.php?acao=listar');
            exit;
        }

        if ($livro['alugado'] == 1) {
            $_SESSION['flash_erro'] = 'Não é possível excluir o exemplar pois ele está atualmente alugado (locação ativa).';
            header('Location: livro.php?acao=listar');
            exit;
        }

        try {
            if ($this->livroModel->excluir($id)) {
                $_SESSION['flash_sucesso'] = 'Exemplar excluído com sucesso!';
            } else {
                $_SESSION['flash_erro'] = 'Falha ao excluir o exemplar.';
            }
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                $_SESSION['flash_erro'] = 'Este exemplar não pode ser excluído pois possui histórico de locações passadas associado.';
            } else {
                $_SESSION['flash_erro'] = 'Erro ao excluir do banco de dados: ' . $e->getMessage();
            }
        }

        header('Location: livro.php?acao=listar');
        exit;
    }

    public function buscar() {
        $termo = trim($_GET['busca'] ?? '');
        $resultados = [];
        $erro = '';

        if (!empty($termo)) {
            try {
                $resultados = $this->livroModel->pesquisarPorTitulo($termo);
            } catch (PDOException $e) {
                $erro = 'Erro de banco de dados ao buscar livro: ' . $e->getMessage();
            }
        }

        require_once __DIR__ . '/../views/livro/buscar_livro.php';
    }
}
