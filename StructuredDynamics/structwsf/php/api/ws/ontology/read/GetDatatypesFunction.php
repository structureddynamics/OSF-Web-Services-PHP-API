<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\ontology\read\GetDatatypesFunction.php
      @brief GetDatatypesFunction datatype description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\ontology\read;  
    
 /**
  * Datatype used to define the parameters to use send a "getDatatypes" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDatatypes
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetDatatypesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getDatatypesUris();
    }
    
    /**
    * Get a list of URIs that refers to the datatypes described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDatatypes
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getDatatypesUris()
    {
      $this->params["mode"] = "uris";
      
      return($this);
    }
    
    /**
    * Get the list of datatypes description for the datatypes described in this ontology.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDatatypes
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getDatatypesDescriptions()
    {
      $this->params["mode"] = "descriptions";
      
      return($this);
    }
    
    /**
    * The number of results the requester wants in the resultset.
    * 
    * @param mixed $limit The number of results the requester wants in the resultset. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDatatypes
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
    * list of datatypes. 
    * 
    * @param mixed $offset Where the results to return starts in the complete list of results.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDatatypes
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