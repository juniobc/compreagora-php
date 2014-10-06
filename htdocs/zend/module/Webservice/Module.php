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
use Webservice\Model\Produto;
use Webservice\Model\ProdutoTable;
use Webservice\Model\Endereco;
use Webservice\Model\EnderecoTable;
use Webservice\Model\Empresa;
use Webservice\Model\EmpresaTable;
use Webservice\Model\Departamento;
use Webservice\Model\DepartamentoTable;
use Webservice\Model\Entradaproduto;
use Webservice\Model\EntradaprodutoTable;
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
                 'Webservice\Model\ProdutoTable' =>  function($sm) {
                     $tableGateway = $sm->get('ProdutoTableGateway');
                     $table = new ProdutoTable($tableGateway);
                     return $table;
                 },
                 'ProdutoTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Produto());
                     return new TableGateway('produto', $dbAdapter, null, $resultSetPrototype);
                 },
				 'Webservice\Model\EnderecoTable' =>  function($sm) {
                     $tableGateway = $sm->get('EnderecoTableGateway');
                     $table = new EnderecoTable($tableGateway);
                     return $table;
                 },
                 'EnderecoTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Endereco());
                     return new TableGateway('endereco', $dbAdapter, null, $resultSetPrototype);
                 },
				 'Webservice\Model\EmpresaTable' =>  function($sm) {
                     $tableGateway = $sm->get('EmpresaTableGateway');
                     $table = new EmpresaTable($tableGateway);
                     return $table;
                 },
                 'EmpresaTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Empresa());
                     return new TableGateway('empresa', $dbAdapter, null, $resultSetPrototype);
                 },
				 'Webservice\Model\DepartamentoTable' =>  function($sm) {
                     $tableGateway = $sm->get('DepartamentoTableGateway');
                     $table = new DepartamentoTable($tableGateway);
                     return $table;
                 },
                 'DepartamentoTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Departamento());
                     return new TableGateway('departamento', $dbAdapter, null, $resultSetPrototype);
                 },
				 'Webservice\Model\EntradaprodutoTable' =>  function($sm) {
                     $tableGateway = $sm->get('EntradaprodutoTableGateway');
                     $table = new EntradaprodutoTable($tableGateway);
                     return $table;
                 },
                 'EntradaprodutoTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Entradaproduto());
                     return new TableGateway('entradaproduto', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
}
