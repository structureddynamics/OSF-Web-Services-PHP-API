<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\revision\delete\RevisionDeleteQuery.php
      @brief RevisionDeleteQuery class description
   */

  namespace StructuredDynamics\osf\php\api\ws\revision\delete;

  /**
  * Revision Delete Query to a OSF Revision Delete web service endpoint
  * 
  * The Revision: Delete web service endpoint deletes a revision of a record. It cannot 
  * delete a published revision. If a published revision needs to be deleted, then 
  * it needs to be updated such that the published stage is remove before being able to 
  * delete it or to use the CRUD: Delete (soft) web service endpoint. 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  // Use the RevisionDeleteQuery class
  *  use \StructuredDynamics\osf\php\api\ws\revision\delete\RevisionDeleteQuery;
  *  
  *  // Create the RevisionDeleteQuery object
  *  $revisiondelete = new RevisionDeleteQuery("http://demo.citizen-dan.org/ws/");
  *  
  *  $revisiondelete->recordUri('http://demo.citizen-dan.org/datasets/test/1/revision/12335.123');
  * 
  *  $revisiondelete->dataset('http://demo.citizen-dan.org/datasets/test/'); 
  *  
  *  // Send the revision delete query to the endpoint
  *  $revisiondelete->send();
  *  
  *  // Get back the resultset returned by the endpoint
  *  $resultset = $revisiondelete->getResultset();
  *  
  *  // Print different serializations for that resultset
  *  print_r($resultset->getResultset());
  * 
  * @endcode
  *  
  * @see http://wiki.opensemanticframework.org/index.php/Revision:_Delete
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class RevisionDeleteQuery extends \StructuredDynamics\osf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("revision/delete"); 
      
      // Set default parameters for this query
      $this->sourceInterface("default");
    }
    
    /**
    * Specifies the URI of the revision record to delete. This URI can be found using the
    * RevisionUpdateQuery() call.
    * 
    * @param $uri URI of the revision record to delete
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Revision:_Delete#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function revisionUri($uri)
    {
      $this->params["revuri"] = urlencode($uri);
      
      return($this);
    }
    
    /**
    * Specifies the dataset URI where the record is indexed.
    * 
    * @param $dataset The dataset URI where the record is indexed. This is the URI of the dataset, and not
    * the URI of the revisions dataset.
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Revision:_Delete#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function dataset($dataset)
    {
      $this->params["dataset"] = urlencode($dataset);
      
      return($this);
    }
   }       
 
//@}    
?>