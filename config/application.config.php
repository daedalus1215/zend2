<?php
/**
 * If you need an environment-specific system or application configuration,
 * there is an example in the documentation
 * @see http://framework.zend.com/manual/current/en/tutorials/config.advanced.html#environment-specific-system-configuration
 * @see http://framework.zend.com/manual/current/en/tutorials/config.advanced.html#environment-specific-application-configuration
 */
return array(
    // This should be an array of module namespaces used in the application.
    'modules' => array(
        'Application',
        'Album', //Larry - May 22 2016 - We now need to tell the ModuleManager that this new module exists. This is done in the application’s config/application.config.php file which is provided by the skeleton application. Update this file so that its modules section contains the Album module as well, so the file now looks like this:
    ),

    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        'config_glob_paths' => array(
            'config/autoload/{{,*.}global,{,*.}local}.php',
        ),

    ),
);
