<?php

function getCatalogEntry($catalogId) { 
	if($catalogId=='catalog1')
	
		return "<HTML>
		<HEAD>
		<TITLE>Catalog</TITLE>
		</HEAD
		<BODY>
		<p> </p>
		<table border>
		<tr><th>CatalogId</th>
		<th>Journal</th><th>Section
		</th><th>Edition</th><th>
		Title</th><th>Author</th>
		</tr><tr><td>catalog1</td>
		<td>IBM developerWorks</td><td>
		XML</td><td>October 2005</td>
		<td>JAXP validation</td>
		<td>Brett McLaughlin</td></tr>
		</table>
		</BODY>
		</HTML>";

	elseif ($catalogId=='catalog2')

		return "<HTML>
		<HEAD>
		<TITLE>Catalog</TITLE>
		</HEAD
		<BODY>
		<p> </p>
		<table border>

		<tr><th>CatalogId</th><th>
		Journal</th><th>Section</th>
		<th>Edition</th><th>Title
		</th><th>Author
		</th></tr><tr><td>catalog1
		</td><td>IBM developerWorks</td>
		<td>XML</td><td>July 2006</td>
		<td>The Java XPath API
		</td><td>Elliotte Harold</td>
		</tr>
		</table>
		</BODY>
		</HTML>";
} 

ini_set("soap.wsdl_cache_enabled", "0"); 
$server = new SoapServer("http://quero.com.br/soap/catalog.wsdl"); 
$server->addFunction("getCatalogEntry"); 
$server->handle(); 

?>