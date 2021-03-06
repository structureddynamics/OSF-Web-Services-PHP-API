<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\ontology\read\GetLoadedOntologiesFunction.php
      @brief GetLoadedOntologiesFunction class description
   */

  namespace StructuredDynamics\osf\php\api\ws\ontology\read;
     
  /**
  * Class used to define the parameters to use send a "GetLoadedOntologies" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getLoadedOntologies
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetLoadedOntologiesFunction extends \StructuredDynamics\osf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      $this->modeUris();
    }    
    
    /**
    * Set the mode of the request to "uris"
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getLoadedOntologies
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function modeUris()
    {
      $this->params["mode"] = "uris";
      
      return($this);
    }
    
    /**
    * Set the mode of the request to "descriptions"
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getLoadedOntologies
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function modeDescriptions()
    {
      $this->params["mode"] = "descriptions";
      
      return($this);
    } 
  }   
 
//@}    
?>