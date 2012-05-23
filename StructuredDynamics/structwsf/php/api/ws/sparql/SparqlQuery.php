<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\sparql\SparqlQuery.php
      @brief SparqlQuery class description

      @author Frederick Giasson, Structured Dynamics LLC.
   */

  namespace StructuredDynamics\structwsf\php\api\ws\sparql;

  /**
  * SPARQL Query to a structWSF SPARQL web service endpoint
  * 
  * The SPARQL Web service is used to send custom SPARQL queries against the 
  * structWSF data structure. This is a general purpose querying Web service. 
  * 
  * @see http://techwiki.openstructs.org/index.php/SPARQL
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class SparqlQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
                                     "application/iron+csv",
                                     "application/sparql-results+json"));
                                    
      $this->setMethodPost();

      $this->mime("resultset");
      
      $this->setEndpoint("sparql/");
      
      // Set default parameters for this query
      $this->query("");
      $this->dataset("");
      $this->defaultGraphUri("");
      $this->namedGraphUri("");
    }

    /**
    * SPARQL query to send to the endpoint.
    * 
    * **Required**: This function must be called before sending the query 
    *  
    * @see http://techwiki.openstructs.org/index.php/SPARQL#Web_Service_Endpoint_Information
    * 
    * @param mixed $query SPARQL query to send to the endpoint
    */
    public function query($query)
    {
      $this->params["query"] = $query;
    }
    
    /**
    * URI of the dataset to query. Only use this function when you don't have
    * FROM NAMED clauses in your SPARQL query.
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/SPARQL#Web_Service_Endpoint_Information
    * 
    * @param mixed $dataset URI of the dataset to query 
    */
    public function dataset($dataset)
    {
      $this->params["dataset"] = $dataset;
    }
    
    /**
    * Specify the URI of the default graph to use for this SPARQL query.
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/SPARQL#Web_Service_Endpoint_Information
    * 
    * @param mixed $defaultGraph URI of the default graph
    */
    public function defaultGraphUri($defaultGraph)
    {
      $this->params["default-graph-uri"] = $defaultGraph;
    }

    /**
    * Specify the URI of the named graph to use for this SPARQL query
    *     
    * **Optional**: This function could be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/SPARQL#Web_Service_Endpoint_Information
    * 
    * @param mixed $namedGraph URI of the named graph
    */
    public function namedGraphUri($namedGraph)
    {
      $this->params["named-graph-uri"] = $namedGraph;
    }
  }
  
//@}  
?>