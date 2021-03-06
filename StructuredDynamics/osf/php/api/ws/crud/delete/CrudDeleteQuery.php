<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\crud\delete\CrudDeleteQuery.php  
      @brief CrudDeleteQuery class description
   */

  namespace StructuredDynamics\osf\php\api\ws\crud\delete;

  /**
  * Crud Delete Query to a OSF Crud Delete web service endpoint
  * 
  * The CRUD: Delete Web service is used to delete an existing instance record indexed 
  * in some target dataset of a WSF. When the instance record gets deleted, all of the 
  * information archived in the dataset is deleted as well. 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  // Use the CrudDeleteQuery class
  *  use \StructuredDynamics\osf\php\api\ws\crud\delete\CrudDeleteQuery;
  *  
  *  // Create the CrudDeleteQuery object
  *  $crudDelete = new CrudDeleteQuery("http://localhost/ws/");
  *  
  *  // Specifies where the record we want to delete is indexed
  *  $crudDelete->dataset("http://localhost/ws/dataset/my-new-dataset/");
  *  
  *  // Specifies the URI of the record we want to delete from the system
  *  $crudDelete->uri("http://www.w3.org/");
  *  
  *  // Import that new RDF data
  *  $crudDelete->send();
  *
  *  if($crudDelete->isSuccessful())
  *  {
  *    echo "Record deleted";
  *  }
  *  else
  *  {    
  *    echo "Deletation failed: ".$crudDelete->getStatus()." (".$crudDelete->getStatusMessage().")\n";
  *    echo $crudDelete->getStatusMessageDescription();
  *  } 
  * 
  * @endcode
  * 
  * @see http://wiki.opensemanticframework.org/index.php/CRUD:_Delete
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class CrudDeleteQuery extends \StructuredDynamics\osf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("crud/delete/");
      
      // Set default parameters for this query
      $this->sourceInterface("default");
      
      $this->soft();
    } 
    
    /**
    * Specifies the URI of the record to be deleted from the system
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/CRUD:_Delete#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function uri($uri)
    {
      $this->params["uri"] = urlencode($uri);
      
      return($this);
    }
    
    /**
    * Set the URI(s) of the dataset where the instance record is indexed
    * 
    * **Required**: This function must be called before sending the query
    * 
    * @param mixed $uri Dataset URI where to index the RDF document 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/CRUD:_Delete#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function dataset($uri)
    {
      $this->params["dataset"] = urlencode($uri);
      
      return($this);
    }   
    
    /**
    * Specify that this query will only delete the published record and not any of its
    * possible revision.
    * 
    * **Required**: This function must be called before sending the query
    * 
    * @see http://wiki.opensemanticframework.org/index.php/CRUD:_Delete#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function soft()
    {
      $this->params["mode"] = 'soft';
      
      return($this);
    }      
    
    /**
    * Specify that this query will delete the published record and all its revisions.
    * 
    * **Required**: This function must be called before sending the query
    * 
    * @see http://wiki.opensemanticframework.org/index.php/CRUD:_Delete#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function hard()
    {
      $this->params["mode"] = 'hard';
      
      return($this);
    }      
   }       
 
//@}    
?>