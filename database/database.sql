USE trabalhos;

CREATE TABLE IF NOT EXISTS ALUNOS (

	matricula	VARCHAR(9)		NOT NULL,
    nome		VARCHAR(100)	NOT NULL,
    email		VARCHAR(50)		NOT NULL,
    media		FLOAT,
    
	PRIMARY KEY (matricula)
);

CREATE TABLE IF NOT EXISTS TRABALHOS (

    data		DATE			NOT NULL,
	aluno		VARCHAR(9)		NOT NULL,
    slide		VARCHAR(3)		NOT NULL,
    assunto		VARCHAR(20)		NOT NULL,
    codigo		TEXT			NOT NULL,
    correto		VARCHAR(50)		NOT NULL,

	PRIMARY KEY (aluno,slide,assunto)
);