<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\ontology\read\GetSuperClassesFunction.php
      @brief GetSuperClassesFunction class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\ontology\read;  
  
  /**
  * Class used to define the parameters to use send a "getSuperClasses" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperClasses
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetSuperClassesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getClassesUris();
      $this->directSuperClasses();
    }
    
    /**
    * URI of the class for which the requester want its super-classes. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the class for which the requester want its super-classes. 
    *       
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
    
    /**
    *   Get a list of URIs that refers to the super-classes described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Get the list of classes description for the super-classes described in this ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesDescriptions()
    {
      $this->params["mode"] = "descriptions";
    }
                 
    /**
    * Only get the direct super-classes of the target class. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function directSuperClasses()
    {
      $this->params["direct"] = "True";
    }    

    /**
    * Get all the super-classes by inference (so, the sub-classes of the 
    * super-classes recursively). 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function allSuperClasses()
    {
      $this->params["direct"] = "False";
    }    
  }    
 
//@}    
?>