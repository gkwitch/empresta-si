# Documento de Entrega — Trabalho Prático Web 1

**Sistema Web de Controle de Empréstimo de Livros**
DECOMP-ICE/UFRRJ — Bacharelado em Sistemas de Informação

---

## 1. Integrantes do Grupo

ARTHUR HERBERT NASCIMENTO PAULINO 20250017854

NATHAN TEIXEIRA DE OLIVEIRA 20250024895

GLEICY KETHELIN OLIVEIRA COSTA 20250027000

MARIA LUISA DE LEMOS DO NASCIMENTO 20250016866

## 2. Repositório do Projeto

**GitHub:** [[link do repositório](https://github.com/gkwitch/empresta-si)]

---

## 3. Usuários do Sistema para Avaliação

| Perfil | Usuário | Senha    | Observação                                                      |
| ------ | ------- | -------- | --------------------------------------------------------------- |
| Gestor | admin   | admin123 | Acesso completo às funcionalidades administrativas              |
| Aluno  | —       | —        | Dados cadastrados via gestor; alunos não fazem login no sistema |

---

## 3. Usuários do Sistema para Avaliação

| Perfil | Usuário | Senha    | Observação                                                      |
| ------ | ------- | -------- | --------------------------------------------------------------- |
| Gestor | admin   | admin123 | Acesso completo às funcionalidades administrativas              |
| Aluno  | —       | —        | Dados cadastrados via gestor; alunos não fazem login no sistema |

---

## 4. Requisitos Implementados

### 6.1 Autenticação de Gestores

- [x] Login com usuário e senha
- [x] Logout (encerramento de sessão)
- [x] Controle de sessão PHP — funcionalidades administrativas exclusivas de gestor autenticado

### 6.2 Cadastro de Alunos

- [x] Cadastro de aluno com nome completo, nome de usuário, matrícula, usuário Discord, e-mail e celular
- [x] Edição de dados do aluno (exceto matrícula)
- [x] Exclusão de cadastro, com verificação de pendências de empréstimo

### 6.3 Cadastro de Livros, Empréstimos e Devoluções

- [x] Cadastro de livro com título, autor(es), editora, edição, ano de publicação e quantidade de exemplares
- [x] Identificação individual de exemplares (ex: "Engenharia de Software – Exemplar 1")
- [x] Edição e exclusão de livros (exclusivo do gestor)
- [x] Registro de empréstimo com matrícula do aluno, exemplar e data
- [x] Bloqueio de empréstimo de exemplar já emprestado
- [x] Registro de devolução com retorno do exemplar à disponibilidade
- [x] Histórico de empréstimos preservado após devolução

### 6.4 Consulta de Empréstimos Ativos

- [x] Listagem pública com livro, exemplar, nome do aluno e data do empréstimo
- [x] Exibição apenas de empréstimos não devolvidos

### 6.5 Pesquisa por Livro _(opcional)_

- [x] Consulta de disponibilidade do exemplar
- [x] Exibição de quem está com o exemplar e data do empréstimo

### 6.6 Pesquisa por Aluno _(opcional)_

- [x] Consulta dos livros atualmente emprestados pelo aluno
- [x] Exibição das datas de empréstimo

---

## 5. Validação de Dados

- [x] Validação no cliente (HTML + JavaScript): campos obrigatórios, formato de e-mail, campos numéricos, datas válidas e limites de tamanho
- [x] Validação no servidor (PHP): verificação de todos os dados críticos antes da gravação no banco

---

## 6. Segurança

- [x] Controle de sessão PHP
- [x] Prepared statements (PDO) em todas as queries
- [x] Sanitização de entradas
- [x] Proteção contra SQL Injection

---

## 7. Tecnologias Utilizadas

- **Back-end:** PHP (sem frameworks)
- **Banco de dados:** MySQL via XAMPP
- **Front-end:** HTML, CSS e JavaScript (usando tamplete pronto)
- **Ferramenta de banco:** phpMyAdmin
