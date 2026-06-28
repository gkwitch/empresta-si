<?php

// isso aqui 
class Gestor extends Aluno {
    
    public function autenticar($usuario, $senha) {
        
        $dadosUsuario = $this->buscarPorUsuario($usuario);
        
        if ($dadosUsuario && $dadosUsuario['gestor'] == 1) {
            if (password_verify($senha, $dadosUsuario['senha'])) {
                return $dadosUsuario;
            }
        }
        
        return false;
    }
}
