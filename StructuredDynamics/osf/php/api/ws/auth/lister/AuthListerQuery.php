<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\auth\lister\AuthListerQuery.php
      @brief AuthListerQuery class description
   */

  namespace StructuredDynamics\osf\php\api\ws\auth\lister;

  /**
  * Auth Lister Query to a OSF Auth Lister web service endpoint
  * 
  * The Auth: Lister Web service is used to list all of the datasets accessible to a given user, 
  * list all of the datasets accessible to a given user with all of its CRUD permissions, to 
  * list all of the Web services registered to the WSF (Web Services Framework) and to list all 
  * of the CRUD permissions, for all users, for a given dataset created on a WSF.
  * 
  * This Web service is used to list all the things that are registered / authenticated in a 
  * Web Service Framework network. 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  // Use the AuthListerQuery class
  *  use \StructuredDynamics\osf\php\api\ws\auth\lister\AuthListerQuery;
  *  
  *  // Create the AuthListerQuery object
  *  $authlister = new AuthListerQuery("http://demo.citizen-dan.org/ws/");
  *  
  *  // Specifies that we want to get all the dataset URIs available to the server that send this query.
  *  $authlister->getDatasetsUri();
  *  
  *  // Send the auth lister query to the endpoint
  *  $authlister->send();
  *  
  *  // Get back the resultset returned by the endpoint
  *  $resultset = $authlister->getResultset();
  *  
  *  // Print different serializations for that resultset
  *  print_r($resultset->getResultset());
  * 
  * @endcode
  *  
  * @see http://techwiki.openstructs.org/index.php/Auth:_Lister
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class AuthListerQuery extends \StructuredDynamics\osf\php\api\framework\WebServiceQuery
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
      $this->sourceInterface("default");
    }
    
    /**
    * Specifies that this query will return all the datasets URI currently existing, and accessible by the user,
    * in the OSF network instance.
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
      
      return($this);
    }

    /**
    * Specifies that this query will return all the web service endpoints URI currently registered
    * to this OSF network instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function getRegisteredWebServiceEndpointsUri()
    {
      $this->params["mode"] = "ws";
      
      return($this);
    }

    /**
    * Specifies that this query will return all the group access records in the OSF network instance.
    * This information will only be returned if the requester has permissions on the core OSF registry dataset.
    * 
    * @param $datasetUri the URI of the target dataset for which you want the access records for all its users
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function getDatasetGroupsAccesses($datasetUri)
    {
      $this->params["mode"] = "access_dataset";
      $this->params["dataset"] = urlencode($datasetUri);
      
      return($this);
    }     
    
    /**
    * Specifies that this query will return all the datasets URI currently existing, and accessible by the user,
    * in the OSF network instance, along with their CRUD permissions.
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function getUserAccesses()
    {
      $this->params["mode"] = "access_user";
      
      return($this);
    }  
    
    /**
    * Specifies that this query will return all the datasets URI currently existing, and accessible by the group,
    * in the OSF network instance, along with their CRUD permissions.
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function getGroupAccesses($group)
    {
      $this->params["mode"] = "access_group";
      
      $this->params["group"] = urlencode($group);
      
      return($this);
    }  
        
    /**
    * Specifies that this query will return all the groups currently defined in the OSF instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function getGroups()
    {
      $this->params["mode"] = "groups";
      
      return($this);
    }      
    
    /**
    * Specifies that this query will return all the users registered to a group
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function getGroupUsers($group)
    {
      $this->params["mode"] = "group_users";
      
      $this->params["group"] = urlencode($group);
      
      return($this);
    }   
               
    /**
    * Specifies that this query will return all the groups where the user is registered to
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function getUserGroups()
    {
      $this->params["mode"] = "user_groups";
      
      return($this);
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
      
      return($this);
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
      
      return($this);
    }
    
    /**
    * Specifies which target web service you want to include in the resultset
    * 
    * @param mixed $uri URI of the web service endpoint to include
    * 
    * @see http://techwiki.openstructs.org/index.php/Auth:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function includeTargerWebServiceUri($uri)
    {
      $this->params["target_webservice"] = urlencode($uri);
      
      return($this);
    }      
   }       
 
//@}    
?>