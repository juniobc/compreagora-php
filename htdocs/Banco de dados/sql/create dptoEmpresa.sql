CREATE SEQUENCE sq_id_dptoEmpresa INCREMENT 1 MINVALUE 0 MAXVALUE 99999;

create table departamento(

	id_dptoEmpresa int DEFAULT nextval('sq_id_dptoEmpresa') primary key not null UNIQUE,
	descricao varchar(30) not null,
	dt_cadstro date,
	qt_usuario smallint,
	id_empresa int references empresa(id_empresa),
	id_endereco int references endereco(id_endereco)

);


