<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\dataset\delete\DatasetDeleteQuery.php
      @brief DatasetDeleteQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\dataset\delete;
  
  /**
  * Dataset Delete Query to a structWSF Dataset Delete web service endpoint
  * 
  * The Dataset: Delete Web service is used to delete an existing dataset in a 
  * WSF (Web Services Framework). When a dataset gets deleted, all of the 
  * information archived in it is deleted as well. There is no way to recover 
  * any data once this query is issued. 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  use \StructuredDynamics\structwsf\php\api\ws\dataset\create\DatasetCreateQuery;
  *  use \StructuredDynamics\structwsf\php\api\ws\dataset\delete\DatasetDeleteQuery;
  *  use \StructuredDynamics\structwsf\php\api\ws\auth\lister\AuthListerQuery;
  *  use \StructuredDynamics\structwsf\framework\Namespaces;
  *  use \StructuredDynamics\structwsf\php\api\framework\CRUDPermission;
  *      
  *  // First, let's create a new dataset to delete after
  *  
  *  // Create the DatasetCreateQuery object
  *  $dcreate = new DatasetCreateQuery("http://localhost/ws/");
  *  
  *  // Set the URI of the new dataset
  *  $dcreate->uri("http://localhost/ws/dataset/my-new-dataset-5/");
  *  
  *  // Set the title of the dataset
  *  $dcreate->title("My Brand New Dataset to delete!");
  *  
  *  // Set the description of the dataset
  *  $dcreate->description("This is something to look at!");
  *  
  *  // Set the creator's URI
  *  $dcreate->creator("http://localhost/people/bob/");
  *  
  *  
  *  // Get all the web services registered on this instance with a 
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
  *  // We make this new dataset world readable
  *  $dcreate->globalPermissions(new CRUDPermission(FALSE, TRUE, FALSE, FALSE));
  *  
  *  // Send the crud read query to the endpoint
  *  $dcreate->send();
  *  
  *  // Now, let's delete that dataset!  
  *  $dDelete = new DatasetDeleteQuery("http://localhost/ws/");
  *  
  *  // Specify the URI of the dataset we want to remove
  *  $dDelete->uri("http://localhost/ws/dataset/my-new-dataset-5/");
  *  
  *  // Send que request
  *  $dDelete->send();
  *  
  *  if($dDelete->isSuccessful())
  *  {
  *    // Get the RDF+N3 serialization of the resultset    
  *    echo "Dataset deleted!";
  *  }
  *  else
  *  {
  *    echo "Dataset deletation failed: ".$dDelete->getStatus()." (".$dDelete->getStatusMessage().")\n";
  *    echo $dDelete->getStatusMessageDescription();  
  *  }
  *  
  * @endcode
  * 
  * @see http://techwiki.openstructs.org/index.php/Dataset:_Delete
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class DatasetDeleteQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("dataset/delete/");
      
      // Set default parameters for this query
      $this->sourceInterface("default");      
    }
    
    /**
    * Specifies the URI of the dataset to delete
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the dataset to delete
    * 
    * @see http://techwiki.openstructs.org/index.php/Dataset:_Delete#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function uri($uri)
    {
      $this->params["uri"] = urlencode($uri);
    }  
    
    /**
    * Source interface to use for this web service query.
    * 
    * @param mixed $interface Name of the interface to use.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function sourceInterface($interface)
    {
      $this->params["interface"] = $interface;
    }      
   }       
 
//@}    
?>