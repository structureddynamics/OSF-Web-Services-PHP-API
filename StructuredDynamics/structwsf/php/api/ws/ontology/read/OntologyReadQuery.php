<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\ontology\read\OntologyReadQuery.php
      OntologyReadQuery class description

      @author Frederick Giasson, Structured Dynamics LLC.
   */

  namespace StructuredDynamics\structwsf\php\api\ws\ontology\read;

  /**
  * Ontology Read Query to a structWSF SPARQL web service endpoint
  * 
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class OntologyReadQuery extends WebServiceQuery
  {
    /**
    * Constructor
    * 
    * @param mixed $network structWSF network where to send this query. Ex: http://localhost/ws/
    */
    function __construct($network)
    {
      // Set the structWSF network to use for this query.
      $this->setNetwork($network);
      
      // Set default configarations for this web service query
      $this->setSupportedMimes(array("text/xml", 
                                     "application/json", 
                                     "application/rdf+xml",
                                     "application/rdf+n3",
                                     "application/iron+json",
                                     "application/iron+csv"));
                                    
      $this->setMethodPost();

      $this->mime("resultset");
      
      $this->setEndpoint("ontology/read/");
      
      // Set default parameters for this query
      $this->ontology("");
      $this->enableReasoner();
      
    }
  
    /**
    * URI of the ontology to query
    * 
    * Note: you can get the list of all loaded ontologies by using the getLoadedOntologies() function
    * 
    * @param mixed $ontology URI of the ontology to query
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function ontology($ontology)
    {
      $this->params["ontology"] = $ontology;
    }
    
    /**
    * Enable the reasoner for querying this ontology
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function enableReasoner()
    {
      $this->params["reasoner"] = "True";
    }
    
    /**
    * Disable the reasoner for querying this ontology
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function disableReasoner()
    {
      $this->params["reasoner"] = "False";
    }
   
    /**
    * Get the list of all loaded ontologies on the structWSF network instance.
    * 
    * @param mixed $function A reference to a GetLoadedOntologiesFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getLoadedOntologies
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getLoadedOntologies(&$function)
    {
      if(get_class($function) == "GetLoadedOntologiesFunction")
      {
        $this->params["function"] = "getLoadedOntologies";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }
  }
  
  /**
  * Class used to define the parameters to use send a "GetLoadedOntologies" call 
  * to the Ontology: Read web service endpoint.
  * 
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getLoadedOntologies
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetLoadedOntologiesFunction
  {
    /** parameters of the call */
    private $params = "";
    
    function __construct()
    {
      $this->params["mode"] = "uris";
    }    
    
    /**
    * Set the mode of the request to "uris"
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getLoadedOntologies
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function modeUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Set the mode of the request to "descriptions"
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getLoadedOntologies
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function modeDescriptions()
    {
      $this->params["mode"] = "descriptions";
    }
    
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