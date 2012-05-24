<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\ontology\delete\OntologyDeleteQuery.php
      @brief OntologyDeleteQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\ontology\delete;

  use \StructuredDynamics\structwsf\php\api\framework\CRUDPermission;
  
  /**
  * The Ontology Delete service is used to delete an OWL ontology existing in the 
  * structWSF instance, or an entity in one of the ontology. An entity can be anything 
  * of: a class, an object property, a datatype property, an annotation property or a 
  * named individual.
  * 
  * This service is a web service wrapper over the OWLAPI ontology library. It wraps all 
  * the needed functionalities related to delete an ontology or an entity in an ontology. 
  * Most of the related API has been implemented. So we can say that web service (with the 
  * other related services) turns the OWLAPI into a web service API.  
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  use \StructuredDynamics\structwsf\php\api\ws\ontology\create\OntologyCreateQuery;
  *  use \StructuredDynamics\structwsf\php\api\ws\ontology\delete\OntologyDeleteQuery;
  *  use \StructuredDynamics\structwsf\php\api\ws\ontology\delete\DeleteClassFunction;
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
  *  if(!$ontologyCreate->isSuccessful())
  *  {
  *    // Now delete one of the class of this ontology
  *    $ontologyDelete = new OntologyDeleteQuery("http://localhost/ws/");
  *    
  *    $ontologyDelete->ontology("http://www.w3.org/2006/vcard/ns");
  *    
  *    $deleteClassFunction = new DeleteClassFunction();
  *    
  *    $deleteClassFunction->uri("http://www.w3.org/2006/vcard/ns#Address");
  *    
  *    $ontologyDelete->deleteClass($deleteClassFunction);
  *
  *    $ontologyDelete->send();
  *    
  *    if($ontologyDelete->isSuccessful())
  *    {
  *      echo "Class successfully delete";
  *    }
  *    else
  *    {
  *      echo "Ontology class deletation failed: ".$ontologyDelete->getStatus()." (".$ontologyDelete->getStatusMessage().")\n";
  *      echo $ontologyDelete->getStatusMessageDescription();      
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
  * @see http://techwiki.openstructs.org/index.php/Ontology_Delete
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class OntologyDeleteQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("ontology/delete/");
      
      // Set default parameters for this query
    }
  
    /**
    * URI of the ontology; the URI of an Ontology dataset is the URL used to import that 
    * ontology in the system. The URL can be the URI of the ontology if it was resolvable 
    * on the Web, or the URL where the OWL file, containing the ontology's description, 
    * can be resolved by the server (on the web, on the file system, etc) via a URL.
    * 
    * Note: you can get the list of all loaded ontologies by using the getLoadedOntologies() function
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $ontology URI of the ontology to query
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Delete#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function ontology($ontology)
    {
      $this->params["ontology"] = urlencode($ontology);
    }
   
    /**
    * Delete an ontology from the system
    * 
    * @param mixed $function A reference to a GetLoadedOntologiesFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Delete#deleteOntology
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function deleteOntology(&$function)
    {
      $this->params["function"] = "deleteOntology";
    }
    
    /**
    * Delete a class from an ontology on the system
    * 
    * @param mixed $function A reference to a DeleteClassFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Delete#deleteClass
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function deleteClass(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\delete\DeleteClassFunction')
      {
        $this->params["function"] = "deleteClass";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }    
    
    /**
    * Delete a property from an ontology on the system
    * 
    * @param mixed $function A reference to a DeletePropertyFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Delete#deleteProperty
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function deleteProperty(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\delete\DeletePropertyFunction')
      {
        $this->params["function"] = "deleteProperty";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }     
    
    /**
    * Delete a named individual from an ontology on the system
    * 
    * @param mixed $function A reference to a DeleteNamedIndividualFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Delete#deleteNamedIndividual
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function deleteNamedIndividual(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\delete\DeleteNamedIndividualFunction')
      {
        $this->params["function"] = "deleteNamedIndividual";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }       
  }
  
 /**
  * Class used to define the parameters to use send a "deleteClass" call 
  * to the Ontology: Delete web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Delete#deleteClass
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class DeleteClassFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    /**
    * Specifies the URI of the class to delete from the ontology
    * 
    * @param mixed $uri URI of the class to delete from the ontology
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Delete#deleteClass
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
  }  

 /**
  * Class used to define the parameters to use send a "deleteProperty" call 
  * to the Ontology: Delete web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Delete#deleteProperty
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class DeletePropertyFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    /**
    * Specifies the URI of the property to delete from the ontology
    * 
    * @param mixed $uri URI of the property to delete from the ontology
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Delete#deleteProperty
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
  }
    
  /**
  * Class used to define the parameters to use send a "deleteNamedIndividual" call 
  * to the Ontology: Delete web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Delete#deleteNamedIndividual
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class DeleteNamedIndividualFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    /**
    * Specifies the URI of the named individual to delete from the ontology
    * 
    * @param mixed $uri URI of the named individual to delete from the ontology
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Delete#deleteNamedIndividual
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }    
  }  
 
//@}    
?>