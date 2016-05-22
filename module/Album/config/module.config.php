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