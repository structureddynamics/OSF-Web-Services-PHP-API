<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\ontology\read\GetDisjointPropertiesFunction.php
      @brief GetDisjointPropertiesFunction class description
   */

  namespace StructuredDynamics\osf\php\api\ws\ontology\read;  
  
  /**
  * Get all the disjoint-properties that have been defined in an ontology. The requester 
  * can get a list of URIs or the full description of the disjoint-properties. 
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointProperties
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetDisjointPropertiesFunction extends \StructuredDynamics\osf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getDatatypeProperties();
      $this->getPropertiesUris();
    }
        
    /**
    * URI of the property for which the requester want its disjoint-properties. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the property for which the requester want its disjoint-properties. 
    *       
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
      
      return($this);
    }
    
    /**
    * Get all the Datatype disjoint-properties of the ontology  
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getDatatypeProperties()
    {
      $this->params["type"] = "dataproperty";
      
      return($this);
    }
    
    /**
    * Get all the Object disjoint-properties of the ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointProperties
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
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#v
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
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesDescriptions()
    {
      $this->params["mode"] = "descriptions";
      
      return($this);
    }  
  }
 
//@}    
?>