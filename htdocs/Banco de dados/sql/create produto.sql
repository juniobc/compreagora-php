CREATE SEQUENCE sq_id_produto INCREMENT 1 MINVALUE 0 MAXVALUE 99999;

create table produto(
 
	id_produto int DEFAULT nextval('sq_id_produto') primary key not null UNIQUE,
	cd_catalogo int references catalogo(cd_catalogo),
	vl_produto float not null,
	ds_produto varchar(100) not null
 
);

COMMENT ON TABLE produto is 'Tabela produto';