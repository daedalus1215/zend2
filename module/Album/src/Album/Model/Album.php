<?php

namespace Album\Model;

class Album 
{
  public $id;
  public $artist;
  public $title;
  
  /**
   * Our Album entity object is a simple PHP class. In order to work with 
   * Zend\Db’s TableGateway class, we need to implement the exchangeArray() method. 
   * 
   * This method simply copies the data from the passed in array to our entity’s 
   * properties. We will add an input filter for use with our form later.
   */
  public function exchangeArray($data) 
  {
    $this->id     = (!empty($data['id'])) ? $data['id'] : null;
    $this->artist = (!empty($data['artist'])) ? $data['artist'] : null;
    $this->title  = (!empty($data['title'])) ? $data['title'] : null;
  }
  
}
