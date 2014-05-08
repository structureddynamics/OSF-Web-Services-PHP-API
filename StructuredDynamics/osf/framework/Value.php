<?php
  
  namespace StructuredDynamics\osf\framework;
  
  use \StructuredDynamics\osf\framework\Resource;
  
  /**
  * Class describing a value of a property. A value can be textual or a reference
  * to another resource.
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class Value
  {
    /** Language of the value */
    private $language = NULL;
    
    /** URI of the Datatype of the value */
    private $datatype = NULL;
    
    /** Actual value of the Value. It can be anything, including a URI reference */
    private $value;
    
    /** Reification statements that reify the Resource, Property and Value triple */
    private $reifications;
    
    /**
    * Constructor
    * 
    * @param mixed $value Value to be created. It can be anything including a URI reference
    * @param mixed $language Optional language of the value. This should only be used if
    *                        the value is textual and can have a language associated to it
    * @param mixed $datatype Optional URI of the Datatype of the value
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    function __construct($value = '', $language = NULL, $datatype = NULL)
    {
      $this->value = $value;
      $this->language = $language;
      $this->datatype = $datatype;
    }      
    
    /**
    * Get the actual value content of this Value
    * 
    * @return Return the value content of this Value
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function content()
    {
      return($this->value);
    }
    
    /**
    * Get the language of this Value.
    * 
    * @return Return the ISO 639 language code of this value. If NULL is returned
    *         it means that no language is specified for this Value (so it is
    *         considered language neutral).
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function language()    
    {
      return($this->language);
    }
    
    /**
    * Get the URI of the datatype of the Value
    * 
    * @return Return the URI of the datatype of the value. If NULL is returned
    *         it means that no specific datatype has been defined for this value
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function type()
    {
      return($this->datatype);
    }
    
    /**
    * Display the value.
    * 
    * The display is used using the "echo" language construct
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function display()
    {
      echo $this->value;
    }
    
    
    // 
    // $reification is a 
    /**
    * Add reification statement(s) to the value (in fact, the entire triple formed by the 
    * resource->property->value)
    * 
    * @param ReificationStatementResource ReificationStatement that describe the set of 
    *                                     reification statements for this triple
    * @return Value
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function addReifications(ReificationStatementResource $reifications)
    {
      $this->reifications = $reifications;
      
      return($this);
    }
    
    /**
    * Get the reification statements for the triple composed of this value,
    * the property and the resource.
    * 
    * @return ReificationStatementResource 
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function reifications()
    {
      return($this->reifications);
    }
  }
?>
