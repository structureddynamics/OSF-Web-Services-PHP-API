<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\revision\diff\RevisionDiffQuery.php
      @brief RevisionDiffQuery class description
   */

  namespace StructuredDynamics\osf\php\api\ws\revision\diff;

  /**
  * Revision Diff Query to a OSF Revision Diff web service endpoint
  * 
  * The Revision: Diff web service endpoint is used to compare two revisions of the 
  * same record. A ChangeSet which contains all the added and removed triples 
  * between the two revisions is returned. 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  // Use the RevisionDiffQuery class
  *  use \StructuredDynamics\osf\php\api\ws\revision\diff\RevisionDiffQuery;
  *  
  *  // Create the RevisionDiffQuery object
  *  $revisiondiff = new RevisionDiffQuery("http://demo.citizen-dan.org/ws/");
  *  
  *  $revisiondiff->leftRecordUri('http://demo.citizen-dan.org/datasets/test/1/revision/12335.123');
  * 
  *  $revisiondiff->rightRecordUri('http://demo.citizen-dan.org/datasets/test/1/revision/52312.346');
  * 
  *  $revisiondiff->dataset('http://demo.citizen-dan.org/datasets/test/'); 
  *  
  *  // Send the revision diff query to the endpoint
  *  $revisiondiff->send();
  *  
  *  // Get back the resultset returned by the endpoint
  *  $resultset = $revisiondiff->getResultset();
  *  
  *  // Print different serializations for that resultset
  *  print_r($resultset->getResultset());
  * 
  * @endcode
  *  
  * @see http://techwiki.openstructs.org/index.php/Revision:_Diff
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class RevisionDiffQuery extends \StructuredDynamics\osf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("revision/diff"); 
      
      // Set default parameters for this query
      $this->sourceInterface("default");
    }
    
    /**
    * Specifies the first revision URI to compare.
    * 
    * @param $uri First revision URI to compare.
    * 
    * @see http://techwiki.openstructs.org/index.php/Revision:_Diff#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function leftRevisionUri($uri)
    {
      $this->params["lrevuri"] = urlencode($uri);
      
      return($this);
    }
    
    
    /**
    * Specifies the second revision URI to compare.
    * 
    * @param $uri Second revision URI to compare.
    * 
    * @see http://techwiki.openstructs.org/index.php/Revision:_Diff#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function rightRevisionUri($uri)
    {
      $this->params["rrevuri"] = urlencode($uri);
      
      return($this);
    }    
    
    /**
    * Specifies the dataset URI where the record is indexed.
    * 
    * @param $dataset The dataset URI where the record is indexed. This is the URI of the dataset, and not
    * the URI of the revisions dataset.
    * 
    * @see http://techwiki.openstructs.org/index.php/Revision:_Diff#Web_Service_Endpoint_Information
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