CREATE SEQUENCE sq_id_usuario INCREMENT 1 MINVALUE 0 MAXVALUE 99999;

create table usuario(
 
    cd_usr int DEFAULT nextval('sq_id_usuario') primary key not null UNIQUE,
    cd_endereco int references endereco(id_endereco),
    ds_email varchar(255) NOT NULL UNIQUE,
    ds_senha char(100) NOT NULL,
    chav_cad char(100) DEFAULT NULL,
    confirm_usr char(100) DEFAULT NULL,
    ds_nome varchar(255) NOT NULL,
    ds_sobrenome varchar(255) NOT NULL,
    sexo int NOT NULL,
    tp_perfil int NOT NULL,
    st_usuario int NOT NULL,
    dt_cad char(8) NOT NULL,
    dt_alter char(8),
    dt_login char(8)
 
);
 
COMMENT ON COLUMN usuario.tp_perfil is '0-Usuário Comum; 1-Desenvolvedor; 2-Administrador; 3-Suporte Técnico';
COMMENT ON COLUMN usuario.sexo is '0-Masculino; 1-Feminino; 2-Outros1';
COMMENT ON COLUMN usuario.st_usuario is '0-Ativo; 1-Inativo; 2-Primeiro Acesso';
COMMENT ON TABLE usuario is 'Tabela Clientes';