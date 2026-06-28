<?php
//As validações estão tudo junto eu não sei se dá pra criar um arquivo separado e importar e estou com preguiça de pesquisar.
class AlunoController {
    private $alunoModel;

    public function __construct() {
        $this->alunoModel = new Aluno();
    }

    public function listar() {
        $alunos = $this->alunoModel->listarTodos();
        $sucesso = $_SESSION['flash_sucesso'] ?? '';
        $erro = $_SESSION['flash_erro'] ?? '';
        unset($_SESSION['flash_sucesso'], $_SESSION['flash_erro']);

        require_once __DIR__ . '/../views/aluno/listar.php';
    }


    public function criar() {
        $erro = '';
        $dados = [
            'nome' => '', 'usuario' => '', 'senha' => '', 
            'matricula' => '', 'usuario_discord' => '', 
            'email' => '', 'celular' => '', 'gestor' => 0
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados['nome'] = trim($_POST['nome'] ?? '');
            $dados['usuario'] = trim($_POST['usuario'] ?? '');
            $dados['matricula'] = trim($_POST['matricula'] ?? '');
            $dados['email'] = trim($_POST['email'] ?? '');
            $dados['usuario_discord'] = trim($_POST['usuario_discord'] ?? '');
            $dados['celular'] = trim($_POST['celular'] ?? '');
            $dados['gestor'] = isset($_POST['gestor']) ? 1 : 0;
            $senhaDigitada = $_POST['senha'] ?? '';

            if (empty($dados['nome']) || empty($dados['usuario']) || empty($dados['matricula']) || empty($dados['email'])) {
                $erro = 'Todos os campos obrigatórios (*) devem ser preenchidos.';
            } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
                $erro = 'O formato do e-mail é inválido.';
            } elseif (!preg_match('/^[0-9]{11}$/', $dados['matricula'])) {
                $erro = 'A matrícula deve conter exatamente 11 dígitos numéricos.';
            } elseif (!empty($dados['celular']) && !preg_match('/^[0-9]{10,11}$/', preg_replace('/\D/', '', $dados['celular']))) {
                $erro = 'O celular deve conter entre 10 e 11 dígitos numéricos (com DDD).';
            } elseif ($dados['gestor'] == 1 && empty($senhaDigitada)) {
                $erro = 'A senha é obrigatória para alunos com privilégio de gestor.';
            }

            if (empty($erro)) {
                
                $dados['senha'] = ($dados['gestor'] == 1) ? password_hash($senhaDigitada, PASSWORD_DEFAULT) : null;
                try {
                    if ($this->alunoModel->salvar($dados)) {
                        $_SESSION['flash_sucesso'] = 'Aluno cadastrado com sucesso!';
                        header('Location: aluno.php?acao=listar');
                        exit;
                    }
                } catch (PDOException $e) {
                    if ($e->getCode() == '23000') {
                        $erroMsg = $e->getMessage();
                        if (strpos($erroMsg, 'usuario') !== false) {
                            $erro = 'O nome de usuário informado já está em uso.';
                        } elseif (strpos($erroMsg, 'matricula') !== false) {
                            $erro = 'A matrícula informada já está cadastrada.';
                        } elseif (strpos($erroMsg, 'email') !== false) {
                            $erro = 'O e-mail informado já está cadastrado.';
                        } else {
                            $erro = 'Erro: Matrícula, Usuário ou E-mail já estão cadastrados no sistema.';
                        }
                    } else {
                        $erro = 'Erro no banco de dados: ' . $e->getMessage();
                    }
                }
            }
        }

