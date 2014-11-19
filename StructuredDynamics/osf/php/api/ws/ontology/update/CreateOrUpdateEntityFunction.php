<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\ontology\update\CreateOrUpdateEntityFunction.php
      @brief CreateOrUpdateEntityFunction class description
   */

  namespace StructuredDynamics\osf\php\api\ws\ontology\update;
  
  /**
  * Class used to define the parameters to use send a "createOrUpdateEntity" call 
  * to the Ontology: Update web service endpoint.
  *       
  * @see http://wiki.opensemanticframework.org/index.php/Ontology_Update#createOrUpdateEntity
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class CreateOrUpdateEntityFunction extends \StructuredDynamics\osf\php\api\framework\OntologyFunctionCall
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
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Update#createOrUpdateEntity
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function document($document)
    {
      $this->params["document"] = urlencode($document);
      
      return($this);
    }    
    
    /**
    * Enable advanced indexation of the ontology. This means that the ontology's description 
    * (so all the classes, properties and named individuals) will be indexed in the other 
    * data management system in OSF. This means that all the information in these 
    * ontologies will be accessible via the other endpoints such as the Search and the SPARQL 
    * web service endpoints. Enabling this option may render the creation process slower 
    * depending on the size of the created ontology. 
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Update#createOrUpdateEntity
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
    * @see http://wiki.opensemanticframework.org/index.php/Ontology_Update#createOrUpdateEntity
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function disableAdvancedIndexation()
    {
      $this->params["advancedIndexation"] = "False";
      
      return($this);
    }   
  }    
 
//@}    
?>