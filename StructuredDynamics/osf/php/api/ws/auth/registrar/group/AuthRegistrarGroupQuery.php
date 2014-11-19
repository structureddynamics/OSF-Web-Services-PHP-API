<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\auth\registrar\ws\AuthRegistrarGroupQuery.php
      @brief AuthRegistrarGroupQuery class description
   */

  namespace StructuredDynamics\osf\php\api\ws\auth\registrar\group;

  /**
  * Auth Registrar Group Query to a OSF Auth Registrar Group web service endpoint
  * 
  * The Auth Registrar: Group Web service is used to register a new Group to the OSF
  * instance. This group will be used to give access to the group's users to certain
  * datasets.
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  use \StructuredDynamics\osf\framework\Namespaces;                     
  *  use \StructuredDynamics\osf\php\api\ws\auth\registrar\ws\AuthRegistrarGroupQuery;
  * 
  *  // Register a new web service endpoint to the OSF instance
  *  $arg = new AuthRegistrarGroupQuery("http://localhost/ws/");
  * 
  *  // Specify the group URI
  *  $arg->group("http://localhost/wsf/groups/new-group");
  * 
  *  // Specify the Application ID where this group belongs
  *  $arg->application("some-id");
  * 
  *  // Specify that we want to create a new group in that application
  *  $arg->createGroup();
  *  
  *  // Send the query  
  *  $arg->send();
  * 
  *  if($arws->isSuccessful())
  *  {
  *     // ...
  *  }
  *  else
  *  {
  *    echo "Web service registration failed: ".$arg->getStatus()." (".$arg->getStatusMessage().")\n";
  *    echo $arg->getStatusMessageDescription();  
  *  }  
  * 
  * @endcode
  * 
  * @see http://wiki.opensemanticframework.org/index.php/Auth_Registrar:_Group
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class AuthRegistrarGroupQuery extends \StructuredDynamics\osf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("auth/registrar/group/"); 
      
      // Set default parameters for this query
      $this->sourceInterface("default");      
    }
    
    /**
    * Sepcifies the group URI
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the target group
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Auth_Registrar:_Group#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC. 
    */
    public function group($uri)
    {
      $this->params["group_uri"] = urlencode($uri);
      
      return($this);
    }  
        
    /**
    * Sepcifies the Application ID where the group should be created
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $id ID of the application
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Auth_Registrar:_Group#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC. 
    */
    public function application($id)
    {
      $this->params["app_id"] = urlencode($id);
      
      return($this);
    }     
     
    /**
    * Specify that we want to create a new group
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Auth_Registrar:_Group#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC. 
    */
    public function createGroup()
    {
      $this->params["action"] = 'create';
      
      return($this);
    }     
    
    /**
    * Specify that we want to delete a new group
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Auth_Registrar:_Group#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC. 
    */
    public function deleteGroup()
    {
      $this->params["action"] = 'delete';
      
      return($this);
    }         
   }       
 
//@}    
?>