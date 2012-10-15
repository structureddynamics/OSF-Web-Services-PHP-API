<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\ontology\create\OntologyCreateQuery.php
      @brief OntologyCreateQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\ontology\create;

  use \StructuredDynamics\structwsf\php\api\framework\CRUDPermission;
  
  /**
  * The Ontology Create service is used to create/import a new OWL ontology into the 
  * structWSF instance.
  * 
  * This service is a web service wrapper over the OWLAPI ontology library. It wraps 
  * all the needed functionalities related to ontology creation/import. Most of the 
  * relatd API has been implemented. So we can say that web service (with the other 
  * related services) turns the OWLAPI into a web service API. 
  * 
  * This Web service is intended to be used by content management systems, developers 
  * or administrators to create ontologies that are hosted on a structWSF instance, 
  * and that are used to describe the named entities in the system.
  * 
  * This endpoint, along with the other related endpoints: Ontology Read, Ontology 
  * Update and Ontology Delete; can be seen as the brain of your structWSF instance. 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  use \StructuredDynamics\structwsf\php\api\ws\ontology\create\OntologyCreateQuery;
  *  use \StructuredDynamics\structwsf\php\api\ws\ontology\read\OntologyReadQuery;
  *  use \StructuredDynamics\structwsf\php\api\ws\ontology\read\GetLoadedOntologiesFunction;
  *  
  *  $ontologyCreate = new OntologyCreateQuery("http://localhost/ws/");
  *  
  *  // Create the vcard ontology for which its description is located somewhere on the Web
  *  $ontologyCreate->uri("http://www.w3.org/2006/vcard/ns");
  *  
  *  // Enable advanced indexation to have access to it on all structWSF endpoints
  *  $ontologyCreate->enableAdvancedIndexation();
  *  
  *  // Enable reasoner to persist inferred facts into all endpoints of structWSF
  *  $ontologyCreate->enableReasoner();
  *  
  *  // Import the new ontology
  *  $ontologyCreate->send();
  * 
  *  if($ontologyCreate->isSuccessful())
  *  {
  *    // Now, let's use the ontology read service to make sure it got loaded.
  *    $ontologyRead = new OntologyReadQuery("http://localhost/ws/");
  *    
  *    $ontologyRead->ontology("http://www.w3.org/2006/vcard/ns");
  * 
  *    $getLoadedOntologies = new GetLoadedOntologiesFunction();
  *    
  *    $getLoadedOntologies->modeUris();
  *    
  *    $ontologyRead->getLoadedOntologies($getLoadedOntologies);
  *    
  *    $ontologyRead->send();
  *    
  *    echo $ontologyRead->getResultset()->getResultset();    
  *  }
  *  else
  *  {
  *    echo "Ontology importation failed: ".$ontologyCreate->getStatus()." (".$ontologyCreate->getStatusMessage().")\n";
  *    echo $ontologyCreate->getStatusMessageDescription();       
  *  }  
  * 
  * @endcode
  * 
  * @see http://techwiki.openstructs.org/index.php/Ontology_Create
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class OntologyCreateQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("ontology/create/");
      
      // Set default parameters for this query
      $this->globalPermissions(new CRUDPermission(FALSE, FALSE, FALSE, FALSE));
      $this->disableAdvancedIndexation();
      $this->sourceInterface("default");      
    }
  
    /**
    * Specifies the URI of the ontology.
    * 
    * Note: you can get the list of all loaded ontologies by using the getLoadedOntologies() function
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $ontologyUri Specifies the URI of the ontology; the URI is the URL used to import that 
    *                           ontology in the system. The URL can be the URI of the ontology if it was 
    *                           resolvable on the Web, or the URL where the OWL file, containing the 
    *                           ontology's description, that can be resolved on the Web by this endpoint. 
    *                           This URL can refers to a file accessible on the web, on the file system, 
    *                           etc. The endpoint will get the ontology's description from that URL. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($ontologyUri)
    {
      $this->params["uri"] = urlencode($ontologyUri);
      
      return($this);
    }
    
    /**
    * Set the global permissions for this new ontology
    * 
    * The default value for this call is no global permissions enabled for anybody
    * 
    * @param mixed $crudPermission A CRUDPermission object instance that define the global CRUD permissions 
    *                              to use for this new ontology
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    * 
    */
    public function globalPermissions($crudPermission)
    {
      $this->params["globalPermissions"] = urlencode(($crudPermission->getCreate() ? "True" : "False").";".
                                                     ($crudPermission->getRead() ? "True" : "False").";".
                                                     ($crudPermission->getUpdate() ? "True" : "False").";".
                                                     ($crudPermission->getDelete() ? "True" : "False"));
                                                     
      return($this);
    }    
    
    /**
    * Enable advanced indexation of the ontology. This means that the ontology's description 
    * (so all the classes, properties and named individuals) will be indexed in the other 
    * data management system in structWSF. This means that all the information in these 
    * ontologies will be accessible via the other endpoints such as the Search and the SPARQL 
    * web service endpoints. Enabling this option may render the creation process slower 
    * depending on the size of the created ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function enableAdvancedIndexation()
    {
      $this->params["advancedIndexation"] = "True";
      
      return($this);
    }
    
    /**
    * Disable advanced indexation of the ontology. This means that the ontologies will be queriable 
    * via the Ontology Read, Ontology Update and Ontology Delete web service endpoints only
    * 
    * This is the default behavior of this service.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function disableAdvancedIndexation()
    {
      $this->params["advancedIndexation"] = "False";
      
      return($this);
    }   
    
    /**
    * Enable the reasoner for indexing the ontology into structWSF (the triple 
    * store and the full text engine) 
    * 
    * This is the default behavior of this service.
    * 
    * *Note:* This only has an effect if the advanced indexation is enabled
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function enableReasoner()
    {
      $this->params["reasoner"] = "True";
      
      return($this);
    }
    
    /**
    * Disable the reasoner for for indexing the ontology into structWSF (the triple 
    * store and the full text engine) 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function disableReasoner()
    {
      $this->params["reasoner"] = "False";
      
      return($this);
    }     
  }
 
//@}    
?>