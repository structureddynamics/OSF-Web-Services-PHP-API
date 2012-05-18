<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\auth\lister\AuthListerQuery.php
  
      AuthListerQuery class description

      @author Frederick Giasson, Structured Dynamics LLC.
   */

  namespace StructuredDynamics\structwsf\php\api\ws\auth\lister;

  /**
  * Auth Lister Query to a structWSF Auth Lister web service endpoint
  * 
  * The Auth: Lister Web service is used to list all of the datasets accessible to a given user, 
  * list all of the datasets accessible to a given user with all of its CRUD permissions, to 
  * list all of the Web services registered to the WSF (Web Services Framework) and to list all 
  * of the CRUD permissions, for all users, for a given dataset created on a WSF.
  * 
  * This Web service is used to list all the things that are registered / authenticated in a 
  * Web Service Framework network. 
  * 
  * @see http://techwiki.openstructs.org/index.php/Auth:_Lister
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class AuthListerQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
                                    
      $this->setMethodGet();

      $this->mime("resultset");
      
      $this->setEndpoint("auth/lister"); 
      
      // Set default parameters for this query
      $this->getDatasetsUri();
      $this->includeAllWebServiceUris();
    }
    
    /**
    * Specifies that this query will return all the datasets URI currently existing, and accessible by the user,
    * in the structWSF network instance.
    * 
    * This is the default behavior of this service.
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function getDatasetsUri()
    {
      $this->params["mode"] = "dataset";
    }

    /**
    * Specifies that this query will return all the web service endpoints URI currently registered
    * to this structWSF network instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function getRegisteredWebServiceEndpointsUri()
    {
      $this->params["mode"] = "ws";
    }

    /**
    * Specifies that this query will return all the users access records in the structWSF network instance.
    * This information will only be returned if the requester has permissions on the core structWSF registry dataset.
    * 
    * @param $datasetUri the URI of the target dataset for which you want the access records for all its users
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function getDatasetUsersAccesses($datasetUri)
    {
      $this->params["mode"] = "access_dataset";
      $this->params["dataset"] = urlencode($datasetUri);
    }     
    
    /**
    * Specifies that this query will return all the datasets URI currently existing, and accessible by the user,
    * in the structWSF network instance, along with their CRUD permissions.
    * 
    * @param $ip IP address of the user for which you want the complete list of all its accessible datasets
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function getUserAccesses($ip)
    {
      $this->params["mode"] = "access_user";
      $this->registeredIp($ip);
    }  
    
    /**
    * Specifies if you want to get all the WebService URIs along with all the access records.
    * Depending on the usecase, this list can be quite large and the returned resultset
    * can be huge.
    * 
    * This is the default behavior of this service.
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function includeAllWebServiceUris()
    {
      $this->params["target_webservice"] = "all";
    }

    /**
    * Specifies if you do not want to include any web service URIs for the access records.
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function includeNoWebServiceUris()
    {
      $this->params["target_webservice"] = "none";
    }
   }       
 
//@}    
?>