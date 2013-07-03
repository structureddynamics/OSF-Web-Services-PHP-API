<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\ontology\read\GetDisjointClassesFunction.php
      @brief GetDisjointClassesFunction class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\ontology\read;  

  /**
  * Class used to define the parameters to use send a "getDisjointClasses" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointClasses
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetDisjointClassesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getClassesUris();
    }
    
    /**
    * URI of the class for which the requester want its disjoint-classes. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the class for which the requester want its disjoint-classes. 
    *       
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
      
      return($this);
    }
    
    /**
    *   Get a list of URIs that refers to the disjoint-classes described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesUris()
    {
      $this->params["mode"] = "uris";
      
      return($this);
    }
    
    /**
    * Get the list of classes description for the disjoint-classes described in this ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesDescriptions()
    {
      $this->params["mode"] = "descriptions";
      
      return($this);
    }   
  }  
 
//@}    
?>