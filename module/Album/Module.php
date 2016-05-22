<?php 

/**
 * In order to load and configure a module, Zend Framework 2 has a ModuleManager. 
 * This will look for Module.php in the root of the module directory (module/Album) 
 * and expect to find a class called Album\Module within it. That is, the classes
 *  within a given module will have the namespace of the module’s name, which is 
 * the directory name of the module.
 */


namespace Album;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
  /**
   * Our getAutoloaderConfig() method returns an array that is compatible with ZF2’s 
   * AutoloaderFactory. We configure it so that we add a class map file to the 
   * ClassMapAutoloader and also add this module’s namespace to the StandardAutoloader. 
   * The standard autoloader requires a namespace and the path where to find the 
   * files for that namespace. It is PSR-0 compliant and so classes map directly 
   * to files as per the PSR-0 rules.
   * @return array
   */
  public function getAutoloaderConfig() 
  {
    $config = array(
      'Zend\Loader\ClassMapAutoloader' => array(__DIR__ . '/autoload_classmap.php'),
      'Zen\Loader\StandardAutoloader' => array('namespaces' => array(__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__)
      ),
    );
    
    return $config;
  }

  public function getConfig() 
  {
    return include __DIR__ . '/config/module.config.php';
  }

}