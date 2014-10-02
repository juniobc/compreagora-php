CREATE SEQUENCE sq_id_entradaProduto INCREMENT 1 MINVALUE 0 MAXVALUE 99999;

create table entradaProduto(
 
	cd_entradaProduto int DEFAULT nextval('sq_id_entradaProduto') primary key not null UNIQUE,
	id_endereco int references endereco(id_endereco),
	id_empresa int references empresa(id_empresa),
	cd_usr int references usuario(cd_usr),
	dt_ent date not null
 
);

COMMENT ON TABLE entradaProduto is 'Tabela entrada de produtos';

