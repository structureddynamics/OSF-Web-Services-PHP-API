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
      $this->sourceInterface("default");
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
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
      
      return($this);
    }        
  }    
 
//@}    
?>