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

use Album\Model\Album;
use Album\Model\AlbumTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;



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
  /**
   * This method simply loads the config/module.config.php file.
   * @return type
   */
  public function getConfig() 
  {
    return include __DIR__ . '/config/module.config.php';
  }

  
  /**
   * To configure the ServiceManager, we can either supply the name of the class 
   * to be instantiated or a factory (closure or callback) that instantiates the 
   * object when the ServiceManager needs it. We start by implementing getServiceConfig()
   * to provide a factory that creates an AlbumTable. 
   * 
   * @return type
   */
  
  // This method returns an array of factories that are all merged together by 
  // the ModuleManager before passing them to the ServiceManager. 
  public function getServiceConfig() 
  {
    // The factory for Album\Model\AlbumTable uses the ServiceManager to create an AlbumTableGateway to pass to the AlbumTable.
    return array(
      'factories' => array(
        'Album\Model\AlbumTable' => function ($sm) {
          $tableGateway = $sm->get('AlbumTableGateway');
          $table = new AlbumTable($tableGateway);
          return $table;
        },
        'AlbumTableGateway' => function ($sm) {
          // We also tell the ServiceManager that an AlbumTableGateway is created by getting a Zend\Db\Adapter\Adapter 
          // (also from the ServiceManager) and using it to create a TableGateway object.
          $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
          // The TableGateway is told to use an Album object whenever it creates
          // a new result row. The TableGateway classes use the prototype
          // pattern for creation of result sets and entities. This means 
          // that instead of instantiating when required, the system clones 
          // a previously instantiated object. 
          $resultSetPrototype = new ResultSet();
          $resultSetPrototype->setArrayObjectPrototype(new Album());
          return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
        }
      ),
      
    );
  }
  
  
}