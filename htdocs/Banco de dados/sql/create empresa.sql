CREATE SEQUENCE sq_id_empresa INCREMENT 1 MINVALUE 0 MAXVALUE 999999;
 
create table empresa(
 
	id_empresa int DEFAULT nextval('sq_id_empresa') primary key not null UNIQUE,
	cnpj9 int not null,
	cnpj4 int default 0,
	cnpj2 int not null,
	rasaoSocial varchar(200) not null,
	nomeFantasia varchar(200) not null
 
);
 
COMMENT ON TABLE empresa is 'Tabela empresa';
