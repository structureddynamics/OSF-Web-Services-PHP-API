<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\ontology\read\OntologyReadQuery.php
      @brief OntologyReadQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\ontology\read;

  /**
  * Ontology Read Query to a structWSF Ontology Read web service endpoint
  * 
  * The Ontology Read service is used to query OWL ontologies. All kinds of information 
  * can be read on different ontology entities such as: classes, object properties, 
  * datatype properties, annotation properties and individuals. Reasoners can also be 
  * used to include inferred facts in the service's resultset. A full list of actions 
  * can be performed that enables you to leverage your ontologies, properly and 
  * effectively.
  * 
  * This service is a Web service wrapper over the OWLAPI ontology library. Most of the 
  * API has been implemented. So we can say that this Web service (with the other related 
  * structWSF services) turns the OWLAPI into a Web service API. 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  * @endcode
  * 
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class OntologyReadQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $ontology URI of the ontology to query
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function ontology($ontology)
    {
      $this->params["ontology"] = urlencode($ontology);
    }
    
    /**
    * Enable the reasoner for querying this ontology
    * 
    * This is the default behavior of this service.
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
  class GetLoadedOntologiesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
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