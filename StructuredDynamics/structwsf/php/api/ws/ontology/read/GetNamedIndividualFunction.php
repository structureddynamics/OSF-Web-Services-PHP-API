<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\ontology\read\GetNamedIndividualFunction.php
      @brief GetNamedIndividualFunction class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\ontology\read;  

  
 /**
  * Class used to define the parameters to use send a "getNamedIndividual" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getNamedIndividual
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetNamedIndividualFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    /**
    * Specifies the URI of the named individual to get its description from the ontology
    * 
    * @param mixed $uri URI of the property to delete from the ontology
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getNamedIndividual
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