<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\crud\update\CrudUpdateQuery.php
      @brief CrudUpdateQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\crud\update;

  /**
  * Crud Update Query to a structWSF Crud Update web service endpoint
  * 
  * The CRUD: Update Web service is used to update an existing instance record 
  * indexed in a target dataset part of a WSF (Web Services Framework). 
  * 
  * Usage notes: This Web service is intended to be used by any user that wants to update 
  * the description of an instance record. The update of a record is performed by two atomic 
  * actions: delete and create. All records described within the input RDF document will get 
  * updated on the system. For each of them, the Crud Update web service will remove all the 
  * triples we have defined for them in the target dataset, and then will re-insert the new 
  * ones.
  * 
  * This is the main difference between an Update of a given instance record, and the Creation 
  * (using Crud Create) of an already existing record: the update web service guaranties that 
  * only the triples of the updated version of an instance record will be in the system. 
  * Creating an already existing instance record, will overwrite existing triples, and will 
  * add new ones. But the ones from the old version of the instance record that are not in 
  * the new version won't be delete in the triple store instance, but will be deleted in 
  * the Solr instance because Solr documents can't be updated (they can only be replaced).
  * 
  * It also update possible reification statements.
  * 
  * Warning: if your RDF document contains blank nodes and that you try to update them using 
  * the CRUD: Update web service endpoint, this will results in the creation of a new set of 
  * resources with new blank nodes URIS. This means that resources specified as blank nodes 
  * can't be updated using this web service endpoint. The best practice is not using blank 
  * nodes.
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  // Use the CrudCreateQuery class
  *  use \StructuredDynamics\structwsf\php\api\ws\crud\create\CrudCreateQuery;
  *  
  *  // Use the CrudUpdateQuery class
  *  use \StructuredDynamics\structwsf\php\api\ws\crud\update\CrudUpdateQuery;
  *
  *  // Use the SearchQuery class  
  *  use StructuredDynamics\structwsf\php\api\ws\search\SearchQuery;
  *  
  *  
  *  // First, let's create our object that we will then modify.
  *  
  *  // Create the CrudCreateQuery object
  *  $crudCreate = new CrudCreateQuery("http://localhost/ws/");
  *  
  *  // Specifies where we want to add the RDF content
  *  $crudCreate->dataset("http://localhost/ws/dataset/my-new-dataset/");
  *  
  *  // Specifies the RDF content we want to add to this dataset
  *  $crudCreate->document('<?xml version="1.0"?>
  *                         <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  *                           xmlns:dc="http://purl.org/dc/elements/1.1/">
  *                           <rdf:Description rdf:about="http://www.w3.org/">
  *                             <dc:title>World Wide Web Consortium</dc:title> 
  *                           </rdf:Description>
  *                         </rdf:RDF>');
  *
  *  // Specifies that the input document is serialized using RDF+XML
  *  $crudCreate->documentMimeIsRdfXml();  
  *  
  *  // Make sure we index that new RDF data everywhere in the structWSF instance
  *  $crudCreate->enableFullIndexationMode();
  *  
  *  // Import that new RDF data
  *  $crudCreate->send();
  *
  *  if($crudCreate->isSuccessful())
  *  {
  *    // Now that it got created, let's try to modify it.
  *    
  *    // Create the CrudUpdateQuery object
  *    $crudUpdate = new CrudUpdateQuery("http://localhost/ws/");
  *    
  *    // Specifies where we want to add the RDF content
  *    $crudUpdate->dataset("http://localhost/ws/dataset/my-new-dataset/");
  *    
  *    // Specifies the RDF content we want to add to this dataset
  *    $crudUpdate->document('<?xml version="1.0"?>
  *                           <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  *                             xmlns:dc="http://purl.org/dc/elements/1.1/">
  *                             <rdf:Description rdf:about="http://www.w3.org/">
  *                               <dc:title>CRUD: Update testing (was: World Wide Web Consortium)</dc:title> 
  *                             </rdf:Description>
  *                           </rdf:RDF>');
  *
  *    // Specifies that the input document is serialized using RDF+XML
  *    $crudUpdate->documentMimeIsRdfXml();  
  *    
  *    // Import that new RDF data
  *    $crudUpdate->send();
  *
  *    if($crudUpdate->isSuccessful())
  *    {    
  *      // If the document has been properly updated, let's try to search for it.
  *      
  *      // Create the SearchQuery object
  *      $search = new SearchQuery("http://localhost/ws/");
  *      
  *      // Set the query parameter with the search keyword "elm"
  *      $search->query("Update testing");
  *      
  *      $search->excludeAggregates();
  *      
  *      // Send the search query to the endpoint
  *      $search->send();
  *      
  *      // Get back the resultset returned by the endpoint
  *      $resultset = $search->getResultset();
  *      
  *      // Print different serializations for that resultset
  *      print_r($resultset->getResultset());      
  *    }
  *    else
  *    {
  *      echo "Update failed: ".$crudUpdate->getStatus()." (".$crudUpdate->getStatusMessage().")\n";
  *      echo $crudUpdate->getStatusMessageDescription();      
  *    }
  *  }
  *  else
  *  {    
  *    echo "Creation failed: ".$crudCreate->getStatus()." (".$crudCreate->getStatusMessage().")\n";
  *    echo $crudCreate->getStatusMessageDescription();
  *  }
  *  
  * @endcode
  * 
  * @see http://techwiki.openstructs.org/index.php/CRUD:_Update
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class CrudUpdateQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("crud/update/");
      
      // Set default parameters for this query
      $this->sourceInterface("default");      
    }
    
    /**
    * Set the RDF document where instance record(s) are described. The size of this document 
    * is limited to 8MB on the default system (may be lower or higher on different systems).
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $document RDF+XML or RDF+N3 documents to import into the system
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function document($document)
    {
      $this->params["document"] = urlencode($document);
      
      return($this);
    }  
    
    /**
    * Specifies that the serialization format of the input document is in RDF+XML
    * 
    * **Required**: This function (or documentMimeIsRdfN3()) must be called before sending the query 
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Update#Web_Service_Endpoint_Information
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
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function documentMimeIsRdfN3()
    {
      $this->params["mime"] = urlencode("application/rdf+n3");
      
      return($this);
    }     
    
    /**
    * Set the URI(s) of the dataset where the instance record is indexed
    * 
    * **Required**: This function must be called before sending the query
    * 
    * @param mixed $uri Dataset URI where to index the RDF document 
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function dataset($uri)
    {
      $this->params["dataset"] = urlencode($uri);
      
      return($this);
    }  
   }       
 
//@}    
?>