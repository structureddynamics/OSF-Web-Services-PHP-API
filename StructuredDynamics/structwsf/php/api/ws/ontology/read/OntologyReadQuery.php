<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\ontology\read\OntologyReadQuery.php
      @brief OntologyReadQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\ontology\read;

  /**
  * Ontology Read Query to a structWSF Ontology Read web service endpoint
  * 
  * The Ontology Read service is used to query OWL ontologies. All kinds of information 
  * can be read on different ontology entities such as: classes, object properties, 
  * datatype properties, annotation properties and individuals. Reasoners can also be 
  * used to include inferred facts in the service's resultset. A full list of actions 
  * can be performed that enables you to leverage your ontologies, properly and 
  * effectively.
  * 
  * This service is a Web service wrapper over the OWLAPI ontology library. Most of the 
  * API has been implemented. So we can say that this Web service (with the other related 
  * structWSF services) turns the OWLAPI into a Web service API. 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  use \StructuredDynamics\structwsf\php\api\ws\ontology\read\OntologyReadQuery;
  *  use \StructuredDynamics\structwsf\php\api\ws\ontology\read\GetClassesFunction;
  *  
  *  // Create the Ontology Read query
  *  $ontologyRead = new OntologyReadQuery("http://demo.citizen-dan.org/ws/");
  *  
  *  // Enable the reasoner for this query
  *  $ontologyRead->enableReasoner();
  *  
  *  // Specify the MUNI ontology from the citizen demo website
  *  $ontologyRead->ontology("file://localhost/data/ontologies/files/demo.citizen-dan.org/muni.owl");
  *  
  *  // Specify that we want RDF+XML data as output
  *  $ontologyRead->mime("application/rdf+xml");
  *  
  *  // Prepare the function call to send to the endpoint.
  *  $getClassesFunction = new GetClassesFunction();
  *  
  *  // Sepcify that we want all the classes URIs from this ontology
  *  $getClassesFunction->getClassesUris();
  *  
  *  // Specify that we only want to first 20 results
  *  $getClassesFunction->limit(20);
  *  $getClassesFunction->offset(0);
  *  
  *  // Prepare the getClasses call
  *  $ontologyRead->getClasses($getClassesFunction);
  *  
  *  // Send the query
  *  $ontologyRead->send();
  *  
  *  if($ontologyRead->isSuccessful())
  *  {
  *    echo $ontologyRead->getResultset();
  *  }
  *  else
  *  {
  *    echo "Ontology importation failed: ".$ontologyRead->getStatus()." (".$ontologyRead->getStatusMessage().")\n";
  *    echo $ontologyRead->getStatusMessageDescription();       
  *  }
  * 
  * @endcode
  * 
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class OntologyReadQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("ontology/read/");
      
      // Set default parameters for this query
      $this->ontology("");
      $this->enableReasoner();
      
    }
  
    /**
    * URI of the ontology to query
    * 
    * Note: you can get the list of all loaded ontologies by using the getLoadedOntologies() function
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $ontologyUri URI of the ontology to query
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function ontology($ontologyUri)
    {
      $this->params["ontology"] = urlencode($ontologyUri);
    }
    
    /**
    * Enable the reasoner for querying this ontology
    * 
    * This is the default behavior of this service.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function enableReasoner()
    {
      $this->params["reasoner"] = "True";
    }
    
    /**
    * Disable the reasoner for querying this ontology
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function disableReasoner()
    {
      $this->params["reasoner"] = "False";
    }
   
    /**
    * Get the list of all loaded ontologies on the structWSF network instance.
    * 
    * @param mixed $function A reference to a GetLoadedOntologiesFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getLoadedOntologies
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getLoadedOntologies(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetLoadedOntologiesFunction')
      {
        $this->params["function"] = "getLoadedOntologies";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }
       
    /**
    * Get the list of all the ontologies of the import closure of the ontology being 
    * queried. If you want to get the list of all individually loaded ontologies file 
    * of this instance, use the getLoadedOntologies API call instead. 
    * 
    * @param mixed $function A reference to a GetOntologiesFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getOntologies
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getOntologies(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetOntologiesFunction')
      {
        $this->params["function"] = "getOntologies";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }    
       
    /**
    * Get the serialized document that represents the OWL ontology. The serialization 
    * format (usually RDF+XML or RDF+N3) depends on the format used when the ontology 
    * got created. The same format will be used as an output of this function call. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getLoadedOntologies
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getSerialized()
    {
      $this->params["function"] = "getSerialized";
    } 
    
    /**
    * Get the serialized PHP array structure, used by conStruct and structWSF, that 
    * represents the classes structure of the OWL ontology.
    * 
    * There are no function parameters for this function call. The ontology to 
    * serialize is determined by the ontology query parameter. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSerializedClassHierarchy
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getSerializedClassHierarchy()
    {
      $this->params["function"] = "getSerializedClassHierarchy";
    }  
    
    /**
    * Get the serialized PHP array structure, used by conStruct and structWSF, that 
    * represents the properties structure of the OWL ontology.
    * 
    * There are no function parameters for this function call. The ontology to serialize 
    * is determined by the ontology query parameter. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSerializedPropertyHierarchy
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getSerializedPropertyHierarchy()
    {
      $this->params["function"] = "getSerializedPropertyHierarchy";
    }  
    
    /**
    * Get the serialized PHP array structure, used by conStruct and structWSF, that represents 
    * the properties structure of the OWL ontology.
    * 
    * There are no function parameters for this function call. The ontology to serialize is determined 
    * by the ontology query parameter. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getIronXMLSchema
    * @see http://techwiki.openstructs.org/index.php/Instance_Record_and_Object_Notation_(irON)_Specification#Structure_Schema_Object_2
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getIronXMLSchema()
    {
      $this->params["function"] = "getIronXMLSchema";
    }  
    
    
    /**
    * Get the ironJSON Schema, used by the Semantic Components, that represents the OWL ontology.
    * 
    * There are no function parameters for this function call. The ontology to serialize is 
    * determined by the ontology query parameter. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getIronJsonSchema
    * @see http://techwiki.openstructs.org/index.php/Instance_Record_and_Object_Notation_(irON)_Specification#Structure_Schema_Object_3
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getIronJsonSchema()
    {
      $this->params["function"] = "getIronJsonSchema";
    }      
    
    /**
    * Get the description of a class, in a target ontology. 
    * 
    * @param mixed $function A reference to a GetClassFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClass
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClass(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetClassFunction')
      {
        $this->params["function"] = "getClass";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }     
    
    /**
    * Get all the classes that have been defined in an ontology. The requester can get 
    * a list of URIs or the full description of the classes. 
    * 
    * @param mixed $function A reference to a GetClassesFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClasses(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetClassesFunction')
      {
        $this->params["function"] = "getClasses";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }  
    
    /**
    * Get all the sub-classes of a target class of the ontology. The requester can 
    * get a list of URIs or the full description of the sub-classes. 
    * 
    * @param mixed $function A reference to a GetSubClassesFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getSubClasses(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetSubClassesFunction')
      {
        $this->params["function"] = "getSubClasses";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }
    
    /**
    * Get all the super-classes of a target class of the ontology. The requester can 
    * get a list of URIs or the full description of the super-classes. 
    * 
    * @param mixed $function A reference to a GetSuperClassesFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getSuperClasses(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetSuperClassesFunction')
      {
        $this->params["function"] = "getSuperClasses";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }    
    
    /**
    * Get all the equivalent-classes of a target class of the ontology. The requester can 
    * get a list of URIs or the full description of the equivalent-classes.  
    * 
    * @param mixed $function A reference to a GetEquivalentClassesFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getEquivalentClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getEquivalentClasses(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetEquivalentClassesFunction')
      {
        $this->params["function"] = "getEquivalentClasses";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }    
    
    /**
    * Get all the disjoint-classes of a target class of the ontology. The requester can get 
    * a list of URIs or the full description of the disjoint-classes.   
    * 
    * @param mixed $function A reference to a GetDisjointClassesFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getDisjointClasses(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetDisjointClassesFunction')
      {
        $this->params["function"] = "getDisjointClasses";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }    
    
    /**
    * Get the description of a property, in a target ontology. 
    * 
    * @param mixed $function A reference to a GetPropertyFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperty
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getProperty(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetPropertyFunction')
      {
        $this->params["function"] = "getProperty";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }   
    
    /**
    * Get all the properties that have been defined in an ontology. The requester can 
    * get a list of URIs or the full description of the properties. 
    * 
    * @param mixed $function A reference to a GetPropertiesFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getProperties(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetPropertiesFunction')
      {
        $this->params["function"] = "getProperties";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }    
    
    /**
    * Get all the sub-properties that have been defined in an ontology. The requester can 
    * get a list of URIs or the full description of the sub-properties. 
    * 
    * @param mixed $function A reference to a GetSubPropertiesFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getSubProperties(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetSubPropertiesFunction')
      {
        $this->params["function"] = "getSubProperties";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }    
    
    /**
    * Get all the super-properties that have been defined in an ontology. The requester 
    * can get a list of URIs or the full description of the super-properties. 
    * 
    * @param mixed $function A reference to a GetSuperPropertiesFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getSuperProperties(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetSuperPropertiesFunction')
      {
        $this->params["function"] = "getSuperProperties";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }   
    
    /**
    * Get all the disjoint-properties that have been defined in an ontology. The requester 
    * can get a list of URIs or the full description of the disjoint-properties. 
    * 
    * @param mixed $function A reference to a GetDisjointPropertiesFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getDisjointProperties(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetDisjointPropertiesFunction')
      {
        $this->params["function"] = "getDisjointProperties";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }  
    
    /**
    * Get all the equivalent-properties that have been defined in an ontology. The requester can get a 
    * list of URIs or the full description of the equivalent-properties. 
    * 
    * @param mixed $function A reference to a GetEquivalentPropertiesFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getEquivalentProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getEquivalentProperties(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetEquivalentPropertiesFunction')
      {
        $this->params["function"] = "getEquivalentProperties";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }
        
    /**
    * Get the description of a named individual, in a target ontology.
    * 
    * @param mixed $function A reference to a GetNamedIndividualFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getNamedIndividual
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getNamedIndividual(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetNamedIndividualFunction')
      {
        $this->params["function"] = "getNamedIndividual";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }     
        
    /**
    * Get all the named individuals that have been defined in an ontology. The requester can get 
    * a list of URIs or the full description of the named individuals. 
    * 
    * @param mixed $function A reference to a GetNamedIndividualsFunction object instance.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getNamedIndividuals
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getNamedIndividuals(&$function)
    {
      if(get_class($function) == 'StructuredDynamics\structwsf\php\api\ws\ontology\read\GetNamedIndividualsFunction')
      {
        $this->params["function"] = "getNamedIndividuals";
        
        $this->params["parameters"] = $function->getParameters();
      }
    }    
  }
  
  /**
  * Class used to define the parameters to use send a "GetLoadedOntologies" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getLoadedOntologies
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetLoadedOntologiesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      $this->modeUris();
    }    
    
    /**
    * Set the mode of the request to "uris"
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getLoadedOntologies
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function modeUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Set the mode of the request to "descriptions"
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getLoadedOntologies
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function modeDescriptions()
    {
      $this->params["mode"] = "descriptions";
    } 
  } 
  
 /**
  * Class used to define the parameters to use send a "getClass" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClass
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetClassFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    /**
    * Specifies the URI of the class to get its description from the ontology
    * 
    * @param mixed $uri URI of the property to delete from the ontology
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClass
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
  }  
    
 /**
  * Class used to define the parameters to use send a "getClasses" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClasses
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetClassesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getClassesUris();
    }
    
    /**
    * Get a list of URIs that refers to the classes described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Get the list of classes description for the classes described in this ontology.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesDescriptions()
    {
      $this->params["mode"] = "descriptions";
    }
    
    /**
    * The number of results the requester wants in the resultset.
    * 
    * @param mixed $limit The number of results the requester wants in the resultset. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function limit($limit)
    {
      $this->params["limit"] = $limit;
    }    
    
    /**
    * Where the results to return starts in the complete list of results. This is 
    * normally used in conjunction with the limit parameter to paginate the complete 
    * list of classes. 
    * 
    * @param mixed $offset Where the results to return starts in the complete list of results.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function offset($offset)
    {
      $this->params["offset"] = $offset;
    }    
  }    
  
 /**
  * Class used to define the parameters to use send a "getSubClasses" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubClasses
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetSubClassesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getClassesUris();
      $this->directSubClasses();
    }
    
    /**
    * URI of the class for which the requester want its sub-classes. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the class for which the requester want its sub-classes. 
    *       
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
    
    /**
    * Get a list of URIs that refers to the sub-classes described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Get the list of classes description for the sub-classes described in this ontology
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesDescriptions()
    {
      $this->params["mode"] = "descriptions";
    }
    
    
    /**
    * Get the list of classes description for the sub-classes described in this ontology. 
    * The class description being returned is a lightweight version of the full 
    * "descriptions" mode. The goal is to manipulate and transmit a simpler structure 
    * such as what might be used by a user interface to display some parts of the hierarchy 
    * of an ontology. What is returned is all the annotation properties (used to get some 
    * label to display for one of the sub-class) and a possible attribute: "sco:hasSubClass" 
    * which has "true" as value. If this triple exists, it means that the sub-class has 
    * itself other subclasses (this is mainly used to be able to display an "extend" 
    * button in a tree control). 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getHierarchy()
    {
      $this->params["mode"] = "hierarchy";
    }    
    
    /**
    * Only get the direct sub-classes of the target class. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function directSubClasses()
    {
      $this->params["direct"] = "True";
    }    

    /**
    * Get all the sub-classes by inference (so, the sub-classes of the 
    * sub-classes recursively). 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function allSubClasses()
    {
      $this->params["direct"] = "False";
    }    
  }  
  
  /**
  * Class used to define the parameters to use send a "getSuperClasses" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperClasses
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetSuperClassesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getClassesUris();
      $this->directSuperClasses();
    }
    
    /**
    * URI of the class for which the requester want its super-classes. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the class for which the requester want its super-classes. 
    *       
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
    
    /**
    *   Get a list of URIs that refers to the super-classes described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Get the list of classes description for the super-classes described in this ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesDescriptions()
    {
      $this->params["mode"] = "descriptions";
    }
                 
    /**
    * Only get the direct super-classes of the target class. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function directSuperClasses()
    {
      $this->params["direct"] = "True";
    }    

    /**
    * Get all the super-classes by inference (so, the sub-classes of the 
    * super-classes recursively). 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function allSuperClasses()
    {
      $this->params["direct"] = "False";
    }    
  }  

  /**
  * Class used to define the parameters to use send a "getEquivalentClasses" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getEquivalentClasses
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetEquivalentClassesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getClassesUris();
    }
        
    /**
    * URI of the class for which the requester want its equivalent-classes. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the class for which the requester want its equivalent-classes. 
    *       
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getEquivalentClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
    
    /**
    *   Get a list of URIs that refers to the equivalent-classes described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getEquivalentClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Get the list of classes description for the equivalent-classes described in this ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getEquivalentClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesDescriptions()
    {
      $this->params["mode"] = "descriptions";
    }   
  }  

  /**
  * Class used to define the parameters to use send a "getDisjointClasses" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointClasses
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetDisjointClassesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getClassesUris();
    }
    
    /**
    * URI of the class for which the requester want its disjoint-classes. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the class for which the requester want its disjoint-classes. 
    *       
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
    
    /**
    *   Get a list of URIs that refers to the disjoint-classes described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Get the list of classes description for the disjoint-classes described in this ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointClasses
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getClassesDescriptions()
    {
      $this->params["mode"] = "descriptions";
    }   
  }  
  
 /**
  * Class used to define the parameters to use send a "getProperty" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperty
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetPropertyFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    /**
    * The URI of the property for which you want its description
    * 
    * @param mixed $uri The URI of the property for which you want its description
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperty
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
  }  
  
 /**
  * Get all the properties that have been defined in an ontology. The 
  * requester can get a list of URIs or the full description of the properties. 
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetPropertiesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getAllPropertiesTypes();
      $this->getPropertiesUris();
    }
    
    /**
    * Get all the Annotation properties of the ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getAnnotationProperties()
    {
      $this->params["type"] = "annotationproperty";
    }
    
    /**
    * Get all the Datatype properties of the ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getDatatypeProperties()
    {
      $this->params["type"] = "dataproperty";
    }
    
    /**
    * Get all the Object properties of the ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getObjectProperties()
    {
      $this->params["type"] = "objectproperty";
    }    
    /**
    * Get all the Datatype, Object and Annotation properties of the ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getAllPropertiesTypes()
    {
      $this->params["type"] = "all";
    }
    
    /**
    * Get a list of URIs that refers to the properties described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Get the list of properties description for the classes described in this ontology.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesDescriptions()
    {
      $this->params["mode"] = "descriptions";
    }
    
    /**
    * The number of results the requester wants in the resultset.
    * 
    * @param mixed $limit The number of results the requester wants in the resultset. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function limit($limit)
    {
      $this->params["limit"] = $limit;
    }    
    
    /**
    * Where the results to return starts in the complete list of results. This is 
    * normally used in conjunction with the limit parameter to paginate the complete 
    * list of classes. 
    * 
    * @param mixed $offset Where the results to return starts in the complete list of results.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function offset($offset)
    {
      $this->params["offset"] = $offset;
    }    
  }  
  
  /**
  * Get all the sub-properties that have been defined in an ontology. The requester 
  * can get a list of URIs or the full description of the sub-properties. 
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubProperties
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetSubPropertiesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getDatatypeProperties();
      $this->getPropertiesUris();
      $this->allSubProperties();
    }
        
    /**
    * URI of the property for which the requester want its sub-properties. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the property for which the requester want its sub-properties. 
    *       
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
        
    
    /**
    * Get all the Datatype sub-properties of the ontology  
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getDatatypeProperties()
    {
      $this->params["type"] = "dataproperty";
    }
    
    /**
    * Get all the Object sub-properties of the ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getObjectProperties()
    {
      $this->params["type"] = "objectproperty";
    }    
    
    /**
    * Get a list of URIs that refers to the properties described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#v
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Get the list of properties description for the classes described in this ontology.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesDescriptions()
    {
      $this->params["mode"] = "descriptions";
    }  
                    
    /**
    * Only get the direct sub-properties of the target property. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function directSubProperties()
    {
      $this->params["direct"] = "True";
    }    

    /**
    * Get all the sub-properties by inference (so, the sub-properties of 
    * the sub-properties recursively). 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSubProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function allSubProperties()
    {
      $this->params["direct"] = "False";
    }     
  }     

  /**
  * Get all the super-properties that have been defined in an ontology. The requester 
  * can get a list of URIs or the full description of the super-properties. 
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperProperties
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetSuperPropertiesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getDatatypeProperties();
      $this->getPropertiesUris();
      $this->allSuperProperties();
    }
        
    /**
    * URI of the property for which the requester want its super-properties. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the property for which the requester want its super-properties. 
    *       
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
        
    
    /**
    * Get all the Datatype super-properties of the ontology  
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getDatatypeProperties()
    {
      $this->params["type"] = "dataproperty";
    }
    
    /**
    * Get all the Object super-properties of the ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getObjectProperties()
    {
      $this->params["type"] = "objectproperty";
    }    
    
    /**
    * Get a list of URIs that refers to the properties described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#v
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Get the list of properties description for the classes described in this ontology.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesDescriptions()
    {
      $this->params["mode"] = "descriptions";
    }  
                    
    /**
    * Only get the direct super-properties of the target property. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function directSuperProperties()
    {
      $this->params["direct"] = "True";
    }    

    /**
    * Get all the super-properties by inference (so, the super-properties of 
    * the super-properties recursively). 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getSuperProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function allSuperProperties()
    {
      $this->params["direct"] = "False";
    }     
  } 
  
  /**
  * Get all the disjoint-properties that have been defined in an ontology. The requester 
  * can get a list of URIs or the full description of the disjoint-properties. 
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointProperties
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetDisjointPropertiesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getDatatypeProperties();
      $this->getPropertiesUris();
      $this->allDisjointProperties();
    }
        
    /**
    * URI of the property for which the requester want its disjoint-properties. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the property for which the requester want its disjoint-properties. 
    *       
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
    
    /**
    * Get all the Datatype disjoint-properties of the ontology  
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getDatatypeProperties()
    {
      $this->params["type"] = "dataproperty";
    }
    
    /**
    * Get all the Object disjoint-properties of the ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getObjectProperties()
    {
      $this->params["type"] = "objectproperty";
    }    
    
    /**
    * Get a list of URIs that refers to the properties described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#v
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Get the list of properties description for the classes described in this ontology.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesDescriptions()
    {
      $this->params["mode"] = "descriptions";
    }  
                    
    /**
    * Only get the direct disjoint-properties of the target property. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function directDisjointProperties()
    {
      $this->params["direct"] = "True";
    }    

    /**
    * Get all the disjoint-properties by inference (so, the disjoint-properties of 
    * the disjoint-properties recursively). 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getDisjointProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function allDisjointProperties()
    {
      $this->params["direct"] = "False";
    }     
  }
  
  /**
  * Get all the equivalent-properties that have been defined in an ontology. The requester 
  * can get a list of URIs or the full description of the equivalent-properties. 
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getEquivalentProperties
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetEquivalentPropertiesFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getDatatypeProperties();
      $this->getPropertiesUris();
      $this->allEquivalentProperties();
    }
        
    /**
    * URI of the property for which the requester want its equivalent-properties. 
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the property for which the requester want its equivalent-properties. 
    *       
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getEquivalentProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
    
    /**
    * Get all the Datatype equivalent-properties of the ontology  
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getEquivalentProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getDatatypeProperties()
    {
      $this->params["type"] = "dataproperty";
    }
    
    /**
    * Get all the Object equivalent-properties of the ontology 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getEquivalentProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getObjectProperties()
    {
      $this->params["type"] = "objectproperty";
    }    
    
    /**
    * Get a list of URIs that refers to the properties described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#v
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Get the list of properties description for the classes described in this ontology.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getEquivalentProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getPropertiesDescriptions()
    {
      $this->params["mode"] = "descriptions";
    }  
                    
    /**
    * Only get the direct equivalent-properties of the target property. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getEquivalentProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function directEquivalentProperties()
    {
      $this->params["direct"] = "True";
    }    

    /**
    * Get all the equivalent-properties by inference (so, the equivalent-properties of 
    * the equivalent-properties recursively). 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getEquivalentProperties
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function allEquivalentProperties()
    {
      $this->params["direct"] = "False";
    }     
  }
  
 /**
  * Class used to define the parameters to use send a "getNamedIndividual" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getNamedIndividual
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetNamedIndividualFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    /**
    * Specifies the URI of the named individual to get its description from the ontology
    * 
    * @param mixed $uri URI of the property to delete from the ontology
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getNamedIndividual
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri($uri)
    {
      $this->params["uri"] = $uri;
    }
  } 
  
   
 /**
  * Class used to define the parameters to use send a "getNamedIndividuals" call 
  * to the Ontology: Read web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getNamedIndividuals
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class GetNamedIndividualsFunction extends \StructuredDynamics\structwsf\php\api\framework\OntologyFunctionCall
  {
    function __construct()
    {
      // Default values
      $this->getNamedIndividualsUris();
      $this->allNamedIndividuals();
      
    }
    
    /**
    * Get a list of URIs that refers to the named individuals described in this ontology. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getNamedIndividuals
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getNamedIndividualsUris()
    {
      $this->params["mode"] = "uris";
    }
    
    /**
    * Get the list of named individuals description for the named individuals described in this ontology.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getNamedIndividuals
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getNamedIndividualsDescriptions()
    {
      $this->params["mode"] = "descriptions";
    }
    
    
    /**
    * Get the list of named individuals description described in this ontology. This list of named 
    * individuals has been optimized for list controls. Only the types and the prefLabel of the 
    * named individual has been added to its description. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getNamedIndividuals
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getNamedIndividualsList()
    {
      $this->params["mode"] = "list";
    }    
    
    /**
    * The number of results the requester wants in the resultset.
    * 
    * @param mixed $limit The number of results the requester wants in the resultset. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getNamedIndividuals
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function limit($limit)
    {
      $this->params["limit"] = $limit;
    }    
    
    /**
    * Where the results to return starts in the complete list of results. This is 
    * normally used in conjunction with the limit parameter to paginate the complete 
    * list of named individuals. 
    * 
    * @param mixed $offset Where the results to return starts in the complete list of results.
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getNamedIndividuals
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function offset($offset)
    {
      $this->params["offset"] = $offset;
    } 
    
    /**
    * Get all the named individuals that belong to the class referenced by the classuri 
    * parameter, and all the named individuals that belongs to all the super-classes 
    * of that target class. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getNamedIndividuals
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function directNamedIndividuals()
    {
      $this->params["direct"] = "True";
    }    

    /**
    *   Get all the named individuals that belong directly to 
    * that class referenced by the classuri parameter. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Ontology_Read#getNamedIndividuals
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function allNamedIndividuals()
    {
      $this->params["direct"] = "False";
    }         
  }     
 
//@}    
?>