        require_once __DIR__ . '/../views/aluno/form.php';
    }
    public function editar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['flash_erro'] = 'ID de aluno inválido.';
            header('Location: aluno.php?acao=listar');
            exit;
        }

        $aluno = $this->alunoModel->buscarPorId($id);
        if (!$aluno) {
            $_SESSION['flash_erro'] = 'Aluno não encontrado.';
            header('Location: aluno.php?acao=listar');
            exit;
        }

        $erro = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => trim($_POST['nome'] ?? ''),
                'usuario' => trim($_POST['usuario'] ?? ''),
                'usuario_discord' => trim($_POST['usuario_discord'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'celular' => trim($_POST['celular'] ?? ''),
                'gestor' => isset($_POST['gestor']) ? 1 : 0
            ];

            $senhaDigitada = $_POST['senha'] ?? '';

            if (empty($dados['nome']) || empty($dados['usuario']) || empty($dados['email'])) {
                $erro = 'Todos os campos obrigatórios (*) devem ser preenchidos.';
            } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
                $erro = 'O formato do e-mail é inválido.';
            } elseif (!empty($dados['celular']) && !preg_match('/^[0-9]{10,11}$/', preg_replace('/\D/', '', $dados['celular']))) {
                $erro = 'O celular deve conter entre 10 e 11 dígitos numéricos.';
            } elseif ($dados['gestor'] == 1 && empty($aluno['senha']) && empty($senhaDigitada)) {
                $erro = 'Uma senha é necessária para promover o aluno a gestor.';
            }

            if (empty($erro)) {
                if (!empty($senhaDigitada)) {
                    $dados['senha'] = password_hash($senhaDigitada, PASSWORD_DEFAULT);
                } else {
                    $dados['senha'] = ''; // Deixa assim
                }

                try {
                    if ($this->alunoModel->atualizar($id, $dados)) {
                        $_SESSION['flash_sucesso'] = 'Aluno atualizado com sucesso!';
                        header('Location: aluno.php?acao=listar');
                        exit;
                    }
                } catch (PDOException $e) {
                    if ($e->getCode() == '23000') {
                        $erroMsg = $e->getMessage();
                        if (strpos($erroMsg, 'usuario') !== false) {
                            $erro = 'O nome de usuário informado já está em uso.';
                        } elseif (strpos($erroMsg, 'email') !== false) {
                            $erro = 'O e-mail informado já está cadastrado.';
                        } else {
                            $erro = 'Erro: Usuário ou E-mail duplicados.';
                        }
                    } else {
                        $erro = 'Erro no banco de dados: ' . $e->getMessage();
                    }
                }
            }
        } else {
            $dados = $aluno;
        }

        require_once __DIR__ . '/../views/aluno/editar.php';
    }
    public function excluir() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['flash_erro'] = 'ID de aluno inválido.';
            header('Location: aluno.php?acao=listar');
            exit;
        }

        if ($this->alunoModel->temLocacaoAtiva($id)) {
            $_SESSION['flash_erro'] = 'Não é possível excluir o aluno. Ele possui empréstimos ativos pendentes de devolução.';
            header('Location: aluno.php?acao=listar');
            exit;
        }

        try {
            if ($this->alunoModel->excluir($id)) {
                $_SESSION['flash_sucesso'] = 'Aluno excluído com sucesso!';
            } else {
                $_SESSION['flash_erro'] = 'Falha ao excluir o aluno.';
            }
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                $_SESSION['flash_erro'] = 'Este aluno não pode ser excluído pois possui histórico de empréstimos registrados (Integridade de Dados).';
            } else {
                $_SESSION['flash_erro'] = 'Erro ao excluir do banco de dados: ' . $e->getMessage();
            }
        }

        header('Location: aluno.php?acao=listar');
        exit;
    }
    public function buscar() {
        $termo = trim($_GET['busca'] ?? '');
        $resultados = [];
        $erro = '';
        
        if (!empty($termo)) {
            try {
                $locacaoModel = new Locacao();
                $resultados = $locacaoModel->pesquisarPorAluno($termo);
            } catch (PDOException $e) {
                $erro = 'Erro de banco de dados ao buscar aluno: ' . $e->getMessage();
            }
        }

        require_once __DIR__ . '/../views/aluno/buscar.php';
    }
}
