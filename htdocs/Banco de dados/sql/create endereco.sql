CREATE SEQUENCE sq_id_endereco INCREMENT 1 MINVALUE 0 MAXVALUE 99999;

create table endereco(
 
    id_endereco int DEFAULT nextval('sq_id_endereco') primary key not null UNIQUE,
    latitude float not null,
    longitude float not null
 
);
 
COMMENT ON TABLE endereco is 'Tabela de enderecos';