<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\dataset\create\DatasetCreateQuery.php
      @brief DatasetCreateQuery class description
   */

  namespace StructuredDynamics\osf\php\api\ws\dataset\create;

  use \StructuredDynamics\osf\php\api\framework\CRUDPermission;
  
  /**
  * Dataset Create Query to a OSF Dataset Create web service endpoint
  * 
  * The Dataset: Create Web service is used to create a new dataset in a WSF 
  * (Web Services Framework). When a dataset is created, it gets described and 
  * registered to the WSF and accessible to the other Web services. 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  // Use the DatasetCreateQuery class
  *  use \StructuredDynamics\osf\php\api\ws\dataset\create\DatasetCreateQuery;
  *  
  *  // Create the DatasetCreateQuery object
  *  $dcreate = new DatasetCreateQuery("http://localhost/ws/");
  *  
  *  // Set the URI of the new dataset
  *  $dcreate->uri("http://localhost/ws/dataset/my-new-dataset/");
  *  
  *  // Set the title of the dataset
  *  $dcreate->title("My Brand New Dataset");
  *  
  *  // Set the description of the dataset
  *  $dcreate->description("This is something to look at!");
  *  
  *  // Set the creator's URI
  *  $dcreate->creator("http://localhost/people/bob/");
  *  
  *  
  *  // Get all the web services registered on this instance with a 
  *  use \StructuredDynamics\osf\php\api\ws\auth\lister\AuthListerQuery;
  *  use \StructuredDynamics\osf\framework\Namespaces;
  *  
  *  // Create the AuthListerQuery object
  *  $authlister = new AuthListerQuery("http://localhost/ws/");
  *  
  *  // Specifies that we want to get all the list of all registered web service endpoints.
  *  $authlister->getRegisteredWebServiceEndpointsUri();
  *  
  *  // Send the auth lister query to the endpoint
  *  $authlister->send();
  *  
  *  // Get back the resultset returned by the endpoint
  *  $resultset = $authlister->getResultset()->getResultset();
  *  
  *  $webservices = array();
  *  
  *  // Get all the URIs from the resultset array
  *  foreach($resultset["unspecified"] as $list)
  *  {
  *    foreach($list[Namespaces::$rdf."li"] as $item)
  *    {
  *      array_push($webservices, $item["uri"]);
  *    }
  *  }
  *  
  *  unset($authlister);
  *  
  *  // We make sure that this dataset will be accessible by all the 
  *  // registered web service endpoints of the network.
  *  $dcreate->targetWebservices($webservices);
  *  
  *  use \StructuredDynamics\osf\php\api\framework\CRUDPermission;
  *  
  *  // We make this new dataset world readable
  *  $dcreate->globalPermissions(new CRUDPermission(FALSE, TRUE, FALSE, FALSE));
  *  
  *  // Send the crud read query to the endpoint
  *  $dcreate->send();
  *  
  *  // Now we make sure we create the new dataset by looking into the system
  *  // using the Auth Lister again
  *  
  *  // Create the AuthListerQuery object
  *  $authlister = new AuthListerQuery("http://localhost/ws/");
  *  
  *  // Specifies that we want to get all the list of all registered web service endpoints.
  *  $authlister->getDatasetGroupsAccesses("http://localhost/ws/dataset/my-new-dataset/");
  *  
  *  // Send the auth lister query to the endpoint
  *  $authlister->send();
  *  
  *  // Get back the resultset returned by the endpoint
  *  $resultset = $authlister->getResultset();
  *  
  *  print_r($resultset);
  *  
  * @endcode
  * 
  * @see http://wiki.opensemanticframework.org/index.php/Dataset:_Create
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class DatasetCreateQuery extends \StructuredDynamics\osf\php\api\framework\WebServiceQuery
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
                                    
      $this->setMethodPost();

      $this->mime("resultset");
      
      $this->setEndpoint("dataset/create/");
      
      // Set default parameters for this query
      $this->sourceInterface("default");      
    }
    
    /**
    * Set the URI of the new dataset to create
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the new dataset to create
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Dataset:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function uri($uri)
    {
      $this->params["uri"] = urlencode($uri);
      
      return($this);
    }  
    
    /**
    * Set the title of the dataset to create
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param $title title of the dataset to create
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Dataset:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function title($title)
    {
      $this->params["title"] = urlencode($title);
      
      return($this);
    }
    
    /**
    * Set the description of the dataset to create
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param $description description of the dataset to create
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Dataset:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function description($description)
    {
      $this->params["description"] = urlencode($description);
      
      return($this);
    }    
    
    /**
    * Set the reference to the creator of this new dataset
    * 
    * **Optional**: This function could be called before sending the query 
    * 
    * @param mixed $creatorUri URI of the creator of this new dataset
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Dataset:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function creator($creatorUri)
    {
      $this->params["creator"] = urlencode($creatorUri);
      
      return($this);
    }
    
    /**
    * Specifies which web service endpoint can have access to the data contained in this new dataset.
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * Note: you can get the complete list of webservice endpoint URIs registered to a OSF network
    *       instance by using the AuthListerQuery class and by using the getWebServicesList() function.
    * 
    * @param $webservicesUri An array of webservice URIs that have access to the content of this dataset.
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Dataset:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function targetWebservices($webservicesUri)
    {
      // Encode potential ";" characters
      foreach($webservicesUri as $key => $wsuri)
      {
        $webservicesUri[$key] = str_replace(";", "%3B", $wsuri);
      }
            
      $this->params["webservices"] = urlencode(implode(";", $webservicesUri));
      
      return($this);
    }         
   }       
   
   
 
//@}    
?>