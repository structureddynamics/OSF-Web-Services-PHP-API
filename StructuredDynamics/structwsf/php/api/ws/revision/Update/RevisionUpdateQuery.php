<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\revision\update\RevisionUpdateQuery.php
      @brief RevisionUpdateQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\revision\update;

  /**
  * Revision Update Query to a structWSF Revision Update web service endpoint
  * 
  * The Revision: Update web service endpoint is used to change the lifestage status 
  * of a revision record. If you change the lifecycle stage of a unpublished revision 
  * to published, then this will replace the currently published record by this newly 
  * published revision. If you change the status of a currently published record to 
  * something else than published, then it will unpublish the record, and this record 
  * won't be accessible anymore in the 'public' dataset. This record will always be 
  * available via its revisions, however if the CRUD: Read web service endpoint is 
  * used with its URI, then it will return an error saying the record is not existing 
  * in the dataset. However, you could re-publish this record anytime in the future 
  * using this Revision: Update web service endpoint. 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  // Use the RevisionUpdateQuery class
  *  use \StructuredDynamics\structwsf\php\api\ws\revision\update\RevisionUpdateQuery;
  *  
  *  // Create the RevisionUpdateQuery object
  *  $revisionupdate = new RevisionUpdateQuery("http://demo.citizen-dan.org/ws/");
  *  
  *  $revisionupdate->recordUri('http://demo.citizen-dan.org/datasets/test/1/revision/12335.123');
  * 
  *  $revisionupdate->dataset('http://demo.citizen-dan.org/datasets/test/');  
  * 
  *  $revisionupdate->isArchive();
  *  
  *  // Send the revision update query to the endpoint
  *  $revisionupdate->send();
  *  
  *  // Get back the resultset returned by the endpoint
  *  $resultset = $revisionupdate->getResultset();
  *  
  *  // Print different serializations for that resultset
  *  print_r($resultset->getResultset());
  * 
  * @endcode
  *  
  * @see http://techwiki.openstructs.org/index.php/Revision:_Update
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class RevisionUpdateQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("revision/update"); 
      
      // Set default parameters for this query
      $this->sourceInterface("default");
    }
    
    /**
    * Specifies the URI of the revision record to delete. This URI can be found using the
    * RevisionUpdateQuery() call.
    * 
    * @param $uri URI of the revision record to update
    * 
    * @see http://techwiki.openstructs.org/index.php/Revision:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function revisionUri($uri)
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
    * @see http://techwiki.openstructs.org/index.php/Revision:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function dataset($dataset)
    {
      $this->params["dataset"] = urlencode($dataset);
      
      return($this);
    }
    
    /**
    * Specify that the record being updated has a lifecycle stage status 'published'
    * 
    * **Required**: This function must be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/Revision:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function isPublished()
    {
      $this->params["lifecycle"] = 'published';
      
      return($this);
    }   
             
    /**
    * Specify that the record being updated has a lifecycle stage status 'archive'
    * 
    * **Required**: This function must be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/Revision:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function isArchive()
    {
      $this->params["lifecycle"] = 'archive';
      
      return($this);
    }   
             
    /**
    * Specify that the record being updated has a lifecycle stage status 'experimental'
    * 
    * **Required**: This function must be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/Revision:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function isExperimental()
    {
      $this->params["lifecycle"] = 'experimental';
      
      return($this);
    }  
                     
    /**
    * Specify that the record being updated has a lifecycle stage status 'pre-release'
    * 
    * **Required**: This function must be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/Revision:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function isPreRelease()
    {
      $this->params["lifecycle"] = 'pre_release';
      
      return($this);
    }   
                     
    /**
    * Specify that the record being updated has a lifecycle stage status 'staging'
    * 
    * **Required**: This function must be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/Revision:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function isStaging()
    {
      $this->params["lifecycle"] = 'staging';
      
      return($this);
    }   
                            
    /**
    * Specify that the record being updated has a lifecycle stage status 'harvesting'
    * 
    * **Required**: This function must be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/Revision:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function isHarvesting()
    {
      $this->params["lifecycle"] = 'harvesting';
      
      return($this);
    } 
                            
    /**
    * Specify that the record being updated has a lifecycle stage status 'unspecified'
    * 
    * **Required**: This function must be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/Revision:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function isUnspecified()
    {
      $this->params["lifecycle"] = 'unspecified';
      
      return($this);
    }             
   }       
 
//@}    
?>