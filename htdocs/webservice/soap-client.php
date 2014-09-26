<?php

$client = new SoapClient("http://quero.com.br/soap/catalog.wsdl");

$catalogId='catalog1';
$response = $client->getCatalogEntry($catalogId);

echo $response;


?>