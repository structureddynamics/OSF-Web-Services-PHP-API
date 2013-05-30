<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\revision\read\RevisionReadQuery.php
      @brief RevisionReadQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\revision\read;

  /**
  * Revision Read Query to a structWSF Revision Read web service endpoint
  * 
  * The Revision: Read web service endpoint is used to read a specific revision of a record. 
  * This endpoint will return all the triples, including reification triples, of a specific 
  * revision record. This web service endpoint can be used to get all the triples, which 
  * includes the triples that defines the revision itself. But it can also be used to re-create 
  * the original state of the record when it got revisioned. This "original" state simple 
  * remove the revision specific triples and change the URI to its original one (and not 
  * the revision URI). 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  // Use the RevisionReadQuery class
  *  use \StructuredDynamics\structwsf\php\api\ws\revision\read\RevisionReadQuery;
  *  
  *  // Create the RevisionReadQuery object
  *  $revisionread = new RevisionReadQuery("http://demo.citizen-dan.org/ws/");
  *  
  *  $revisionread->getRevision();
  * 
  *  $revisionread->recordUri('http://demo.citizen-dan.org/datasets/test/1/revision/12335.123');
  * 
  *  $revisionread->dataset('http://demo.citizen-dan.org/datasets/test/'); 
  *  
  *  // Send the revision read query to the endpoint
  *  $revisionread->send();
  *  
  *  // Get back the resultset returned by the endpoint
  *  $resultset = $revisionread->getResultset();
  *  
  *  // Print different serializations for that resultset
  *  print_r($resultset->getResultset());
  * 
  * @endcode
  *  
  * @see http://techwiki.openstructs.org/index.php/Revision:_Read
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class RevisionReadQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("revision/read"); 
      
      // Set default parameters for this query
      $this->sourceInterface("default");
      $this->getRecord();
    }
    
    /**
    * Specifies the URI of the revision URI record to read
    * 
    * @param $uri URI of the revision record to read
    * 
    * @see http://techwiki.openstructs.org/index.php/Revision:_Read#Web_Service_Endpoint_Information
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
    * @see http://techwiki.openstructs.org/index.php/Revision:_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function dataset($dataset)
    {
      $this->params["dataset"] = urlencode($dataset);
      
      return($this);
    }
    
    /**
    * Specifies that you want the endpoint to return the full revision record, with all the information specific 
    * to the revision (status, revision time, performed, etc). The URI of the record that will be returned will 
    * be the same as the one used for this parameter
    * 
    * @see http://techwiki.openstructs.org/index.php/Revision:_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getRevision()
    {
      $this->params["mode"] = 'revision';
      
      return($this);
    }    
    
    /**
    * Specifies that you want the endpoint to return the record of that revision, without all the meta information 
    * about the revision. The URI of the record that will be returned will be different the one specified in this. 
    * parameter. The URI that will be used is the one of the actual record, so the one specified by the 
    * wsf:revisionUri property if the mode revision is used 
    * 
    * This is the default behavior for this endpoint
    * 
    * @see http://techwiki.openstructs.org/index.php/Revision:_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getRecord()
    {
      $this->params["mode"] = 'record';
      
      return($this);
    }         
   }       
 
//@}    
?>