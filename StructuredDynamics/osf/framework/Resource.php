<?php

  namespace StructuredDynamics\osf\framework;
  
  use \StructuredDynamics\osf\framework\Subject;
  use \StructuredDynamics\osf\framework\Property;
  use \StructuredDynamics\osf\framework\Value;
  use \StructuredDynamics\osf\framework\BaseResource;
                 
  /**
  * Core Resource class. Each entity is defined using this Resource structure.
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class Resource extends BaseResource 
  {
    /**
    * Constructor
    * 
    * @param mixed $uri URI of the Resource to create.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    function __construct($uri)
    {                               
      parent::__construct($uri);      
    }  
    
    /**
    * Import a Subject class instance as a Resource instance
    * 
    * @param Subject $subject Subject instance to import
    * @return Resource
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function importSubject(Subject $subject)
    {
      $this->uri = $subject->getUri();
      
      foreach($subject->getSubject() as $propertyUri => $propertyValues)
      {
        if($propertyUri != 'type' && 
           $propertyUri != 'prefLabel' && 
           $propertyUri != 'altLabel' && 
           $propertyUri != 'prefURL' && 
           $propertyUri != 'description')
        {
          foreach($propertyValues as $propertyValue)
          {
            $value;
            $property = new Property($propertyUri);
            
            if(isset($propertyValue['uri']))
            {
              $property->isObjectProperty();
              $value = new Value($propertyValue['uri']);
            }
            else
            {
              $value = new Value($propertyValue['value'], $propertyValue['lang'], $propertyValue['type']);
            }
            
            $property->addValue($value);
                        
            if(isset($propertyValue['reify']))
            {
              $reifications = array();
              
              foreach($propertyValue['reify'] as $reiPropertyUri => $reiVal)
              {
                $reiStatement = new ReificationStatement($this, $property, $value);
                
                $reiProperty = new Property($reiPropertyUri);
                
                // With the Subject class, all the reification statements uses 
                // DatatypeProperties and no language nor datatype are specified.
                // This is the reason why this is handled that way in this code.
                $reiValue = new Value($reiVal);
                
                $reiProperty->addValue($reiValue);
                
                $reiStatement->addProperty($reiProperty);
                
                $reifications[] = $reiStatement;  
              }
              
              $value->addReifications($reifications);
            }
            
            $this->addProperty($property);
          }
        }
        
        if($propertyUri == 'type')
        {
          foreach($propertyValues as $propertyValue)
          {          
            $this->addType($propertyValue);
          }
        }
      }
      
      return($this);
    }
    
    /**
    * Add a type to the description of this Resource
    * 
    * @param mixed $uri URI of the type to add
    * @return Resource
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function addType($uri)  
    {
      parent::setType($uri);

      return($this);
    }
  }
  
?>
