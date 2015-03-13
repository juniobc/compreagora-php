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
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

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
		
		$eventManager = $e->getApplication()->getEventManager();
		
		//$eventManager->attach('route', array($this, 'checkAuthenticated'));
		
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
                 'Adapter' => function ($sm) {
                     return $sm->get('Zend\Db\Adapter\Adapter');
                 },
                 'Compracerta\Storage\AuthStorage' => function($sm){
                    return new \Compracerta\Storage\AuthStorage('econoom');  
                },
                'AuthService' => function($sm) {
                    //My assumption, you've alredy set dbAdapter
                    //and has users table with columns : user_name and pass_word
                    //that password hashed with md5
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter, 
                                                      'departamento','nm_dpto','passwd', 'MD5(?)');
                     
                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
                    $authService->setStorage($sm->get('Compracerta\Storage\AuthStorage'));
                      
                    return $authService;
                },
             ),
         );
     }
}
