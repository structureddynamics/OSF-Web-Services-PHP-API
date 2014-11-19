<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\ontology\read\GetSubPropertiesFunction.php
      @brief GetSubPropertiesFunction class description
   */

  namespace StructuredDynamics\osf\php\api\ws\ontology\read;  
  
  /**
  * Get all the sub-properties that have been defined in an ontology. The requester 
  * can get a list of URIs or the full description of the sub-properties. 
  *       
  * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getSubProperties
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetSubPropertiesFunction extends \StructuredDynamics\osf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getDatatypeProperties();
      $this->getPropertiesUris();
      $this->allSubProperties();
    }
        
    /**
    * URI of the property for which the requester want its sub-properties. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the property for which the requester want its sub-properties. 
    *       
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getSubProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
      
      return($this);
    }
        
    
    /**
    * Get all the Datatype sub-properties of the ontology  
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getSubProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getDatatypeProperties()
    {
      $this->params["type"] = "dataproperty";
      
      return($this);
    }
    
    /**
    * Get all the Object sub-properties of the ontology 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getSubProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getObjectProperties()
    {
      $this->params["type"] = "objectproperty";
      
      return($this);
    }    
    
    /**
    * Get a list of URIs that refers to the properties described in this ontology. 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#v
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesUris()
    {
      $this->params["mode"] = "uris";
      
      return($this);
    }
    
    /**
    * Get the list of properties description for the classes described in this ontology.
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getSubProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesDescriptions()
    {
      $this->params["mode"] = "descriptions";
      
      return($this);
    }  
                    
    /**
    * Only get the direct sub-properties of the target property. 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getSubProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function directSubProperties()
    {
      $this->params["direct"] = "True";
      
      return($this);
    }    

    /**
    * Get all the sub-properties by inference (so, the sub-properties of 
    * the sub-properties recursively). 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getSubProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function allSubProperties()
    {
      $this->params["direct"] = "False";
      
      return($this);
    }     
  }     
 
//@}    
?>