<div align="center">

# Empresta - SI

</div>


# Sistema Web de Controle de Empréstimo de Livros 📚

Projeto prático desenvolvido para a disciplina de **Web 3** do curso de Bacharelado em Sistemas de Informação da **Universidade Federal Rural do Rio de Janeiro (UFRRJ)**.

O sistema tem como objetivo informatizar e gerenciar o empréstimo de livros do espaço acadêmico (sala de convivência) dos estudantes.

## 🚀 Tecnologias e Arquitetura

Atendendo aos requisitos da disciplina, o projeto foi construído focando nos conceitos fundamentais de desenvolvimento web, utilizando boas práticas de organização de código.

* **Arquitetura:** Padrão **MVC (Model-View-Controller)** para separação de responsabilidades e organização lógica.
* **Back-end:** PHP (Puro/Vanilla, sem frameworks).
* **Banco de Dados:** MariaDB / MySQL (via ambiente XAMPP).
* **Front-end:** HTML5, CSS3 e JavaScript - *Interface construída com o auxílio de um template pronto, conforme permitido nas diretrizes*.
* **Controle de Estado:** Sessões nativas do PHP.

## 📂 Estrutura do Projeto (Padrão MVC)

O código-fonte foi estruturado de forma modular utilizando a arquitetura MVC, separando a regra de negócios, a interface do usuário e o roteamento/lógica:

```text
📦 EMPRESTA-SI
 ┣ 📂 .idea
 ┃ ┣ 📜 .gitignore
 ┃ ┣ 📜 empresta-si.iml
 ┃ ┣ 📜 misc.xml
 ┃ ┣ 📜 modules.xml
 ┃ ┣ 📜 vcs.xml
 ┃ ┗ 📜 workspace.xml
 ┣ 📂 config
 ┣ 📂 controllers
 ┃ ┣ 📜 AlunoController.php
 ┃ ┣ 📜 EmprestimoController.php
 ┃ ┣ 📜 ExemplarController.php
 ┃ ┣ 📜 GestorController.php
 ┃ ┗ 📜 LivroController.php
 ┣ 📂 database
 ┃ ┗ 📜 Database.sql
 ┣ 📂 includes
 ┃ ┗ 📜 auth_check.php
 ┣ 📂 models
 ┃ ┣ 📜 Aluno.php
 ┃ ┣ 📜 Emprestimo.php
 ┃ ┣ 📜 Exemplar.php
 ┃ ┣ 📜 Gestor.php
 ┃ ┗ 📜 Livro.php
 ┣ 📂 public
 ┃ ┣ 📂 assets
 ┃ ┣ 📜 aluno.php
 ┃ ┣ 📜 index.php
 ┃ ┣ 📜 livro.php
 ┃ ┣ 📜 locacao.php
 ┃ ┗ 📜 login.php
 ┣ 📂 views
 ┃ ┣ 📂 aluno
 ┃ ┃ ┣ 📜 editar.php
 ┃ ┃ ┣ 📜 form.php
 ┃ ┃ ┗ 📜 listar.php
 ┃ ┣ 📂 auth
 ┃ ┃ ┗ 📜 login.php
 ┃ ┣ 📂 layout
 ┃ ┃ ┣ 📜 footer.php
 ┃ ┃ ┣ 📜 header.php
 ┃ ┃ ┗ 📜 nav.php
 ┃ ┣ 📂 livro
 ┃ ┃ ┣ 📜 editar.php
 ┃ ┃ ┣ 📜 form.php
 ┃ ┃ ┗ 📜 listar.php
 ┃ ┗ 📂 locacao
 ┃   ┣ 📜 devolver.php
 ┃   ┣ 📜 emprestar.php
 ┃   ┗ 📜 listar.php
 ┣ 📜 .htaccess
 ┣ 📜 LICENSE
 ┗ 📜 README.md
