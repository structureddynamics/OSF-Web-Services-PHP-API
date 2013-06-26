<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\ontology\read\GetSubClassesFunction.php
      @brief GetSubClassesFunction class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\ontology\read;  
  
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
 
//@}    
?>