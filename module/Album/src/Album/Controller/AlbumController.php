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
    if ($request->isPost()) { // if true we know that the form has been submitted and so we set the form's input filter from an album instance.
      $album = new Album();
      $form->setInputFilter($album->getInputFilter());
      $form->setData($request->getPost());
      
      if ($form->isValid()) {
          $album->exchangeArray($form->getData());
          $this->getAlbumTable()->saveAlbum($album);
          
          // Redirect to list of albums
          $this->redirect()->toRoute('album');
      }
    }
    return array('form' => $form);
  }

  
  public function editAction()
  {
    // We use it to retrieve the id from the route we created in the modules’ module.config.php.
    $id = (int) $this->params()->fromRoute('id', 0); 
    if (!$id) { // if 0
        return $this->redirect()->toRoute('album', array(
            'action' => 'add'
            ));
    }
    
    // Get the Album with the specified id. An exception is thrown if it cannot be found, in which case go to the index page.
    try {
        $album = $this->getAlbumTable()->getAlbum($id);
    } catch (\Exception $ex) {
        return $this->redirect()->toRoute('album', array(
            'action' => 'index'
            ));
    }
    
    $form = new AlbumForm();
    $form->bind($album); // bind() attaches the model to the form. This is used in two ways:
    // 1. When displaying the form, the initial values for each element are extracted from the model.
    
    $form->get('submit')->setAttribute('value', 'Edit');
    
    $request = $this->getRequest();
    if ($request->isPost()) {
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());
        
        // 2. After successful validation in isValid(), the data from the form is put back into the model.
        // To utilize the saveAlbum we need to use the hydrator object - by implementing getArrayCopy() in the Album class.
        if ($form->isValid()) {
            // As a result of using bind() with its hydrator, we do not need to populate the form’s data back into the $album as that’s already been done, so we can just call the mappers’ saveAlbum() to store the changes back to the database.
            $this->getAlbumTable()->saveAlbum($album);
            
            // Redirect to list of albums
            $this->redirect()->toRoute('album');
        }
    }
    
    return array(
        'id' => $id,
        'form' => $form,
    );
  }

  
  public function deleteAction()
  {
    
  }
}