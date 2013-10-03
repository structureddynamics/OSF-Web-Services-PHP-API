<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\ontology\read\GetPropertiesFunction.php
      @brief GetPropertiesFunction class description
   */

  namespace StructuredDynamics\osf\php\api\ws\ontology\read;  

 /**
  * Get all the properties that have been defined in an ontology. The 
  * requester can get a list of URIs or the full description of the properties. 
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetPropertiesFunction extends \StructuredDynamics\osf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getAllPropertiesTypes();
      $this->getPropertiesUris();
    }
    
    /**
    * Get all the Annotation properties of the ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getAnnotationProperties()
    {
      $this->params["type"] = "annotationproperty";
      
      return($this);
    }
    
    /**
    * Get all the Datatype properties of the ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getDatatypeProperties()
    {
      $this->params["type"] = "dataproperty";
      
      return($this);
    }
    
    /**
    * Get all the Object properties of the ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getObjectProperties()
    {
      $this->params["type"] = "objectproperty";
      
      return($this);
    }    
    
    /**
    * Get all the Datatype, Object and Annotation properties of the ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getAllPropertiesTypes()
    {
      $this->params["type"] = "all";
      
      return($this);
    }
    
    /**
    * Get a list of URIs that refers to the properties described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
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
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesDescriptions()
    {
      $this->params["mode"] = "descriptions";
      
      return($this);
    }
    
    /**
    * The number of results the requester wants in the resultset.
    * 
    * @param mixed $limit The number of results the requester wants in the resultset. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function limit($limit)
    {
      $this->params["limit"] = $limit;
      
      return($this);
    }    
    
    /**
    * Where the results to return starts in the complete list of results. This is 
    * normally used in conjunction with the limit parameter to paginate the complete 
    * list of classes. 
    * 
    * @param mixed $offset Where the results to return starts in the complete list of results.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function offset($offset)
    {
      $this->params["offset"] = $offset;
      
      return($this);
    }    
  }    
 
//@}    
?>