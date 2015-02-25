<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Compracerta;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Compracerta\Model\Produto;
use Compracerta\Model\ProdutoTable;
use Compracerta\Model\Endereco;
use Compracerta\Model\EnderecoTable;
use Compracerta\Model\Empresa;
use Compracerta\Model\EmpresaTable;
use Compracerta\Model\Departamento;
use Compracerta\Model\DepartamentoTable;
use Compracerta\Model\Entradaproduto;
use Compracerta\Model\EntradaprodutoTable;
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
                 'Compracerta\Model\ProdutoTable' =>  function($sm) {
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
				 'Compracerta\Model\EnderecoTable' =>  function($sm) {
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
				 'Compracerta\Model\EmpresaTable' =>  function($sm) {
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
				 'Compracerta\Model\DepartamentoTable' =>  function($sm) {
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
				 'Compracerta\Model\EntradaprodutoTable' =>  function($sm) {
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
                 'Adapter' => function ($sm) {
                     return $sm->get('Zend\Db\Adapter\Adapter');
                 },
             ),
         );
     }
}
