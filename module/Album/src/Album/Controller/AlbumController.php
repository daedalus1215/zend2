<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Album\Model\Album;
use Album\Form\AlbumForm;

class AlbumController extends AbstractActionController
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
   * pass them to the view. To do this, we fill in indexAction() within 
   * AlbumController. Update the AlbumController’s indexAction() like this: 
   */
  public function indexAction()
  {
    // With Zend Framework 2, in order to set variables in the view, we return 
    // a ViewModel instance where the first parameter of the constructor is an 
    // array from the action containing data we need. These are then automatically 
    // passed to the view script. The ViewModel object also allows us to change 
    // the view script that is used, but the default is to use 
    // {controller name}/{action name}. We can now fill in the index.phtml view script:
    return new ViewModel(array(
      'albums' => $this->getAlbumTable()->fetchAll(),
    ));
  }

  public function addAction()
  {
    $form = new AlbumForm();
    $form->get('submit')->setValue('Add');
    
    $request = $this->getRequest();
    if ($request->isPost) {
      $album = new Album();
      $form->setInputFilter($album->getInputFilter());
      $form->setData($request->getPost());
    }
  }

  public function editAction()
  {
    
  }

  public function deleteAction()
  {
    
  }
}