<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\crud\create\CrudCreateQuery.php
  
      CrudCreateQuery class description

      @author Frederick Giasson, Structured Dynamics LLC.
   */

  namespace StructuredDynamics\structwsf\php\api\ws\crud\create;

  /**
  * Crud Create Query to a structWSF Crud Create web service endpoint
  * 
  * The CRUD: Create Web service is used to create a new instance record 
  * in a target dataset registered to a WSF (Web Services Framework). 
  * When a new instance record is created, it becomes accessible to the 
  * users that have access to this dataset. 
  * 
  * @see http://techwiki.openstructs.org/index.php/CRUD:_Create
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class CrudCreateQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("crud/create/");
      
      // Set default parameters for this query
      $this->enableFullIndexationMode();
    }
    
    /**
    * Set the RDF document where instance record(s) are described. The size of this document 
    * is limited to 8MB on the default system (may be lower or higher on different systems).
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $document RDF+XML or RDF+N3 documents to import into the system
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function document($document)
    {
      $this->params["document"] = urlencode($document);
    }  
    
    /**
    * Specifies that the serialization format of the input document is in RDF+XML
    * 
    * **Required**: This function (or documentMimeIsRdfN3()) must be called before sending the query 
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function documentMimeIsRdfXml()
    {
      $this->params["mime"] = urlencode("application/rdf+xml");
    }
    
    /**
    * Specifies that the serialization format of the input document is in RDF+N3
    * 
    * **Required**: This function (or documentMimeIsRdfXml()) must be called before sending the query 
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function documentMimeIsRdfN3()
    {
      $this->params["mime"] = urlencode("application/rdf+n3");
    }
    
    /**
    * Specifies that you want the document to be indexed everywhere in the system
    * 
    * This is the default behavior of this service.
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function enableFullIndexationMode()
    {
      $this->params["mode"] = "full";
    }
    
    /**
    * Specifies that you want the document to be indexed in the triple store only
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function enableTripleStoreIndexationMode()
    {
      $this->params["mode"] = "triplestore";
    }
    
    /**
    * Specifies that you want the document to be indexed in the search engine only
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function enableSearchIndexationMode()
    {
      $this->params["mode"] = "searchindex";
    }    
    
    /**
    * Set the URI(s) of the dataset where the instance record is indexed
    * 
    * **Required**: This function must be called before sending the query
    * 
    * @param mixed $uris Dataset URI where to index the RDF document 
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Create#Web_Service_Endpoint_Information
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