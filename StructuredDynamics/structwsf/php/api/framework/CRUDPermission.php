<?php

/*! @ingroup OSFPHPAPIFramework Framework of the OSF PHP API library */
//@{

/*! @file \StructuredDynamics\osf\php\api\framework\CRUDPermission.php
    @brief An internal CRUDPermission class
*/


namespace StructuredDynamics\osf\php\api\framework;

/** 
* The CRUD Permission class is used to define CRUD permissions
* used by some of the web service classes wrappers.
* 
* @author Frederick Giasson, Structured Dynamics LLC.
*/

class CRUDPermission
{  
  private $create = FALSE;
  private $read = FALSE;
  private $update = FALSE;
  private $delete = FALSE;
  
  /**
  * Constructor
  * 
  * @param mixed $create Boolean that specify if Create operations can be performed.
  * @param mixed $read Boolean that specify if Read operations can be performed.
  * @param mixed $update Boolean that specify if Update operations can be performed.
  * @param mixed $delete Boolean that specify if Delete operations can be performed.
  * @return CRUDPermission
  */
  function __construct($create, $read, $update, $delete)
  {
    $this->create = $create;
    $this->read = $read;
    $this->update = $update;
    $this->delete = $delete;
  }
  
  function getCreate()
  {
    return($this->create);
  }
  
  function getRead()
  {
    return($this->read);
  }
     
  function getUpdate()
  {
    return($this->update);
  }
  
  function getDelete()
  {
    return($this->delete);
  }
}

//@}   
  
?>
