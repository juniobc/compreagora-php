<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
 

return array(
	'router' => array(
		'routes' => array(
		    
		    'inicio' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/compracerta/areatrabalho',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Compracerta\Controller',
                        'controller'    => 'Areatrabalho',
                        'action'        => 'Areatrabalho',
                    ),
                ),
            ),
            
            'cadastro' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/compracerta/cadastroproduto',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Compracerta\Controller',
                        'controller'    => 'Cadastroproduto',
                        'action'        => 'cadastroproduto',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
		    
			'home' => array(
				'type' => 'Segment',
				'options' => array(
					'route'    => '/[:action]',
					'defaults' => array(
						'controller' => 'Compracerta\Controller\Home',
						'action'     => 'index',
					),
				),
				'may_terminate' => true,
			),
            
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Compracerta\Controller\Index' => 'Compracerta\Controller\IndexController',
            'Compracerta\Controller\Home' => 'Compracerta\Controller\HomeController',
            'Compracerta\Controller\Areatrabalho' => 'Compracerta\Controller\AreatrabalhoController',
            'Compracerta\Controller\Cadastroproduto' => 'Compracerta\Controller\CadastroprodutoController',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'Consultahtml' => 'Compracerta\Controller\Plugin\Consultahtml',
            'ControllerHelper' => 'Compracerta\Controller\Plugin\ControllerHelper'
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'             => __DIR__ . '/../view/layout/layout.phtml',
            'layout/sistema'             => __DIR__ . '/../view/layout/sistema.phtml',
            'error/index'               => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    
    'strategies' => array (    
        'ViewJsonStrategy' 
    )
);
