<?php

/*! @ingroup OSFPHPAPIFramework Framework of the OSF PHP API library */
//@{

/*! @file \StructuredDynamics\osf\php\api\framework\OntologyFunctionCall.php
    @brief An internal OntologyFunctionCall class
*/

  namespace StructuredDynamics\osf\php\api\framework;

  /**
  * Class defining the basic interface for an ontology function call.
  * This class is extended by specific function calls used by the
  * Ontology Delete and Ontology Read query classes.
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class OntologyFunctionCall
  {
    /** parameters of the call */
    protected $params = "";
    
    /**
    * Get the parameters string to send to the Ontology: Read endpoint
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getParameters()
    {
      $parameters = "";
      
      foreach($this->params as $param => $value)
      {
        $parameters .= urlencode($param."=".$value).";";  
      }
      
      $parameters = trim($parameters, ";");
      
      return($parameters);
    }    
  }
  
//@}     
?>
