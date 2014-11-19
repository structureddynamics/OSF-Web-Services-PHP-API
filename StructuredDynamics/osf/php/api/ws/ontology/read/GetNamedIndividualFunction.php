<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\ontology\read\GetNamedIndividualFunction.php
      @brief GetNamedIndividualFunction class description
   */

  namespace StructuredDynamics\osf\php\api\ws\ontology\read;  

  
 /**
  * Class used to define the parameters to use send a "getNamedIndividual" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getNamedIndividual
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetNamedIndividualFunction extends \StructuredDynamics\osf\php\api\framework\OntologyFunctionCall
  {
    /**
    * Specifies the URI of the named individual to get its description from the ontology
    * 
    * @param mixed $uri URI of the property to delete from the ontology
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Read#getNamedIndividual
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