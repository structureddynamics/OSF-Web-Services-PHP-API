<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\ontology\read\GetPropertyFunction.php
      @brief GetPropertyFunction class description
   */

  namespace StructuredDynamics\osf\php\api\ws\ontology\read;  
  
 /**
  * Class used to define the parameters to use send a "getProperty" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperty
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetPropertyFunction extends \StructuredDynamics\osf\php\api\framework\OntologyFunctionCall
  {
    /**
    * The URI of the property for which you want its description
    * 
    * @param mixed $uri The URI of the property for which you want its description
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperty
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
  }  
 
//@}    
?>