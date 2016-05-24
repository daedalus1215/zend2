<?php

/* 
 * The config information is passed to the relevant components by the 
 * ServiceManager. We need two initial sections: controllers and view_manager. 
 * The controllers section provides a list of all the controllers provided by 
 * the module. 
 */

return array (
  /**
   * We will need one controller, AlbumController, which we’ll 
   * reference as Album\Controller\Album. The controller key must be unique across 
   * all modules, so we prefix it with our module name.
   */
  'controllers' => array(
    'invokables' => array(
      'Album\Controller\Album' => 'Album\Controller\AlbumController',
    ),
  ),
  /**
   * The mapping of a URL to a particular action is done using routes that are defined in the module’s module.config.php file.
   * Add a route for our album actions. This is the updated module config file with the new code highlighted.
   */
  'router' => array(
    'routes' => array(
      'album' => array(
        'type'    => 'segment', // The name of the route is ‘album’ and has a type of ‘segment’. The segment route allows us to specify placeholders in the URL pattern (route) that will be mapped to named parameters in the matched route. In this case, the route is ``/album[/:action][/:id]`` which will match any URL that starts with /album.
        'options' => array(
          'route'       => '/album[/:action][/:id]', // The next segment will be an optional action name, and then finally the next segment will be mapped to an optional id. The square brackets indicate that a segment is optional.
          'constraints' => array(
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*', // The constraints section allows us to ensure that the characters within a segment are as expected, so we have limited actions to starting with a letter and then subsequent characters only being alphanumeric, underscore or hyphen.
            'id'     => '[0-9]+', // We also limit the id to a number.
          ),
          'default' => array(
            'controller' => 'Album\Controller\Album',
            'action'     => 'index',
          ),
        ),
      ),
    )
  ),
  
  
  /**
   * Within the view_manager section, we add our view directory to the 
   * TemplatePathStack configuration. This will allow it to find the view 
   * scripts for the Album module that are stored in our view/ directory.
   */
  'view_manager' => array(
    'template_path_stack' => array(
      'album' => __DIR__ . '/../view',
    ),
  ),
);

/**
 * We now need to tell the ModuleManager that this new module exists. This is 
 * done in the application’s config/application.config.php file which is 
 * provided by the skeleton application. Update this file so that its modules 
 * section contains the Album module as well, so the file now looks like this:
 */