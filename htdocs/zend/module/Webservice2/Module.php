<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Webservice;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Webservice\Model\CadastroProduto;
use Webservice\Model\CadastroProdutoTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class Module
{
    public function onBootstrap(MvcEvent $e)
    {
		$serviceManager = $e->getApplication()->getServiceManager();
		
		$config = $serviceManager->get('Config');
		$phpSettings = isset($config['phpSettings']) ? $config['phpSettings'] : array();
		
		if(!empty($phpSettings)) {
			foreach($phpSettings as $key => $value) {
				ini_set($key, $value);
			}
		}
		
		$eventManager        = $e->getApplication()->getEventManager();
		
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
	
	public function getServiceConfig()
    {
         return array(
             'factories' => array(
                 'Webservice\Model\CadastroProdutoTable' =>  function($sm) {
                     $tableGateway = $sm->get('CadastroProdutoTableGateway');
                     $table = new AlbumTable($tableGateway);
                     return $table;
                 },
                 'CadastroProdutoTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Webservice());
                     return new TableGateway('webservice', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }

}
