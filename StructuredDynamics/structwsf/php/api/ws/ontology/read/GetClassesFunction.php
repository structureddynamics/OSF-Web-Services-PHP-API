<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\ontology\read\GetClassesFunction.php
      @brief GetClassesFunction class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\ontology\read;  
    
 /**
  * Class used to define the parameters to use send a "getClasses" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClasses
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetClassesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getClassesUris();
    }
    
    /**
    * Get a list of URIs that refers to the classes described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Get the list of classes description for the classes described in this ontology.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesDescriptions()
    {
      $this->params["mode"] = "descriptions";
    }
    
    /**
    * The number of results the requester wants in the resultset.
    * 
    * @param mixed $limit The number of results the requester wants in the resultset. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function limit($limit)
    {
      $this->params["limit"] = $limit;
    }    
    
    /**
    * Where the results to return starts in the complete list of results. This is 
    * normally used in conjunction with the limit parameter to paginate the complete 
    * list of classes. 
    * 
    * @param mixed $offset Where the results to return starts in the complete list of results.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function offset($offset)
    {
      $this->params["offset"] = $offset;
    }    
  }    
 
//@}    
?>