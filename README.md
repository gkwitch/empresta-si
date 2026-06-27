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

```

## 💻 Como Rodar o Projeto Localmente (Passo a Passo)

Siga as instruções abaixo para configurar o ambiente de desenvolvimento local utilizando o **XAMPP**.

### 1. Preparar o Diretório do Projeto
1. Certifique-se de que tem o **XAMPP** instalado no seu computador.
2. Navegue até a pasta de ficheiros públicos do XAMPP (geralmente em `C:\xampp\htdocs` no Windows ou `/opt/lampp/htdocs` no Linux).
3. Coloque a pasta do projeto **EMPRESTA-SI** diretamente dentro do diretório `htdocs`.
    * *Se usar o Git, abra o terminal dentro de `htdocs` e execute:*
      ```bash
      git clone [https://github.com/seu-usuario/EMPRESTA-SI.git](https://github.com/seu-usuario/EMPRESTA-SI.git)
      ```

### 2. Iniciar os Serviços no XAMPP
1. Abra o **XAMPP Control Panel** (Painel de Controlo do XAMPP).
2. Clique no botão **Start** ao lado de **Apache**.
3. Clique no botão **Start** ao lado de **MySQL**.
4. Certifique-se de que ambos os módulos ficam com o fundo verde, indicando que estão ativos.

### 3. Configurar o Banco de Dados (MariaDB/MySQL)
1. Abra o seu navegador web e aceda ao painel do phpMyAdmin: `http://localhost/phpmyadmin/`
2. No menu lateral esquerdo, clique em **Novo** (New) para criar um novo banco de dados.
3. No campo "Nome da base de dados", digite exatamente o nome configurado na sua aplicação (por exemplo, `empresta_si`) e clique em **Criar**.
4. Com o banco de dados recém-criado selecionado, clique na aba **Importar** (Import) no menu superior.
5. Clique em **Escolher ficheiro** (Choose File) e selecione o ficheiro de script SQL do projeto, localizado em:
   `EMPRESTA-SI/database/Database.sql`
6. Vá até o final da página e clique no botão **Importar** (Go/Import). Aguarde a mensagem de sucesso indicando que as tabelas foram criadas.

### 4. Configurar as Credenciais de Conexão no PHP
Como o projeto utiliza a estrutura nativa do XAMPP, ajuste o ficheiro de configuração de ligação ao banco de dados (verifique a sua pasta `config/` ou os ficheiros dentro de `models/` onde a conexão PDO/MySQLi é instanciada) com os seguintes parâmetros padrão do XAMPP:

* **Host:** `localhost`
* **Dbname:** `empresta_si` (ou o nome que deu ao banco no passo 3)
* **Username:** `root`
* **Password:** ` ` (vazio/sem senha)

### 5. Aceder ao Sistema pelo Navegador
O projeto está estruturado seguindo o padrão MVC, onde o ponto de entrada público da aplicação e os ficheiros de visualização principais estão concentrados dentro da pasta `public/`.

Para abrir o sistema, digite o seguinte endereço no seu navegador:
👉 **`http://localhost/EMPRESTA-SI/public/`**

Ao aceder a este URL, o servidor Apache lerá o ficheiro `index.php` contido na pasta pública e iniciará a aplicação corretamente.


## 👥 Desenvolvedores 

Este projeto foi desenvolvido em grupo pelos seguintes alunos do curso de Bacharelado em Sistemas de Informação:

* **Arthur Herbert**
* **Gleyce Kethelin Oliveira**
* **Maria Luisa de Lemos**
* **Nathan Teixeira**

---
