<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\dataset\read\DatasetReadQuery.php
      @brief DatasetDeleteQuery class description
   */

  namespace StructuredDynamics\osf\php\api\ws\dataset\read;
  
  /**
  * Dataset Read Query to a OSF Dataset Read web service endpoint
  * 
  * The Dataset: Read Web service is used to get information (title, 
  * description, creator, contributor(s), creation date and last modification 
  * date) for a dataset belonging to the WSF (Web Services Framework). 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  use \StructuredDynamics\osf\php\api\ws\dataset\read\DatasetReadQuery;
  *  
  *  $dRead = new DatasetReadQuery("http://localhost/ws/");
  *
  *  // Specify the Dataset URI for which we want its description
  *  $dRead->uri("http://localhost/ws/dataset/my-new-dataset-3/");
  *  
  *  $dRead->send();
  *  
  *  if($dRead->isSuccessful())
  *  {
  *    // Get the RDF+N3 serialization of the resultset    
  *    echo $dRead->getResultset()->getResultsetRDFN3();
  *  }
  *  else
  *  {
  *    echo "Dataset read failed: ".$dRead->getStatus()." (".$dRead->getStatusMessage().")\n";
  *    echo $dRead->getStatusMessageDescription();  
  *  }
  * 
  * @endcode
  * 
  * @see http://wiki.opensemanticframework.org/index.php/Dataset:_Read
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class DatasetReadQuery extends \StructuredDynamics\osf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("dataset/read/");
      
      // Set default parameters for this query
      $this->uri("all");
      $this->sourceInterface("default");      
    }
    
    /**
    * Set the URI of the dataset to get information about. If the value of the URI
    * is "all", then the description of all the datasets accessible to the requester
    * will be returned.
    * 
    * @param mixed $uri URI of the new dataset to create
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Dataset:_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function uri($uri)
    {
      $this->params["uri"] = urlencode($uri);
      
      return($this);
    }   
   }       
 
//@}    
?>