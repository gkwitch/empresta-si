-- 1. Gestores
CREATE TABLE gestores (
    id       INT          NOT NULL AUTO_INCREMENT,
    nome     VARCHAR(100) NOT NULL,
    username VARCHAR(50)  NOT NULL UNIQUE,
    senha    VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

-- 2. Alunos
CREATE TABLE alunos (
    matricula      VARCHAR(20)  NOT NULL,
    nome_completo  VARCHAR(150) NOT NULL,
    email          VARCHAR(100),
    discord        VARCHAR(100),
    celular        VARCHAR(20),
    PRIMARY KEY (matricula)
);

-- 3. Livros
CREATE TABLE livros (
    id             INT          NOT NULL AUTO_INCREMENT,
    titulo         VARCHAR(200) NOT NULL,
    autores        VARCHAR(200),
    editora        VARCHAR(100),
    edicao         VARCHAR(20),
    ano_publicacao YEAR,
    PRIMARY KEY (id)
);

-- 4. Exemplares
CREATE TABLE exemplares (
    id         INT          NOT NULL AUTO_INCREMENT,
    livro_id   INT          NOT NULL,
    codigo     VARCHAR(100) NOT NULL,
    disponivel TINYINT(1)   NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    FOREIGN KEY (livro_id) REFERENCES livros(id)
);

-- 5. Empréstimos
CREATE TABLE emprestimos (
    id               INT         NOT NULL AUTO_INCREMENT,
    exemplar_id      INT         NOT NULL,
    aluno_matricula  VARCHAR(20) NOT NULL,
    data_emprestimo  DATE        NOT NULL,
    data_devolucao   DATE        DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (exemplar_id)     REFERENCES exemplares(id),
    FOREIGN KEY (aluno_matricula) REFERENCES alunos(matricula)
);