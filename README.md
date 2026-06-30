<div align="center">

# 📚 Empresta-SI
### Sistema Web de Controle de Empréstimo de Livros

</div>

---

Projeto prático desenvolvido para a disciplina de **Web 3** do curso de Bacharelado em Sistemas de Informação da **Universidade Federal Rural do Rio de Janeiro (UFRRJ)**.

O sistema tem como objetivo informatizar e gerenciar o empréstimo de livros do espaço acadêmico (sala de convivência) dos estudantes.

---

## 🚀 Tecnologias e Arquitetura

O projeto foi construído focando nos conceitos fundamentais de desenvolvimento web, utilizando boas práticas de organização de código.

| Camada | Tecnologia |
|---|---|
| Arquitetura | Padrão **MVC** (Model-View-Controller) |
| Back-end | 🐘 PHP (Vanilla, sem frameworks) |
| Banco de Dados | 🐬 MariaDB / MySQL (via XAMPP) |
| Front-end | |
| Controle de Estado | Sessões nativas do PHP |

> A interface foi construída com o auxílio de um template pronto, conforme permitido nas diretrizes da disciplina.

---

## 📂 Estrutura do Projeto (Padrão MVC)

```text
📦 EMPRESTA-SI
 ┣ 📂 .idea                    # Arquivos de configuração da IDE
 ┣ 📂 config                   # Configuração global (ex: conexão com o banco)
 ┣ 📂 controllers              # (Controller) Recebe requisições e gerencia o fluxo
 ┃ ┣ 🐘 AlunoController.php
 ┃ ┣ 🐘 EmprestimoController.php
 ┃ ┣ 🐘 ExemplarController.php
 ┃ ┣ 🐘 GestorController.php
 ┃ ┗ 🐘 LivroController.php
 ┣ 📂 database                 # Script SQL para criação do banco de dados
 ┃ ┗ 📄 Database.sql
 ┣ 📂 includes                 # Scripts auxiliares e de segurança
 ┃ ┗ 🐘 auth_check.php
 ┣ 📂 models                   # (Model) Entidades do banco e regras de negócio
 ┃ ┣ 🐘 Aluno.php
 ┃ ┣ 🐘 Emprestimo.php
 ┃ ┣ 🐘 Exemplar.php
 ┃ ┣ 🐘 Gestor.php
 ┃ ┗ 🐘 Livro.php
 ┣ 📂 public                   # Ponto de entrada público e arquivos estáticos
 ┃ ┣ 📂 assets
 ┃ ┣ 🐘 aluno.php
 ┃ ┣ 🐘 index.php
 ┃ ┣ 🐘 livro.php
 ┃ ┣ 🐘 locacao.php
 ┃ ┗ 🐘 login.php
 ┣ 📂 views                    # (View) Interfaces gráficas do usuário
 ┃ ┣ 📂 aluno
 ┃ ┃ ┣ 🐘 editar.php
 ┃ ┃ ┣ 🐘 form.php
 ┃ ┃ ┗ 🐘 listar.php
 ┃ ┣ 📂 auth
 ┃ ┃ ┗ 🐘 login.php
 ┃ ┣ 📂 layout
 ┃ ┃ ┣ 🐘 footer.php
 ┃ ┃ ┣ 🐘 header.php
 ┃ ┃ ┗ 🐘 nav.php
 ┃ ┣ 📂 livro
 ┃ ┃ ┣ 🐘 editar.php
 ┃ ┃ ┣ 🐘 form.php
 ┃ ┃ ┗ 🐘 listar.php
 ┃ ┗ 📂 locacao
 ┃   ┣ 🐘 devolver.php
 ┃   ┣ 🐘 emprestar.php
 ┃   ┗ 🐘 listar.php
 ┣ 📄 .htaccess                # Configurações do servidor Apache
 ┣ 📄 LICENSE
 ┗ 📄 README.md
```

---

## ⚙️ Como Rodar o Projeto

### Pré-requisitos

- [XAMPP](https://www.apachefriends.org/) instalado em `/opt/lampp`

---

### 🚀 Passo 1 — Iniciar o XAMPP

```bash
sudo /opt/lampp/lampp start
```

Os serviços Apache e MySQL devem iniciar com mensagens `ok`.


---

### 🔗 Passo 2 — Criar o Atalho do Projeto

O XAMPP serve arquivos a partir de `/opt/lampp/htdocs`. mova o seu projeto para essa pasta htdocs ou ja clone direto nela

```bash
 para clonar faça um git clone https://github.com/gkwitch/empresta-si.git dentro da raiz - /opt/lampp/htdocs/
```
---

### 🗄️ Passo 3 — Subir o Banco de Dados

1. Acesse **`http://localhost/phpmyadmin`** no navegador.
2. No menu esquerdo, clique em **Novo**.
3. Digite o nome do banco de dados e clique em **Criar**.
4. Clique no banco recém-criado na lista da esquerda.
5. Vá na aba **Importar** lá nas opções no topo→ **Escolher arquivo**.
6. Selecione o arquivo `database/Database.sql`.
7. Clique em **Executar** e aguarde a mensagem de sucesso.


---

### 🎉 Passo 4 — Acessar o Sistema

```bash
 em outra aba do navegador cole http://localhost/empresta-si/public
```

Pronto acesso ao sistema.

# Para o acesso ao gestor:


```bash
 login: admin
 senha: admin123
```
## 👥 Desenvolvedores 

Este projeto foi desenvolvido em grupo pelos seguintes alunos do curso de Bacharelado em Sistemas de Informação:

* **Arthur Herbert**
* **Gleicy Kethelin Oliveira**
* **Maria Luisa de Lemos**
* **Nathan Teixeira de Oliveira**

---

  
