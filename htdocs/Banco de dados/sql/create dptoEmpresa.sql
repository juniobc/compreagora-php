CREATE SEQUENCE sq_id_dptoEmpresa INCREMENT 1 MINVALUE 0 MAXVALUE 99999;

create table departamento(

	id_dptoEmpresa int DEFAULT nextval('sq_id_dptoEmpresa') primary key not null UNIQUE,
	descricao varchar(30) not null,
	dt_cadstro date,
	id_empresa int not null references empresa(id_empresa),
	id_endereco int not null references endereco(id_endereco)

);


