<?php

namespace Album\Model;

use Zend\Db\TableGateway\TableGateway;
/**
 * We can see that this AlbumTable is a class that takes a dependency 
 * injection of a TableGateway.
 * 
 * TabelGateway is nothing more than a database wrapper, like a ORM, that will
 * remove the ugly raw SQL statements and allow us to interact with an object.
 */


class AlbumTable 
{
  protected $tableGateway;
  
  public function __construct(TableGateway $tableGateway) 
  {
    $this->tableGateway = $tableGateway;
  }
  
  /**
   * helper methods that our application will use to interface with the table gateway. 
   *
   */
  
  
  public function fetchAll() 
  {
    $resultSet = $this->tableGateway->select();
    return $resultSet;
  }
  
  public function getAlbum($id) 
  {
    $id = (int) $id;
    $rowset = $this->tableGateway->select(array('id' => $id)); // This is essentially a where statement like: SELECT * FROM Album WHERE `id` = '$id';
    $row = $rowset->current();
    if (!$row) {
      throw new \Exception("Could not find row with $id");
    }
    return $row;
  }
  
  public function saveAlbum(Album $album) 
  {
    $data = array(
      'artist' => $album->artist,
      'title' => $album->title,
    );
    
    $id = (int) $album->id; // $id will equal to 0 if there is not already a id (a new album entry).
    if ($id == 0) {
      $this->tableGateway->insert($data); // since there is no album with that id lets insert a new row (b/c this is a new Album).
    } else {
      if ($this->getAlbum($id)) {
        $this->tableGateway->update($data, array('id' => $id)); // we got the album, this is an update so we do SQL update where id = $id
      } else {
        throw new \Exception('Album id does not exist.');
      }
    } 
  }
  
  public function deleteAlbum($id) 
  {
    $this->tableGateway->delete(array('id' => (int) $id));
  }  
}

// In order to always use the same instance of our AlbumTable, we will use the ServiceManager
