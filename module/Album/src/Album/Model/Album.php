<?php

namespace Album\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Album implements InputFilterAwareInterface
{
  public $id;
  public $artist;
  public $title;
  protected $inputFilter;
  
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

  public function getInputFilter() 
  {
    // We add one input for each property that we wish to filter or validate. 
    if (!$this->inputFilter) {
      $inputFilter = new InputFilter();
      
      $inputFilter->add(array(
        'name' => 'id',
        'required' => true,
        'filters' => array(
          array('name' => 'Int'),
        ),  
      ));
      
      $inputFilter->add(array(
        'name' => 'artist', 
        'required' => true,
        'filters' => array(
          array('name' => 'StripTags'),
          array('name' => 'StringTrim'),
        ),
        'validators' => array(
          array(
            'name' => 'StringLength', 
            'options' => array(
              'encoding' => 'UTF-8',
              'min' => 1,
              'max' => 100,
            ),
          ),
        ),
      ));
      
      $inputFilter->add(array(
        'name' => 'title',
        'required' => true,
        'filters' => array(
          array('name' => 'StringTags'),
          array('name' => 'StringTrim'),
        ),
        'validators' => array(
          array(
            'name' => 'StringLength',
            'options' => array(
              'encoding' => 'UTF-8',
              'min' => 1,
              'max' => 100,
            ),
          ),
        ),
      ));
      
      $this->inputFilter = $inputFilter;
    }
    return $this->inputFilter;
  }

  public function setInputFilter(InputFilterInterface $inputFilter) 
  {
    throw new \Exception("Not used, please dont instantiate");
  } 
}
