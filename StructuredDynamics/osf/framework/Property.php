<?php
  
  namespace StructuredDynamics\osf\framework;
  
  use \StructuredDynamics\osf\framework\Value;
  use \StructuredDynamics\osf\framework\Resource;
  
  /**
  * Class describing a Property of a Resource
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class Property
  {
    /** URI of the property */
    private $uri;
    
    /** Type of the property. Can be an Datatype or an Object property */
    private $type = DATATYPE_PROPERTY;
    
    /** All values of that property */
    private $values = [];
    
    /** Reference to the resource that this Property instance is describing */
    private $resource = NULL;
    
    /** 
    * Constructor
    * 
    * @param mixed $uri URI of the property to create
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    function __construct($uri)
    {
      $this->uri = $uri;
    }    
    
    /**
    * Return a value defined for a property. If a language is defined for the
    * Resource then the index is the one of the sub-set of values that is
    * composed of all the values of the language specified for the Resource.
    * 
    * The index start at 1, unlike arrays.
    * 
    * @param mixed $id ID of the value to return.
    * @return mixed Return a Value instance that represents that value. An
    *               empty Value instance will be returned if there is no
    *               Value for that index
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function value($id = 1)
    {
      if($id < 1)
      {
        $id = 1;
      }
      
      // Return an empty value if there is no values for this property
      if(empty($this->values))
      {
        return(new Value());
      }
      
      // If a language is specified for this Resource, then return
      // a value only if the value has 
      if(!is_null($this->resource->language()) && $this->type === DATATYPE_PROPERTY)
      {
        $langID = 1;
        foreach($this->values as $value)
        {
          if(($value->language() == $this->resource->language() ||
             (is_null($resource) && is_null($value->language())) ||  
             (!is_null($resource) && !$this->resource->isLanguageStrict() && is_null($value->language()))) &&
             $langID == $id)
          {
            return($this->values[($langID - 1)]);  
          }
          
          $langID++;
        }
        
        return(new Value());
      }
      
      return($this->values[($id - 1)]);  
    }
    
    /**
    * Get all the values of that Property. If the property is a Datatype property and 
    * if a language is defined for the Resource, then all the values that will 
    * be returned are values that have this language.
    * 
    * @return Return an array of Value instances. One for each value of that property.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function values()
    {
      if(!is_null($this->resource->language()) && $this->type === DATATYPE_PROPERTY)
      {
        $languageSpecificValues = [];
        
        foreach($this->values as $value)
        {
          if($value->language() == $this->resource->language() ||
             (is_null($resource) && is_null($value->language())) ||  
             (!is_null($resource) && !$this->resource->isLanguageStrict() && is_null($value->language())))
          {
            $languageSpecificValues[] = $value;
          }
        }
        
        return($languageSpecificValues);
      }
      
      return($this->values);  
    }
    
    /**
    * Add a Value to this property
    * 
    * @param Value $value value to add to this property
    * @return Property
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function addValue(Value $value)
    {
      $this->values[] = $value;
      
      return($this);
    }
    
    /**
    * Get the type of tihs property. Can be DATATYPE_PROPERTY or
    * OBJECT_PROPERTY
    * 
    * @return Return the type of the property. It can be de constant DATATYPE_PROPERTY
    *         or the constant OBJECT_PROPERTY
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function type()
    {
      return($this->type);
    }

    /**
    * Get the URI of this property
    * 
    * @return Return the full URI of that property
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri()
    {
      return($this->uri);
    }

    /**
    * Specify that the property is an OBJECT_PROPERTY. By default, when a Property
    * is created, it is considered a DATATYPE_PROPERTY.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function isObjectProperty()
    {
      $this->type = OBJECT_PROPERTY;
      
      return($this);
    }
    
    /**
    * Specify if there are values for that property. If the resource
    * has a specific language specified for it, and if this is a DATATYPE_PROPERTY
    * then exists will return TRUE only if there is a value with that language.
    * 
    * @return TRUE is there is at least a value for that property. 
    *         FALSE otherwise.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function exists()
    {
      if((!is_null($resource) && is_null($this->resource->language())) ||
         $this->type === OBJECT_PROPERTY)
      {
        if(empty($this->values))
        {
          return(FALSE);
        }
        else
        {
          return(TRUE);
        }
      }
      else
      {
        foreach($this->values as $value)
        {
          if($this->type === OBJECT_PROPERTY ||
             $value->language() == $this->resource->language() ||
             (is_null($resource) && is_null($value->language())) ||  
             (!is_null($resource) && !$this->resource->isLanguageStrict() && is_null($value->language())))
          {
            return(TRUE);
          }
        }
        
        return(FALSE);
      }
    }
    
    /**
    * Specify a reference to the resource that this property defines.
    * This function is not intended to be used except by the BaseResource()
    * class.
    * 
    * @param Resource $resource Resource reference that is defined by this property
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function defineResource(Resource &$resource)
    {
      $this->resource = $resource;
      
      // Make sure the URI of this property is unprefixed
      $this->uri = $this->resource->namespaces->getUnprefixedUri($this->uri);
      
      return($this);
    }    
  }
?>
