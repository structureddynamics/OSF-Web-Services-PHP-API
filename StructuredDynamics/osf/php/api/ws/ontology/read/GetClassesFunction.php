<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\ontology\read\GetClassesFunction.php
      @brief GetClassesFunction class description
   */

  namespace StructuredDynamics\osf\php\api\ws\ontology\read;  
    
 /**
  * Class used to define the parameters to use send a "getClasses" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getClasses
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetClassesFunction extends \StructuredDynamics\osf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getClassesUris();
    }
    
    /**
    * Get a list of URIs that refers to the classes described in this ontology. 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesUris()
    {
      $this->params["mode"] = "uris";
      
      return($this);
    }
    
    /**
    * Get the list of classes description for the classes described in this ontology.
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesDescriptions()
    {
      $this->params["mode"] = "descriptions";
      
      return($this);
    }
    
    /**
    * The number of results the requester wants in the resultset.
    * 
    * @param mixed $limit The number of results the requester wants in the resultset. 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getClasses
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
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getClasses
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