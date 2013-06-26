<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\ontology\read\GetClassFunction.php
      @brief GetClassFunction class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\ontology\read;
  
 /**
  * Class used to define the parameters to use send a "getClass" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClass
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetClassFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    /**
    * Specifies the URI of the class to get its description from the ontology
    * 
    * @param mixed $uri URI of the property to delete from the ontology
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClass
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