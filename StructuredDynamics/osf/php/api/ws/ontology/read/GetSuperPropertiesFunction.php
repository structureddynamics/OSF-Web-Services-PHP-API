<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\ontology\read\GetSuperPropertiesFunction.php
      @brief GetSuperPropertiesFunction class description
   */

  namespace StructuredDynamics\osf\php\api\ws\ontology\read;  

  /**
  * Get all the super-properties that have been defined in an ontology. The requester 
  * can get a list of URIs or the full description of the super-properties. 
  *       
  * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getSuperProperties
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetSuperPropertiesFunction extends \StructuredDynamics\osf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getDatatypeProperties();
      $this->getPropertiesUris();
      $this->allSuperProperties();
    }
        
    /**
    * URI of the property for which the requester want its super-properties. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the property for which the requester want its super-properties. 
    *       
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getSuperProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
      
      return($this);
    }
        
    
    /**
    * Get all the Datatype super-properties of the ontology  
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getSuperProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getDatatypeProperties()
    {
      $this->params["type"] = "dataproperty";
      
      return($this);
    }
    
    /**
    * Get all the Object super-properties of the ontology 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getSuperProperties
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
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getSuperProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesDescriptions()
    {
      $this->params["mode"] = "descriptions";
      
      return($this);
    }  
                    
    /**
    * Only get the direct super-properties of the target property. 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getSuperProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function directSuperProperties()
    {
      $this->params["direct"] = "True";
      
      return($this);
    }    

    /**
    * Get all the super-properties by inference (so, the super-properties of 
    * the super-properties recursively). 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getSuperProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function allSuperProperties()
    {
      $this->params["direct"] = "False";
      
      return($this);
    }     
  }   
 
//@}    
?>