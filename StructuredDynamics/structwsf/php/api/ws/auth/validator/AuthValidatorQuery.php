<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\auth\validator\AuthValidatorQuery.php
      @brief AuthValidatorQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\auth\validator;

  /**
  * Auth Validator Query to a structWSF Auth Validator web service endpoint
  * 
  * The Auth Validator web service is used to validate that a query is
  * valid on the structWSF framework for a given requester, dataset and
  * web service endpoint URI.
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  *  
  *  use \StructuredDynamics\structwsf\php\api\ws\auth\validator\AuthValidatorQuery;
  *  
  *  $authValidator = new AuthValidatorQuery("http://localhost/ws/");
  *  
  *  $authValidator->ip("127.0.0.1");
  *  
  *  $authValidator->datasets(array("http://localhost/ws/dataset/my-new-dataset-3/"));
  *  
  *  $authValidator->webServiceUri("http://localhost/wsf/ws/crud/read/");
  *  
  *  $authValidator->send();
  *  
  *  if($authValidator->isSuccessful())
  *  {
  *    echo "Query validated! Move on...";
  *  }
  *  else
  *  {
  *    echo "Query validation failed: ".$authValidator->getStatus()." (".$authValidator->getStatusMessage().")\n";
  *    echo $authValidator->getStatusMessageDescription();  
  *  }
  *       
  * @endcode
  *  
  * @see http://techwiki.openstructs.org/index.php/Auth:_Validator
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class AuthValidatorQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("auth/validator/");
      
      // Set default parameters for this query
      $this->sourceInterface("default");
    }
      /**
    * Specifies the IP address of the requester
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $ip IP address of the requester
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Validator#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC. 
    */
    public function ip($ip)
    {
      $this->params["ip"] = urlencode($ip);
      
      return($this);
    }
    
    /**
    * A list of dataset URI(s) that have to be validated for the target Web service endpoint 
    * that has been queried.
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $datasetsUris An array of datasets URI that needs to be validated
    *                            for this query.
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Validator#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC. 
    */
    public function datasets($datasetsUris)
    {
      // Encode potential ";" characters
      foreach($datasetsUris as $key => $dataset)
      {
        $datasetsUris[$key] = str_replace(";", "%3B", $dataset);
      }      
      
      $this->params["datasets"] = urlencode(implode(";", $datasetsUris)); 
      
      return($this);
    }
    
    /**
    * Specifies the URI of the Web service resource endpoint that as been queried.
    *
    * **Required**: This function must be called before sending the query
    *
    * @param mixed $uri URI of the Web service resource endpoint that as been queried
    *
    * @see http://techwiki.openstructs.org/index.php/Auth:_Validator#Web_Service_Endpoint_Information
    *
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function webServiceUri($uri)
    {
      $this->params["ws_uri"] = urlencode($uri);
      
      return($this);
    }    
   }       
 
//@}    
?>