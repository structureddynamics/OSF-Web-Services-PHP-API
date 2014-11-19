<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\revision\lister\RevisionListerQuery.php
      @brief RevisionListerQuery class description
   */

  namespace StructuredDynamics\osf\php\api\ws\revision\lister;

  /**
  * Revision Lister Query to a OSF Revision Lister web service endpoint
  * 
  * The Revision: Lister web service endpoint is used to list all the revisions 
  * existing for a record. All the revision records have a unix timestamp in 
  * microseconds. This timestamp is defined as a double. All the revisions 
  * records can be sorted using this timestamp. If a user want to see what 
  * was the description of a record at a specific time, then he will use the 
  * Revision: Read web service endpoint to get all the triple of that record, 
  * for that revision. 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  // Use the RevisionListerQuery class
  *  use \StructuredDynamics\osf\php\api\ws\revision\lister\RevisionListerQuery;
  *  
  *  // Create the RevisionListerQuery object
  *  $revisionlister = new RevisionListerQuery("http://demo.citizen-dan.org/ws/");
  *  
  *  // Specifies that we want the short results description
  *  $revisionlister->shortResults();
  * 
  *  $revisionlister->uri('http://demo.citizen-dan.org/datasets/test/1/');
  * 
  *  $revisionlister->dataset('http://demo.citizen-dan.org/datasets/test/');
  *  
  *  // Send the revision lister query to the endpoint
  *  $revisionlister->send();
  *  
  *  // Get back the resultset returned by the endpoint
  *  $resultset = $revisionlister->getResultset();
  *  
  *  // Print different serializations for that resultset
  *  print_r($resultset->getResultset());
  * 
  * @endcode
  *  
  * @see http://wiki.opensemanticframework.org/index.php/Revision:_Lister
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class RevisionListerQuery extends \StructuredDynamics\osf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("revision/lister"); 
      
      // Set default parameters for this query
      $this->sourceInterface("default");
      $this->longResults();
    }
    
    /**
    * Specifies the URI of the record for which you want the list of revisions.
    * 
    * @param $uri URI of the record for which you want its list of revisions
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Revision:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function uri($uri)
    {
      $this->params["uri"] = urlencode($uri);
      
      return($this);
    }
    
    /**
    * Specifies the dataset URI where the record is indexed.
    * 
    * @param $dataset The dataset URI where the record is indexed. This is the URI of the dataset, and not
    * the URI of the revisions dataset.
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Revision:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function dataset($dataset)
    {
      $this->params["dataset"] = urlencode($dataset);
      
      return($this);
    }
    
    /**
    * Specifies that we want the short description of the results record. Returned record is described using
    * their date stamp (for ordering purposes) and their URI.
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Revision:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function shortResults()
    {
      $this->params["mode"] = 'short';
      
      return($this);
    }    
    
    /**
    * Specifies that we want the long description of the results record. Returned record is described using
    * their date stamp (for ordering purposes) their URI, the performer of the revision and their
    * lifecycle stage status.
    * 
    * Note: this is the default behvior of the endpoint
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Revision:_Lister#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function longResults()
    {
      $this->params["mode"] = 'long';
      
      return($this);
    }          
   }       
 
//@}    
?>