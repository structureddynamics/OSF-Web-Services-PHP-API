<?php
  namespace StructuredDynamics\osf\framework;
  
  use \StructuredDynamics\osf\framework\Namespaces;

  define('DATATYPE_PROPERTY', 'http://www.w3.org/2002/07/owl#DatatypeProperty');     
  define('OBJECT_PROPERTY', 'http://www.w3.org/2002/07/owl#ObjectProperty');     
  
  /**
  * The BaseResource define the base variables and functions of a Resource.
  * This class is not to be instantiated. 
  * 
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class BaseResource 
  {
    /** Language tag as defined in ISO 639 */
    private $language = NULL;
    
    /** Specify if the language mode is strict or loose */
    private $strictLanguage = FALSE;
    
    /** URI of the current resource */
    protected $uri = ""; 
    
    /** Properties defining this resource */
    protected $properties = [];
    
    /** Types of this resource */
    protected $types = [];
    
    /** Namespaces that can be used by the resource to work with namespaces */
    public $namespaces;
    
    /**
    * Constructor
    * 
    * @param mixed $uri URI of the Resource to create
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    function __construct($uri)
    {
      $this->namespaces = new Namespaces();
      
      $this->uri = $this->namespaces->getUnprefixedUri($uri);
    }  
    
    /**
    * Set a type for that Resource. Multiple types can be set that way
    * 
    * @param mixed $type URI of the type to set
    * @return BaseResource
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    protected function setType($uri)
    {
      $uri = $this->namespaces->getUnprefixedUri($uri);
      
      if(!in_array($uri, $this->types))
      {
        $this->types[] = $uri;
      }
      
      return($this);      
    }
    
    /**
    * Get the URI of the Resource
    * 
    * @return The full URI of this Resource
    *
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function uri()
    {
      return($this->uri);
    }  
    
    /**
    * Get the language tag (ISO 639) restriction specified for this Resource
    * 
    * @return the ISO 639 language tag. If NULL is returned, it means that
    *         no language restriction is defined for this Resource at the
    *         moment
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function language()
    {
      return($this->language);
    }
    
    /**
    * Get the list of all the properties defining this Resource
    * 
    * @return Return an array of Property() instances that define this Resource
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function properties()
    {
      return($this->properties);
    } 
    
    /**
    * Get a specific property and all its values
    * 
    * @param mixed $uri URI of the property to get. The full URI of the property
    *                   can be used, or its "prefixed" (abridged) version. Such
    *                   a prefixed version would be "foaf:name". 
    * @return Property Return the Property instance with all its values. If the 
    *                  property is not existing, then an empty Property is
    *                  returned. An empty property is a property with an
    *                  empty URI and an empty set of values
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function property($uri)     
    {
      $uri = $this->namespaces->getUnprefixedUri($uri);
      
      if(isset($this->properties[$uri]))
      {
        // Return the property and all its values
        return($this->properties[$uri]);
      }
      
      // If nothing, return an empty property without values
      return(new Property(''));
    }
    
    /**
    * Add a property to the Resource's description
    * 
    * @param Property $property Property, and all its values, to add to the
    *                           Resource
    * @return BaseResource
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function addProperty(Property $property)
    {
      // Specify that this property define the current resource
      // That way, the property will know the defined language, 
      // will have access tot the $namespaces object, etc.
      $property->defineResource($this);
      
      $this->properties[$property->uri()] = $property;
      
      return($this);
    }
    
    /**
    * Get the types of the Resource
    * 
    * @return Return an array of URIs that refer to the types of this Resource
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function types()
    {
      if(empty($this->types))
      {
        return(array('http://www.w3.org/2002/07/owl#Thing'));
      }      
      else
      {
        return($this->types);
      }
    }
    
    /**
    * Get a type of this resource
    * 
    * The index start at 1, unlike arrays.
    * 
    * @param mixed $id ID of the type to return.
    * @return mixed Return the full URI of the type available for that index.
    *               NULL is returned if there is no type available for this index.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function type($id = 1)
    {
      if($id < 1)
      {
        $id = 1;
      }
      
      if(empty($this->types))
      {
        return('http://www.w3.org/2002/07/owl#Thing');
      }      
      else
      {
        return($this->types[($id - 1)]);
      }
    }    
    
    /**
    * Specify the language to be used when the user get values from this
    * Resource instance. If a language is specified, then all the functions
    * that returns values will only return values of that language. If the
    * specified language is NULL, then the values of all languages will
    * be returned. 
    * 
    * Note that the object properties are not affected by this setting.
    * 
    * @param mixed $language ISO 639 language tag
    * 
    * @return BaseResource
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function setLanguage($language = NULL)
    {
      $this->language = $language;
      
      return($this);
    }
    
    /**
    * Enables the "strict language" mode. If this mode is enabled, it means that
    * only the values tagged with that language will be returned for the
    * Datatype properties values. This means that all values that have a NULL 
    * (unspecified) language won't be returned by any functions that return values
    * 
    * @return BaseResource
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function strictLanguage()
    {
      $this->strictLanguage = TRUE;
      
      return($this);
    }

    /**
    * Enables the "loose language" mode. If this mode is enabled, it means that
    * the values tagged with that language, and the values without any language
    * defined for them will be returned for the Datatype properties values.
    * 
    * This is the default behavior.
    * 
    * @return BaseResource
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function looseLanguage()
    {
      $this->strictLanguage = FALSE;
      
      return($this);
    }
    
    /**
    * Specify if the Resource is using the strict language mode
    * 
    * @return Return TRUE is the Resource is using the strict language mode.
    *         Return FALSE otherwise.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function isLanguageStrict()
    {
      return($this->strictLanguage);
    }    
  }
  
?>
