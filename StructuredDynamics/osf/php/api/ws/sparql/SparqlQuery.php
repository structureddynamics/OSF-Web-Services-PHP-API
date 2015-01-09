<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\sparql\SparqlQuery.php
      @brief SparqlQuery class description
   */

  namespace StructuredDynamics\osf\php\api\ws\sparql;

  /**
  * SPARQL Query to a OSF SPARQL web service endpoint
  * 
  * The SPARQL Web service is used to send custom SPARQL queries against the 
  * OSF data structure. This is a general purpose querying Web service. 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  * @endcode
  * 
  * @see http://wiki.opensemanticframework.org/index.php/SPARQL
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class SparqlQuery extends \StructuredDynamics\osf\php\api\framework\WebServiceQuery
  {
    /**
    * Constructor
    * 
    * @param mixed $network OSF network where to send this query. Ex: http://localhost/ws/
    * @param mixed $appID The Application ID of the instance instance to key. The APP-ID is related to the API-KEY
    * @param mixed $apiKey The API Key of the OSF web service endpoints
    * @param mixed $userID The ID of the user that is doing the query
    */
    function __construct($network, $appID, $apiKey, $userID)
    {
      // Set the OSF network & credentials to use for this query.
      $this->setNetwork($network);
      $this->appID = $appID;
      $this->apiKey = $apiKey;
      $this->userID = $userID;
      
      // Set default configarations for this web service query
      $this->setSupportedMimes(array("application/rdf+json", 
                                     "text/rdf+n3", 
                                     "text/turtle", 
                                     "application/json", 
                                     "text/xml", 
                                     "application/sparql-results+xml", 
                                     "application/sparql-results+json", 
                                     "text/html", 
                                     "application/rdf+xml", 
                                     "application/rdf+n3", 
                                     "application/iron+json", 
                                     "application/iron+csv", 
                                     "text/plain"));
                                    
      $this->setMethodPost();

      $this->mime("resultset");
      
      $this->setEndpoint("sparql/");
      
      // Set default parameters for this query
      $this->query("");
      $this->dataset("");
      $this->defaultGraphUri("");
      $this->namedGraphUri("");
      $this->sourceInterface("default");      
    }

    /**
    * SPARQL query to send to the endpoint.
    * 
    * **Required**: This function must be called before sending the query 
    *  
    * @see http://wiki.opensemanticframework.org/index.php/SPARQL#Web_Service_Endpoint_Information
    * 
    * @param mixed $query SPARQL query to send to the endpoint
    */
    public function query($query)
    {
      $this->params["query"] = urlencode($query);
      
      return($this);
    }
    
    /**
    * URI of the dataset to query. Only use this function when you don't have
    * FROM NAMED clauses in your SPARQL query.
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @see http://wiki.opensemanticframework.org/index.php/SPARQL#Web_Service_Endpoint_Information
    * 
    * @param mixed $dataset URI of the dataset to query 
    */
    public function dataset($dataset)
    {
      $this->params["dataset"] = urlencode($dataset);
      
      return($this);
    }
    
    /**
    * Specify the URI of the default graph to use for this SPARQL query.
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @see http://wiki.opensemanticframework.org/index.php/SPARQL#Web_Service_Endpoint_Information
    * 
    * @param mixed $defaultGraph URI of the default graph
    */
    public function defaultGraphUri($defaultGraph)
    {
      $this->params["default-graph-uri"] = urlencode($defaultGraph);
      
      return($this);
    }

    /**
    * Specify the URI of the named graph to use for this SPARQL query
    *     
    * **Optional**: This function could be called before sending the query
    * 
    * @see http://wiki.opensemanticframework.org/index.php/SPARQL#Web_Service_Endpoint_Information
    * 
    * @param mixed $namedGraph URI of the named graph
    */
    public function namedGraphUri($namedGraph)
    {
      $this->params["named-graph-uri"] = urlencode($namedGraph);
      
      return($this);
    } 
  }
  
//@}  
?>