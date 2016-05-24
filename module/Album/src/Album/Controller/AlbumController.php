<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AlbumController extends AlbumActionController
{
  protected $albumTable;
  
  public function getAlbumTable()
  {
    if (!$this->albumTable) {
      $sm = $this->getServiceLocator();
      $this->albumTable = $sm->get('Album\Model\AlbumTable');
    }
    
    return $this->albumTable;
  }
  
  /* 
   * In order to list the albums, we need to retrieve them from the model and
   *  pass them to the view. To do this, we fill in indexAction() within 
   * AlbumController. Update the AlbumController’s indexAction() like this: 
   */
  public function indexAction()
  {
    return new ViewModel(array(
      'albums' => $this->getAlbumTable()->fetchAll(),
    ));
  }

  public function addAction()
  {
    
  }

  public function editAction()
  {
    
  }

  public function deleteAction()
  {
    
  }
}