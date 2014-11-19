<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\auth\registrar\ws\AuthRegistrarUserQuery.php
      @brief AuthRegistrarUserQuery class description
   */

  namespace StructuredDynamics\osf\php\api\ws\auth\registrar\user;

  /**
  * Auth Registrar User Query to a OSF Auth Registrar User web service endpoint
  * 
  * The Auth Registrar: User Web service is used to register a user to an existing Group.
  * This means that the user will have access to all the datasets accessible to that
  * group of users.
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  use \StructuredDynamics\osf\framework\Namespaces;                     
  *  use \StructuredDynamics\osf\php\api\ws\auth\registrar\ws\AuthRegistrarUserQuery;
  * 
  *  // Register a new web service endpoint to the OSF instance
  *  $arg = new AuthRegistrarUserQuery("http://localhost/ws/");
  * 
  *  // Specify the user URI
  *  $arg->user("http://localhost/wsf/users/bob");
  * 
  *  // Specify the group where to register the user
  *  $arg->group("http://localhost/wsf/groups/foo");
  * 
  *  // Specify that we want the user to join the group
  *  $arg->joinGroup();
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
  class AuthRegistrarUserQuery extends \StructuredDynamics\osf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("auth/registrar/user/"); 
      
      // Set default parameters for this query
      $this->sourceInterface("default");      
    }
    
    /**
    * Sepcifies the user URI
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the target user
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Auth_Registrar:_User#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC. 
    */
    public function user($uri)
    {
      $this->params["user_uri"] = urlencode($uri);
      
      return($this);
    }  
        
    /**
    * Sepcifies the group URI where to register/unregister the user
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the group where to register/unregister the user
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Auth_Registrar:_User#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC. 
    */
    public function group($uri)
    {
      $this->params["group_uri"] = urlencode($uri);      
      
      return($this);
    }     
     
    /**
    * Specify that we want the user to join that group
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Auth_Registrar:_User#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC. 
    */
    public function joinGroup()
    {
      $this->params["action"] = 'join';
      
      return($this);
    }     
    
    /**
    * Specify that we want the user to leave the group
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Auth_Registrar:_User#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC. 
    */
    public function leaveGroup()
    {
      $this->params["action"] = 'leave';
      
      return($this);
    }         
   }       
 
//@}    
?>