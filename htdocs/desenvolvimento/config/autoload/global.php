<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'db' => array(
         'driver'         => 'Pdo',
         'dsn'            => 'pgsql:host=127.0.0.1;dbname=compracerta;port=5432',
         'username'       => 'postgres',
         'password'       => 'promptc2010456',
     ),
     'service_manager' => array(
         'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'Log' => function ($sm) {
                $log = new Zend\Log\Logger();
                $writer = new Zend\Log\Writer\Stream('data/logs/logfile.log');
                $log->addWriter($writer);
        
                return $log;
            },
            'texto' => function ($sm) {
                $texto = new Zend\Log\Logger();
                $writer = new Zend\Log\Writer\Stream('data/arquivos/texto.txt');
                $texto->addWriter($writer);
        
                return $texto;
            }
         ),
         
     ),
);
