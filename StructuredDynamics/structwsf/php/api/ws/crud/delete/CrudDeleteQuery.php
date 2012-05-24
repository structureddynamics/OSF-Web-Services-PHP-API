<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\crud\delete\CrudDeleteQuery.php  
      @brief CrudDeleteQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\crud\delete;

  /**
  * Crud Delete Query to a structWSF Crud Delete web service endpoint
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
  *  use \StructuredDynamics\structwsf\php\api\ws\crud\delete\CrudDeleteQuery;
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
  * @see http://techwiki.openstructs.org/index.php/CRUD:_Delete
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class CrudDeleteQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("crud/delete/");
      
      // Set default parameters for this query

    }
    
    /**
    * Set the RDF document where instance record(s) are described. The size of this document 
    * is limited to 8MB on the default system (may be lower or higher on different systems).
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $document RDF+XML or RDF+N3 documents to import into the system
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Delete#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function document($document)
    {
      $this->params["document"] = urlencode($document);
    }  
    
    /**
    * Specifies the URI of the record to be deleted from the system
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Delete#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function uri($uri)
    {
      $this->params["uri"] = urlencode($uri);
    }
    
    /**
    * Set the URI(s) of the dataset where the instance record is indexed
    * 
    * **Required**: This function must be called before sending the query
    * 
    * @param mixed $uri Dataset URI where to index the RDF document 
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Delete#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function dataset($uri)
    {
      $this->params["dataset"] = urlencode($uri);
    } 
   }       
 
//@}    
?>