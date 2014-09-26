<?php 

$request_xml = <<< END 
	<?xml version="1.0"?>
	<methodCall>
		<methodName>hello</methodName>
		  <params>
			<param>
			  <value>
				<string>Deepak</string>
			  </value>
			</param>
		  </params>
	<methodCall>
END;

$response = xmlrpc_server_call_method( $xmlrpc_server, $request_xml, '', array(output_type => "xml"));

print $response;

?>