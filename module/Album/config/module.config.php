<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array (
  'controllers' => array(
    'invokables' => array(
      'Album\Controller\Album' => 'Album\Controller\AlbumController',
    ),
  ),
  'view_manager' => array(
    'template_path_stack' => array(
      'album' => __DIR__ . '/../view',
    ),
  ),
);