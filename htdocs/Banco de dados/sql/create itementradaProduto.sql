
CREATE SEQUENCE sq_id_itemEntradaProd INCREMENT 1 MINVALUE 0 MAXVALUE 99999;

create table itemEntradaProd(
 
	cd_itemEntradaProd int DEFAULT nextval('sq_id_itemEntradaProd') primary key not null UNIQUE,
	cd_entradaProduto int references entradaProduto(cd_entradaProduto),
	qt_ent int not null,
	vl_it_ent float not null
 
);

COMMENT ON TABLE itemEntradaProd is 'Tabela de itens de entrada de produtos';