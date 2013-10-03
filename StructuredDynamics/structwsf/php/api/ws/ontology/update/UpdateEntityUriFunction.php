<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\ontology\update\UpdateEntityUriFunction.php
      @brief UpdateEntityUriFunction class description
   */

  namespace StructuredDynamics\osf\php\api\ws\ontology\update;
  
  /**
  * Class used to define the parameters to use send a "updateEntityUriFunction" call 
  * to the Ontology: Update web service endpoint.
  *       
  * @see http://techwiki.openstructs.org/index.php/Ontology_Update#updateEntityUri
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class UpdateEntityUriFunction extends \StructuredDynamics\osf\php\api\framework\OntologyFunctionCall
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
      
      return($this);
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
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#updateEntityUri
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
    * @see http://techwiki.openstructs.org/index.php/Ontology_Update#updateEntityUri
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