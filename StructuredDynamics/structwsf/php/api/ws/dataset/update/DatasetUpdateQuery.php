<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\dataset\update\DatasetUpdateQuery.php
      @brief DatasetUpdateQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\dataset\update;
  
  /**
  * Dataset Update Query to a structWSF Dataset Update web service endpoint
  * 
  * The Dataset: Update Web service is used to update the description of an 
  * existing dataset in a WSF (Web Services Framework). 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  use \StructuredDynamics\structwsf\php\api\ws\dataset\create\DatasetCreateQuery;
  *  use \StructuredDynamics\structwsf\php\api\ws\dataset\update\DatasetUpdateQuery;
  *  use \StructuredDynamics\structwsf\php\api\ws\dataset\read\DatasetReadQuery;
  *  use \StructuredDynamics\structwsf\php\api\ws\auth\lister\AuthListerQuery;
  *  use \StructuredDynamics\structwsf\framework\Namespaces;
  *  use \StructuredDynamics\structwsf\php\api\framework\CRUDPermission;
  *      
  *  // First, let's create a new dataset to update after
  *  
  *  // Create the DatasetCreateQuery object
  *  $dcreate = new DatasetCreateQuery("http://localhost/ws/");
  *  
  *  // Set the URI of the new dataset
  *  $dcreate->uri("http://localhost/ws/dataset/my-new-dataset-6/");
  *  
  *  // Set the title of the dataset
  *  $dcreate->title("My Brand New Dataset to update!");
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
  *  $dupdate = new DatasetUpdateQuery("http://localhost/ws/");
  *  
  *  // Set the URI of the dataset to update
  *  $dupdate->uri("http://localhost/ws/dataset/my-new-dataset-6/");
  *  
  *  // Set the title of the dataset
  *  $dupdate->title("My Brand New Updated Dataset!");
  *  
  *  // Set the description of the dataset
  *  // Here we want to keep the same as the old one
  *  $dupdate->description("This is something to look at!");
  *  
  *  // Set the contributors to this dataset. Keep Bob, and add Kelly.
  *  $dupdate->contributors(array("http://localhost/people/bob/", "http://localhost/people/kelly/"));  
  *  
  *  // Specify the date it got modifed, with our own date format.
  *  $dupdate->modified(date('l jS \of F Y h:i:s A'));
  *  
  *  // Update the description of the dataset
  *  try
  *  {
  *    $dupdate->send();
  *  }
  *  catch(Exception $e){}

  *  if($dupdate->isSuccessful())
  *  {
  *    // Now that it is updated, use the Dataset Read endpoint to get the description
  *    // of our updated dataset in RDF+XML
  *    $dRead = new DatasetReadQuery("http://localhost/ws/");

  *    // Specify the Dataset URI for which we want its description
  *    $dRead->uri("http://localhost/ws/dataset/my-new-dataset-6/");
  *    
  *    $dRead->send();
  *    
  *    if($dRead->isSuccessful())
  *    {
  *      // Get the RDF+XML serialization of the resultset    
  *      echo $dRead->getResultset()->getResultsetRDFXML();
  *    }    
  *    else
  *    {
  *      echo "Dataset read failed: ".$dRead->getStatus()." (".$dRead->getStatusMessage().")\n";
  *      echo $dRead->getStatusMessageDescription();       
  *    }
  *  } 
  *  else
  *  {
  *    echo "Dataset update failed: ".$dupdate->getStatus()." (".$dupdate->getStatusMessage().")\n";
  *    echo $dupdate->getStatusMessageDescription();     
  *  }
  *  
  * @endcode
  * 
  * @see http://techwiki.openstructs.org/index.php/Dataset:_Update
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class DatasetUpdateQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("dataset/update/");
      
      // Set default parameters for this query
    }
    
    /**
    * Set the URI of the dataset to update its description
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the dataset to update
    * 
    * @see http://techwiki.openstructs.org/index.php/Dataset:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function uri($uri)
    {
      $this->params["uri"] = urlencode($uri);
    }  
    
    /**
    * Set the title of the dataset to update
    * 
    * **Usage Note:** If this function is not called, the title of the dataset will be removed from the description.
    * 
    * @param $title title of the dataset to update
    * 
    * @see http://techwiki.openstructs.org/index.php/Dataset:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function title($title)
    {
      $this->params["title"] = urlencode($title);
    }
    
    /**
    * Set the description of the dataset to update
    * 
    * **Usage Note:** If this function is not called, the description of the dataset will be removed from the description.
    * 
    * @param $description description of the dataset to update
    * 
    * @see http://techwiki.openstructs.org/index.php/Dataset:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function description($description)
    {
      $this->params["description"] = urlencode($description);
    }    
    
    /**
    * Redefine the contributors to this dataset
    * 
    * **Usage Note:** If this function is not called, the reference to all contributors will be
    *                 removed from the descrioption of this dataset
    * 
    * @param mixed $contributorsUris Array of contributors URIs
    * 
    * @see http://techwiki.openstructs.org/index.php/Dataset:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function contributors($contributorsUris)
    {
      $this->params["contributors"] = urlencode(implode(";", $contributorsUris));
    }
    
    /**
    * Specifies the date of the modification of the dataset
    * 
    * @param mixed $date Date of the modification of the dataset
    * 
    * @see http://techwiki.openstructs.org/index.php/Dataset:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function modified($date)
    {
      $this->params["modified"] = urlencode($date);
    }
   }       
 
//@}    
?>