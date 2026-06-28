<?php

class AuthController {

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['gestor_logged']) && $_SESSION['gestor_logged'] === true) {
            header('Location: locacao.php?acao=listar');
            exit;
        }

        $erro = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $senha = $_POST['senha'] ?? '';

            if (empty($usuario) || empty($senha)) {
                $erro = 'Por favor, preencha todos os campos obrigatórios.';
            } else {
                $gestorModel = new Gestor();
                $gestor = $gestorModel->autenticar($usuario, $senha);

                if ($gestor) {
                    session_regenerate_id(true);

                    $_SESSION['gestor_logged'] = true;
                    $_SESSION['gestor_id'] = $gestor['id'];
                    $_SESSION['gestor_nome'] = $gestor['nome'];
                    $_SESSION['gestor_usuario'] = $gestor['usuario'];

                    header('Location: locacao.php?acao=listar');
                    exit;
                } else {
                    $erro = 'Usuário ou senha incorretos, ou usuário não possui perfil de gestor.';
                }
            }
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        header('Location: index.php');
        exit;
    }
}
