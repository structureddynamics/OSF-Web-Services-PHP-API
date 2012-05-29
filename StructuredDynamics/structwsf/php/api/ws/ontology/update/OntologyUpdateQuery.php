<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\ontology\update\OntologyUpdateQuery.php
      @brief OntologyUpdateQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\ontology\update;

  use \StructuredDynamics\structwsf\php\api\framework\CRUDPermission;
  
  /**
  * The Ontology Update service is used to update an OWL ontology existing in the 
  * structWSF instance.
  * 
  * This service is a web service wrapper over the OWLAPI ontology library. It wraps 
  * all the needed functionalities related to updating an ontology. Most of the 
  * related API has been implemented. So we can say that web service (with the other 
  * related services) turns the OWLAPI into a web service API.
  * 
  * There is an important semantic distinction to do: this endpoint is about UPDATING 
  * an ontology. This means that we may be updating ontologies resources, or creating 
  * new ones. The logic is that by creating new resources (such as classes, properties 
  * and named individuals) we are updating the ontology.
  * 
  * This is what this web service endpoint is about. To update or create an existing 
  * resource, the requester only has to send the RDF description of that resource to 
  * update or create. If the resource is existing, it will get updated, if it is not, 
  * it will get added. 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  use \StructuredDynamics\structwsf\php\api\ws\ontology\create\OntologyCreateQuery;
  *  use \StructuredDynamics\structwsf\php\api\ws\ontology\update\OntologyUpdateQuery;
  *  use \StructuredDynamics\structwsf\php\api\ws\ontology\update\CreateOrUpdateEntityFunction;
  *  use \StructuredDynamics\structwsf\php\api\ws\ontology\update\UpdateEntityUriFunction;
  *  use \StructuredDynamics\structwsf\php\api\ws\ontology\read\OntologyReadQuery;
  *  use \StructuredDynamics\structwsf\php\api\ws\ontology\read\GetClassFunction;
  *  
  *  // First, let's create an initial ontology
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
  *    // Now, let's change the URI of the class "http://www.w3.org/2006/vcard/ns#Address"
  *    // to http://www.w3.org/2006/vcard/ns#Addr
  *
  *    $ontologyUpdate = new OntologyUpdateQuery("http://localhost/ws/");
  *    
  *    $ontologyUpdate->ontology("http://www.w3.org/2006/vcard/ns");
  *    
  *    $updateEntityUriFunction = new UpdateEntityUriFunction();
  *    
  *    $updateEntityUriFunction->oldUri("http://www.w3.org/2006/vcard/ns#Address");
  *    
  *    $updateEntityUriFunction->newUri("http://www.w3.org/2006/vcard/ns#Addr");
  *    
  *    $ontologyUpdate->updateEntityUri($updateEntityUriFunction);
  *    
  *    $ontologyUpdate->send();
  *    
  *    if($ontologyUpdate->isSuccessful())
  *    {
  *      // Now, let's read information about the Address class, using its 
  *      // brand new URI.
  *      $ontologyRead = new OntologyReadQuery("http://localhost/ws/");
  *      
  *      $ontologyRead->mime("application/rdf+n3");
  *      
  *      $ontologyRead->ontology("http://www.w3.org/2006/vcard/ns");
  *
  *      $getClass = new GetClassFunction();
  *      
  *      $getClass->uri("http://www.w3.org/2006/vcard/ns#Addr");
  *      
  *      $ontologyRead->getClass($getClass);
  *      
  *      $ontologyRead->send();      
  *      
  *      echo $ontologyRead->getResultset();
  *      print_r(var_export($ontologyRead, TRUE));
  *      
  *    }
  *    else
  *    {
  *      echo "Ontology update failed: ".$ontologyUpdate->getStatus()." (".$ontologyUpdate->getStatusMessage().")\n";
  *      echo $ontologyUpdate->getStatusMessageDescription();         
  *    } 
  *  }
  *  else
  *  {
  *    echo "Ontology importation failed: ".$ontologyCreate->getStatus()." (".$ontologyCreate->getStatusMessage().")\n";
  *    echo $ontologyCreate->getStatusMessageDescription();       
  *  }
  * 
  * @endcode
  * 
  * @see http://techwiki.openstructs.org/index.php/Ontology_Update
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class OntologyUpdateQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("ontology/update/");
      
      // Set default parameters for this query
      $this->enableReasoner();
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
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function ontology($ontologyUri)
    {
      $this->params["ontology"] = urlencode($ontologyUri);
    }    
    
    /**
    * Enable the reasoner for indexing the ontology into structWSF (the triple 
    * store and the full text engine) 
    * 
    * This is the default behavior of this service.
    * 
    * *Note:* This only has an effect if the advanced indexation is enabled
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function enableReasoner()
    {
      $this->params["reasoner"] = "True";
    }
    
    /**
    * Disable the reasoner for for indexing the ontology into structWSF (the triple 
    * store and the full text engine) 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function disableReasoner()
    {
      $this->params["reasoner"] = "False";
    }
    
    /**
    * Create or update an entity in the ontology. An entity can be anything of a class, 
    * an object property, a datatype property, an annotation property or a named individual.
    * 
    * Right now, the creation and the modification of an entity is simplified to writing the 
    * RDF triples describing the entity to create or update. The advantage of this method is 
    * that a system that interacts with the endpoints doesn't have to send multiple different 
    * queries to change multiple aspects of an entity. It only has to generate the code offline, 
    * and send it once to the Ontology Update web service endpoint, with the complete RDF 
    * description of the entity to update, or create, in the instance.
    * 
    * If an entity is being modified by some system, usually the workflow process is:
    * + The system send a query to the Ontology Read web service endpoint to get the 
    *   current complete description of the entity to update
    * + The system modify the RDF description of that entity, the way it has to (by 
    *   adding, removing or modifying triples)
    * + Once the modifications are done offline, the system send the resulting RDF 
    *   document to the Ontology Update web service endpoint 
    * 
    * @param mixed $function A reference to a CreateOrUpdateEntityFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#createOrUpdateEntity
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function createOrUpdateEntity(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\update\CreateOrUpdateEntityFunction')
      {
        $this->params["function"] = "createOrUpdateEntity";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }     
              
    /**
    * Update (refactor) the URI of an existing entity. The entity can be a 
    * class, an object property, a datatype property, an annotation property 
    * or a named individual. 
    * 
    * @param mixed $function A reference to a UpdateEntityUriFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#updateEntityUri
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function updateEntityUri(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\update\UpdateEntityUriFunction')
      {
        $this->params["function"] = "updateEntityUri";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }
    
    /**
    * When the createOrUpdateEntity, or the updateEntityUri, functions are called via 
    * this web service endpoint, the ontology is tagged with a wsf:ontologyModified 
    * "true" triple that specifies that the ontology got modified in some ways.
    * 
    * What this saveOntology call does, is only to remove that tag (so, to remove 
    * the tag that says that the ontology got modified).
    * 
    * The ontology is after saved, and persisted, in the OWLAPI instance. However, 
    * if you want your system to save a hard-copy of an ontology that got modified 
    * (to reload it elsewhere), the you system will have to perform these steps:
    * 
    * Check if the ontology got modified by checking if the wsf:OntologyModified 
    * "true" triple appears in the ontology's description after a call to the 
    * Ontology Read web service endpoint for the function getOntology: mode=description.
    * 
    * If is has been modified, then it calls the Ontology Read endpoints again, but 
    * using the getSerialized function. Once it gets the serialization form of the 
    * ontology, the system can now save it on its local file system, or elsewhere.
    * 
    * Finally it calls the saveOntology function of the Ontology Update web service 
    * endpoint to mark the ontology as saved. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#saveOntology
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function saveOntology()
    {
      $this->params["function"] = "saveOntology";
    }    
  }
  
  /**
  * Class used to define the parameters to use send a "createOrUpdateEntity" call 
  * to the Ontology: Update web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Update#createOrUpdateEntity
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class CreateOrUpdateEntityFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Define default behaviors
      $this->enableAdvancedIndexation();
    }
    
    /**
    * A version of the RDF document describing the entity (class, property or 
    * named individual) to create or update in the ontology. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $document RDF document serialized in XML or N3
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#createOrUpdateEntity
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function document($document)
    {
      $this->params["document"] = urlencode($document);
    }    
    
    /**
    * Enable advanced indexation of the ontology. This means that the ontology's description 
    * (so all the classes, properties and named individuals) will be indexed in the other 
    * data management system in structWSF. This means that all the information in these 
    * ontologies will be accessible via the other endpoints such as the Search and the SPARQL 
    * web service endpoints. Enabling this option may render the creation process slower 
    * depending on the size of the created ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#createOrUpdateEntity
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function enableAdvancedIndexation()
    {
      $this->params["advancedIndexation"] = "True";
    }
    
    /**
    * Disable advanced indexation of the ontology. This means that the ontologies will be queriable 
    * via the Ontology Read, Ontology Update and Ontology Delete web service endpoints only
    * 
    * This is the default behavior of this service.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#createOrUpdateEntity
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function disableAdvancedIndexation()
    {
      $this->params["advancedIndexation"] = "False";
    } 
  }  
  
  
  /**
  * Class used to define the parameters to use send a "updateEntityUriFunction" call 
  * to the Ontology: Update web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Update#updateEntityUri
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class UpdateEntityUriFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Define default behaviors
      $this->enableAdvancedIndexation();
    }
    
    /**
    * This is the current URI of the entity to update. This URI will be replaced 
    * by the newuri. After this query, that current URI won't be available anymore. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri Old URI identifier
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#updateEntityUri
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function oldUri($uri)
    {
      $this->params["olduri"] = urlencode($uri);
    } 
    
           
    /**
    * This is the new URI to define for the entity. This URI is replacing the 
    * olduri. After this query, this is the URI that will be referring to this entity. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri New URI identifier
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#updateEntityUri
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function newUri($uri)
    {
      $this->params["newuri"] = urlencode($uri);
    }        
    
    /**
    * Enable advanced indexation of the ontology. This means that the ontology's description 
    * (so all the classes, properties and named individuals) will be indexed in the other 
    * data management system in structWSF. This means that all the information in these 
    * ontologies will be accessible via the other endpoints such as the Search and the SPARQL 
    * web service endpoints. Enabling this option may render the creation process slower 
    * depending on the size of the created ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#updateEntityUri
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function enableAdvancedIndexation()
    {
      $this->params["advancedIndexation"] = "True";
    }
    
    /**
    * Disable advanced indexation of the ontology. This means that the ontologies will be queriable 
    * via the Ontology Read, Ontology Update and Ontology Delete web service endpoints only
    * 
    * This is the default behavior of this service.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#updateEntityUri
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function disableAdvancedIndexation()
    {
      $this->params["advancedIndexation"] = "False";
    } 
  }    
 
//@}    
?>