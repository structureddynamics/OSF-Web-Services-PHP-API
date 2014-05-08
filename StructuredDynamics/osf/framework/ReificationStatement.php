<?php

  namespace StructuredDynamics\osf\framework;

  use \StructuredDynamics\osf\framework\BaseResource;
  use \StructuredDynamics\osf\framework\Resource;
  use \StructuredDynamics\osf\framework\Property;
  use \StructuredDynamics\osf\framework\Value;
  
  /**
  * Special kind of Resource used to define a Reification Statement.
  * Each property/value of that resource becomes a reification statement
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class ReificationStatement extends BaseResource 
  {
    private $reifiedResource;
    private $reifiedProperty;
    private $reifiedValue;
    
    /**
    * Constructor
    * 
    * @param Resource $reifiedResource Resource to be reified
    * @param Property $reifiedProperty Property to be reified
    * @param Value $reifiedValue Value to be reified
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    function __construct(Resource &$reifiedResource, Property &$reifiedProperty, Value &$reifiedValue)
    {
      $this->reifiedResource = $reifiedResource;
      $this->reifiedProperty = $reifiedProperty;
      $this->reifiedValue = $reifiedValue;
      
      parent::__construct(md5($reifiedResource->uri() . $reifiedProperty->uri() . $reifiedValue->content()));
      
      parent::setType('http://www.w3.org/1999/02/22-rdf-syntax-ns#Statement');
    }  
  }
  
?>
