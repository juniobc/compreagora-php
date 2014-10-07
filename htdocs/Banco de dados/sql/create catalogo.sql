CREATE SEQUENCE sq_id_catalogo INCREMENT 1 MINVALUE 0 MAXVALUE 99999;

create table catalogo(
 
	cd_catalogo int DEFAULT nextval('sq_id_catalogo') primary key not null UNIQUE,
	ds_catalogo varchar(130)
 
);

COMMENT ON TABLE catalogo is 'Tabela catalogo';

