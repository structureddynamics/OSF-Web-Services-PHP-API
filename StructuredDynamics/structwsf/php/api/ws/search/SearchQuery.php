<?php
               
  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\search\SearchQuery.php
      @brief SearchQuery class description
   */               
               
  namespace StructuredDynamics\structwsf\php\api\ws\search;
  
  /**
  * The Search Web service is used to perform full text searches on the structured 
  * data indexed on a structWSF instance. A search query can be as simple as querying 
  * the data store for a single keyword, or to query it using a series of complex 
  * filters. Each search query can be applied to all, or a subset of, datasets 
  * accessible by the requester. All of the full text queries comply with the 
  * Lucene querying syntax.
  * 
  * Each Search query can be filtered by these different filtering criteria:
  *  + Type of the record(s) being requested
  *  + Dataset where the record(s) got indexed
  *  + Presence of an attribute describing the record(s)
  *  + A specific value, for a specific attribute describing the record(s)
  *  + A distance from a lat/long coordinate (for geo-enabled structWSF instance)
  *  + A range of lat/long coordinates (for geo-enabled structWSF instance) 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  // Use the SearchQuery class
  *  use StructuredDynamics\structwsf\php\api\ws\search\SearchQuery;
  *  
  *  // Create the SearchQuery object
  *  $search = new SearchQuery("http://demo.citizen-dan.org/ws/");
  *  
  *  // Set the query parameter with the search keyword "elm"
  *  $search->query("school");
  *  
  *  // Send the search query to the endpoint
  *  $search->send();
  *  
  *  // Get back the resultset returned by the endpoint
  *  $resultset = $search->getResultset();
  *  
  *  // Print different serializations for that resultset
  *  print_r($resultset->getResultset());
  * 
  * @endcode
  * 
  * @see http://techwiki.openstructs.org/index.php/Search
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */  
  class SearchQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("search/");
      
      // Set default parameters for this query
      $this->query("");
      $this->typesFilters("all");
      $this->datasetsFilters("all");
      $this->attributesValuesFilters("all");
      $this->setAttributesBooleanOperatorToAnd();
      $this->items(10);
      $this->page(0);
      $this->disableInference();
      $this->includeAggregates();
      $this->setAggregateAttributesObjectTypeToLiteral();
      $this->numberOfAggregateAttributesObject(10);   
      $this->sourceInterface("default");
    }
  
    /**
    * Set the keywords to use for this search query.
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @param mixed $query Keywords to use to search for this query. Keywords can use some boolean operations. An empty string returns everything.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function query($query)
    {
      $this->params["query"] = urlencode($query);
      
      return($this);
    }
    
    /**
    * Set all the type filters to use for this search query
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @param mixed $types An array of types URI to use to filter the returned results.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function typesFilters($types)
    {
      if(!is_array($types))
      {
        $types = array("all");
      }
      else
      {      
        // Encode potential ";" characters
        foreach($types as $key => $type)
        {
          $types[$key] = str_replace(";", "%3B", $type);
        }
      }
      
      $this->params["types"] = urlencode(implode(";", $types));
      
      return($this);
    }
    
    /**
    * Add a type filter to use for this search query
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @param mixed $type A type URI to use to filter the returned results.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function typeFilter($type)
    {
      $type = str_replace(";", "%3B", $type);
      
      if(isset($this->params["types"]) && $this->params["types"] == "all")
      {
        $this->params["types"] = "";
      }
      
      if(isset($this->params["types"]) &&
         $this->params["types"] != "")
      {      
        $this->params["types"] .= urlencode(";".$type);
      }
      else
      {
        $this->params["types"] = urlencode($type);
      }      
   
      return($this);
    }  
    
    /**
    * Modifying the score of the results returned by the Search endpoint by
    * boosting the results that have that type, and boosting it by the
    * modifier weight.
    * 
    * @param mixed $type Type URI to boost
    * @param mixed $boostModifier Score modifier weight. Score modifier can be quite small like 0.0001, or
    *                             quite big like 10000.
    * @return SearchQuery
    */
    public function typeBoost($type, $boostModifier)
    {
      $type = str_replace(array(";", "^"), array("%3B", "%5E"), $type);
      
      if(isset($this->params["types_boost"]) &&
         $this->params["types_boost"] != "")
      {      
        $this->params["types_boost"] .= urlencode(";".$type.'^'.$boostModifier);
      }
      else
      {
        $this->params["types_boost"] = urlencode($type.'^'.$boostModifier);
      }      
   
      return($this);
    }    
    
    /**
    * Set all the dataset filters to use for this search query
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @param mixed $datasets An array of datasets URI to use to filter the returned results.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function datasetsFilters($datasets)
    {
      if(!is_array($datasets) || empty($datasets))
      {
        $datasets = array("all");
      }
      else
      {    
        // Encode potential ";" characters
        foreach($datasets as $key => $dataset)
        {
          $datasets[$key] = str_replace(";", "%3B", $dataset);
        }
      }
      
      $this->params["datasets"] = urlencode(implode(";", $datasets));
      
      return($this);
    }
    
    /**
    * Add a dataset filter to use for this search query
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @param mixed $dataset A datasets URI to use to filter the returned results.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function datasetFilter($dataset)
    {
      if($dataset == '')
      {
        return($this);
      }
      
      $dataset = str_replace(";", "%3B", $dataset);
      
      if($this->params["datasets"] == "all")
      {
        $this->params["datasets"] = "";
      }
      
      if(isset($this->params["datasets"]) &&
         $this->params["datasets"] != "")
      {      
        $this->params["datasets"] .= urlencode(";".$dataset);
      }
      else
      {
        $this->params["datasets"] = urlencode($dataset);
      }
      
      return($this);
    }    
    
    /**
    * Modifying the score of the results returned by the Search endpoint by
    * boosting the results that have that dataset, and boosting it by the
    * modifier weight.
    * 
    * @param mixed $dataset Dataset URI to boost
    * @param mixed $boostModifier Score modifier weight. Score modifier can be quite small like 0.0001, or
    *                             quite big like 10000.
    * @return SearchQuery
    */
    public function datasetBoost($dataset, $boostModifier)
    {
      $dataset = str_replace(array(";", "^"), array("%3B", "%5E"), $dataset);
      
      if(isset($this->params["datasets_boost"]) &&
         $this->params["datasets_boost"] != "")
      {      
        $this->params["datasets_boost"] .= urlencode(";".$dataset.'^'.$boostModifier);
      }
      else
      {
        $this->params["datasets_boost"] = urlencode($dataset.'^'.$boostModifier);
      }      
   
      return($this);
    }     
    
    /**
    * Set all the attribute/value filters to use for this search query
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @param mixed $attributes Array of attribute/value filters. If the value is "all", then
    *                          the query will only filter on the attribute's URI. This param
    *                          array looks like: 
    * 
    *                          Array("attribute-uri-1" => array("value-to-filter"), ...)
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function attributesValuesFilters($attributes="all")
    {
      $attrs = array();
      
      if(!is_array($attributes))
      {                                   
        array_push($attrs, "all");
      }
      else
      {
        foreach($attributes as $attribute => $values)
        {
          $filter = "";
          
          if(count($values) == 0)
          {
            array_push($attrs, urlencode($attribute));
          }
          else
          {
            foreach($values as $value)
            {
              $attribute = str_replace(";", "%3B", $attribute);
              $value = str_replace(";", "%3B", $value);
              
              $filter = urlencode($attribute)."::".urlencode($value);
              
              array_push($attrs, $filter);
            }
          }
        }
      }
      
      $this->params["attributes"] = urlencode(implode(";", $attrs));
      
      return($this);
    }
    
    /**
    * Modifying the score of the results returned by the Search endpoint by
    * boosting the results that have that attribute/value, and boosting it by the
    * modifier weight.
    * 
    * @param mixed $attribute Attribute URI to boost
    * @param mixed $boostModifier Score modifier weight. Score modifier can be quite small like 0.0001, or
    *                             quite big like 10000.
    * @param mixed $value Optional specific value to boost for the given attribute URI
    * @param boolean $valueIsUri Specify if the value  for this attribute has to be considered a URI
    *                            (this should be specified to TRUE if the attribute is an object property)
    * @return SearchQuery
    */
    public function attributeValueBoost($attribute, $boostModifier, $value = "", $valueIsUri = FALSE)
    {
      $attribute = str_replace(array(";", "^"), array("%3B", "%5E"), $attribute);
      
      if(isset($this->params["attributes_boost"]) &&
         $this->params["attributes_boost"] != "")
      {      
        $this->params["attributes_boost"] .= urlencode(";".$attribute.($valueIsUri && $value != "" ? "[uri]" : "").($value == '' ? '' : '::'.$value).'^'.$boostModifier);
      }
      else
      {
        $this->params["attributes_boost"] = urlencode($attribute.($valueIsUri && $value != "" ? "[uri]" : "").($value == '' ? '' : '::'.$value).'^'.$boostModifier);
      }      
   
      return($this);
    }   
    
    /**
    * Modifying the score of the results returned by the Search endpoint by
    * boosting the results where the field has all keywords within the
    * distance defined by phraseDistance().
    * 
    * @param mixed $attribute Attribute URI to boost
    * @param mixed $boostModifier Score modifier weight. Score modifier can be quite small like 0.0001, or
    *                             quite big like 10000.
    * @return SearchQuery
    */
    public function attributePhraseBoost($attribute, $boostModifier)
    {
      if(isset($this->params["attributes_phrase_boost"]) &&
         $this->params["attributes_phrase_boost"] != "")
      {      
        $this->params["attributes_phrase_boost"] .= urlencode(';'.$attribute).'^'.$boostModifier;
      }
      else
      {
        $this->params["attributes_phrase_boost"] = urlencode($attribute).'^'.$boostModifier;
      }      
   
      return($this);
    }
    
    /**
    * Define the maximum distance between the keywords of the search query that is 
    * used by the attributePhraseBoost().
    * 
    * @param mixed $distance Maximum distance betweeen the search terms
    */
    public function phraseBoostDistance($distance)
    {
      $this->params["phrase_boost_distance"] = $distance;
      
      return($this);
    }
    
    /**
    * Set an attribute/value(s) filter to use for this search query
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @param mixed $attribute Attribute URI of the filter
    * @param mixed $values Array of values for which we want to filter the search query
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function attributeValuesFilters($attribute, $values = array())
    {
      $attribute = str_replace(";", "%3B", $attribute);

      if($this->params["attributes"] == "all")
      {
        $this->params["attributes"] = "";
      }
      
      if(!is_array($values) && count($values) == 0)
      {
        if(isset($this->params["attributes"]) &&
           $this->params["attributes"] != "")
        {
          $this->params["attributes"] .= urlencode(";".$attribute);
        }
        else
        {
          $this->params["attributes"] = urlencode($attribute);
        }        
      }
      else
      {
        if(is_array($values))
        {
          foreach($values as $value)
          {
            $value = str_replace(";", "%3B", $value);
            
            $filter = urlencode($attribute)."::".urlencode($value);
            
            if(isset($this->params["attributes"]) &&
               $this->params["attributes"] != "")
            {     
              $this->params["attributes"] .= urlencode(";".$filter);     
            }
            else
            {
              $this->params["attributes"] = urlencode($filter);
            }
          }
        }
        else
        {
          $filter = urlencode($attribute)."::".urlencode($values);
          
          if(isset($this->params["attributes"]) &&
             $this->params["attributes"] != "")
          {     
            $this->params["attributes"] .= urlencode(";".$filter);     
          }
          else
          {
            $this->params["attributes"] = urlencode($filter);
          }          
        }
      }        
      
      return($this);   
    }    
    
    /**
    * Set the attributes boolean operator to OR. If you have multiple attribute/value filters defined for this
    * search query, then the Search endpoint will OR all of them.
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function setAttributesBooleanOperatorToOr()
    {
      $this->params["attributes_boolean_operator"] = "or";
      
      return($this);
    }
    
    /**
    * Set the attributes boolean operator to AND. If you have multiple attribute/value filters defined for this
    * search query, then the Search endpoint will AND all of them.
    * 
    * This is the default behavior of this service.
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function setAttributesBooleanOperatorToAnd()
    {
      $this->params["attributes_boolean_operator"] = "and";
      
      return($this);
    }
              
    /**
    * Set a list of attribute URIs to include in the resultset returned by the search endpoint.
    * All the attributes used to defined the returned resultset that are not listed in this 
    * array will be ignored, and won't be returned by the endpoint. This is normally
    * used when you know the properties you need for your application, and that you want
    * to limit the bandwidth and minimize the size of the resultset.
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @param mixed $attributes An array of attribute URIs to see in the resultset
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function includeAttributes($attributes)
    {
      // Encode potential ";" characters
      foreach($attributes as $key => $attribute)
      {
        $attributes[$key] = str_replace(";", "%3B", $attribute);
      }
      
      $this->params["include_attributes_list"] = urlencode(implode(";", $attributes));   
      
      return($this);   
    }
                 
    /**
    * Set an attribute URI to include in the resultset returned by the search endpoint.
    * All the attributes used to defined the returned resultset that are not listed in this 
    * array will be ignored, and won't be returned by the endpoint. This is normally
    * used when you know the properties you need for your application, and that you want
    * to limit the bandwidth and minimize the size of the resultset.
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @param mixed $attribute An attribute URI to see in the resultset
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function includeAttribute($attribute)
    {
      // Encode potential ";" characters
      $attribute = str_replace(";", "%3B", $attribute);
      
      if(isset($this->params["include_attributes_list"]) &&
         $this->params["include_attributes_list"] != "")
      {
        $this->params["include_attributes_list"] .= urlencode(";".$attribute);          
      }
      else
      {
        $this->params["include_attributes_list"] = urlencode($attribute);          
      }      
      
      return($this);   
    }    
    
    /**
    * Specify that no attributes should be returned by the query. The only two attributes
    * that will be returned by the search endpoint are the URI and the Type of each
    * result.
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function includeNoAttributes()
    {
      $this->params["include_attributes_list"] = "none";          
      
      return($this);   
    }      
    
    /**
    * Set the number of items to return in a single resultset 
    * 
    * Default value is 10
    * 
    * @param mixed $items The number of items to return in a single resultset 
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function items($items)
    {
      if($items < 0)
      {
        $items = 0;
      }
      
      $this->params["items"] = $items;
      
      return($this);
    }

    /**
    * Set the offset of the resultset to return. By example, to get the item 90 to 100, this 
    * parameter should be set to 90. 
    * 
    * Default page is 0
    *     
    * @param mixed $page The offset of the resultset to return. By example, to get the item 90 to 100, this parameter should be set to 90. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function page($page)
    {
      if($page < 0)
      {
        $page = 0;
      }
      
      $this->params["page"] = $page;
      
      return($this);
    }
    
    /**
    * Enable the inference for this query
    * 
    * This is the default behavior of this service.
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function enableInference()
    {
      $this->params["inference"] = "on";
      
      return($this);
    }
    
    /**
    * Disable the inference for this query
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function disableInference()
    {
      $this->params["inference"] = "off";
      
      return($this);
    }
    
    /**
    * Set the default search query operator to AND
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function defaultOperatorAND()
    {
      $this->params["default_operator"] = "and";
      
      return($this);
    }
    
    /**
    * Set the default search query operator to OR
    * 
    * @param $constrains Minimal number of words that should be present in the returned records.
    *                    More complex behaviors can be defined, the full syntax is explained 
    *                    in this document: 
    *                    http://lucene.apache.org/solr/4_1_0/solr-core/org/apache/solr/util/doc-files/min-should-match.html
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function defaultOperatorOR($constrains)
    {
      $this->params["default_operator"] = "or::".urlencode($constrains);
      
      return($this);
    }
    
    /**
    * Exclude the aggregate records in the resultset of this query
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function excludeAggregates()
    {
      $this->params["include_aggregates"] = "false";
      
      return($this);
    }
    
    /**
    * Include the aggregate records in the resultset of this query
    * 
    * This is the default behavior of this service.
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function includeAggregates()
    {
      $this->params["include_aggregates"] = "true";
      
      return($this);
    }
    
    /**
    * Specify a set of attributes URI for which we want their aggregated values.
    * This is used to get a list of values, and their counts for a given attribute.
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @param mixed $attributes Array of attributes URI for which we want their aggregates
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function aggregateAttributes($attributes)
    {
      // Encode potential ";" characters
      foreach($attributes as $key => $attribute)
      {
        $attributes[$key] = str_replace(";", "%3B", $attribute);
      }
      
      $this->params["aggregate_attributes"] = urlencode(implode(";", $attributes));        
      
      return($this); 
    }
    
    /**
    * Specify an attribute URI for which we want its aggregated values.
    * This is used to get a list of values, and their counts for a given attribute.
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @param mixed $attribute Attribute URI for which we want its aggregates
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function aggregateAttribute($attribute)
    {
      // Encode potential ";" characters
      if(isset($this->params["aggregate_attributes"]) &&
         $this->params["aggregate_attributes"] != "")
      {
        $this->params["aggregate_attributes"] .= urlencode(";".$attribute);
      }
      else
      {
        $this->params["aggregate_attributes"] = urlencode($attribute);
      }
      
      return($this); 
    }    
    
    /**
    * Determines that the aggregated value returned by the endpoint is a literal. If the 
    * value is a URI (a reference to some record), then the literal value will be the 
    * preferred label of that referred record.
    * 
    * This is the default behavior of this service.
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function setAggregateAttributesObjectTypeToLiteral()
    {
      $this->params["aggregate_attributes_object_type"] = "literal"; 
      
      return($this);        
    }
    
    /**
    * Determines that the aggregated value returned by the endpoint is a URI and a Literal
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function setAggregateAttributesObjectTypeToUriLiteral()
    {
      $this->params["aggregate_attributes_object_type"] = "uriliteral"; 
      
      return($this);        
    }
        
    /**
    * Determines that the aggregated value returned by the endpoint is a URI. If the value 
    * of the attribute(s) is a URI (a reference to some record) then that URI will be 
    * returned as the aggregated value. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function setAggregateAttributeObjectTypeToUri()
    {
      $this->params["aggregate_attributes_object_type"] = "uri";    
      
      return($this);     
    }
    
    public function numberOfAggregateAttributesObject($nb)
    {
      if($nb < -1)
      {
        $nb = -1;
      }
      
      $this->params["aggregate_attributes_object_nb"] = $nb; 
      
      return($this);
    }
    
    /**
    * The distance filter is a series of parameter that are used to filter records 
    * of the dataset according to the distance they are located from a given lat;long point
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @param mixed $lat Latitude of the point of origin
    * @param mixed $long Longitude of the point of origin
    * @param mixed $distance The distance from the point of origin
    * @param mixed $distanceType One of: "km" or "mile"
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function distanceFilter($lat, $long, $distance, $distanceType = "km")
    {
      if($distance <= 0)
      {
        $distance = 1;
      }
      
      if($distanceType != "km" && $distanceType != "miles")
      {
        $distanceType = "km";
      }
      
      $type = "";
      
      switch($distanceType)
      {
        case "km":
          $type = "0";
        break;
        
        case "mile":
          $type = "1";
        break;
      }
      
      $this->params["distance_filter"] = "$lat;$long;$distasnce;$type"; 
      
      return($this);
    }
    
    /**
    * The range filter is a series of parameter that are used to filter records of the 
    * dataset according to a rectangle bounds they are located in given their lat;long 
    * position.
    * 
    * **Optional**: This function could be called before sending the query
    * 
    * @param mixed $topLeftLat Latitude of the top left corner of the bounding box
    * @param mixed $topLeftLong Longitude of the top left corner of the bounding box
    * @param mixed $bottomRightLat Latitude of the bottom right corner of the bounding box
    * @param mixed $bottomRightLong Longitude of the bottom right corner of the bounding box
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function rangeFilter($topLeftLat, $topLeftLong, $bottomRightLat, $bottomRightLong)
    {
      $this->params["range_filter"] = "$topLeftLat;$topLeftLong;$bottomRightLat;$bottomRightLong";
      
      return($this);
    }
    
    /**
    * Add a sort criteria to the Search query
    * 
    * @param mixed $sortProperty Property to sort on. Can be: "type", "uri", "dataset", 
    *                            "score", "preflabel" or any other url-encoded attribute 
    *                            URIs that are defined with a maximum cardinality of 1.
    * @param mixed $sortOrder Order of the sort for that property. Can be "desc" or "asc"
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function sort($sortProperty, $sortOrder)
    {
      if(!isset($this->params["sort"]))
      {
        $this->params["sort"] = "";
      }
      
      if($this->params["sort"] != "")
      {
        $this->params["sort"] .= ";";
      }
      
      $this->params["sort"] .= urlencode($sortProperty." ".strtolower($sortOrder));      
      
      return($this);
    }   
    
    /**
    * Extended filters are used to define more complex search filtered searches. This
    * parameter uses a more complex syntax which enable the grouping of filter criterias
    * and the usage of the AND, OR and NOT boolean operators. The grouping is done with
    * the parenthesis. Each filter is composed of a url-encoded attribute URI to use 
    * as filters, followed by a colomn and the value to filter with. The full lucene
    * syntax can be used to define the value to filter. If all values are required, the
    * "*" (star) operator should be used as the value. If the value of an attribute
    * needs to be considered a URI, then the "[uri]" syntax should be added at the end
    * of the attribute filter like: 
    * "http%3A%2F%2Fpurl.org%2Fontology%2Ffoo%23friend[uri]:http%3A%2F%2Fbar.com%2Fmy-friend-uri".
    * That way, the value of that attribute filter will be handled as a URI. There are
    * a series of core attributes that can be used without specifying their full URI:
    * dataset, type, inferred_type, prefLabel, altLabel, lat, long, description, polygonCoordinates,
    * polylineCoordinates and located in. The extended filters are not a replacement to 
    * the attributes, types and datasets filtering parameters, they are an extension of it.
    * Subsequent filtering criterias can be defined in the extended filtering parameter.
    * The resolution logic by the Search endpoint is: 
    * attributes AND datasets AND types AND extended-filters.
    * An example of such an extended query is:
    * (http%3A%2F%2Fpurl.org%2Fontology%2Firon%23prefLabel:cancer AND NOT (breast OR ovarian)) 
    * AND (http%3A%2F%2Fpurl.org%2Fontology%2Fnhccn%23useGroupSignificant[uri]:
    * (http%3A%2F%2Fpurl.org%2Fontology%2Fdoha%23liver_cancer OR 
    * http%3A%2F%2Fpurl.org%2Fontology%2Fdoha%23cancers_by_histologic_type)) AND 
    * dataset:"file://localhost/data/ontologies/files/doha.owl"
    * 
    * Note: both the URI and the value (all kind of values: literals and URIs) need to be
    *       URL encoded before being sent to the Search endpoint.
    * 
    * @param mixed $filters Extended filters query to use for this Search query.
    * @return SearchQuery
    */
    public function extendedFilters($filters)
    {
      if(!isset($this->params["extended_filters"]))
      {
        $this->params["extended_filters"] = "";
      }
            
      $this->params["extended_filters"] = $filters;
      
      return($this);
    }
    
    /**
    * Include the scores of the results into the resultset. The score will be represented
    * by the wsf:score property.
    */
    public function includeScores()
    {
      $this->params["include_scores"] = TRUE;      
      
      return($this);
    }    
    
    /**
    * Exclude the scores of the results into the resultset.
    */
    public function excludeScores()
    {
      $this->params["include_scores"] = FALSE;      
      
      return($this);
    }    
    
    /**
    * Include the scores of the results into the resultset. The score will be represented
    * by the wsf:score property.
    * 
    * @param $inc TRUE if you want to include Scores, FALSE otherwise
    * 
    */
    public function searchRestriction($property, $boost = 1)
    {
      if(!isset($this->params["search_restrictions"]))
      {
        $this->params["search_restrictions"] = "";
      }

      if(!empty($this->params["search_restrictions"]))
      {
        $this->params["search_restrictions"] .= ';';
      } 
                 
      $this->params["search_restrictions"] .= urlencode($property).'^'.$boost;      
      
      return($this);
    }      
  }
  
 /**
  * Class used to generate a set of extended attribute filters that should be added
  * to a SearchQuery. These extended attributes filters support grouping of 
  * attributes/values filters along with the boolean operators AND, OR and NOT.
  * 
  * Here is an example of how this API should be used to create an extended
  * search filters for the SearchQuery class:
  *      
  * @code
  * 
  *   $search = new SearchQuery($network);
  * $extendedFiltersBuilder = new ExtendedFiltersBuilder();
  * 
  * $results = $search->mime("resultset")
  *                   ->extendedFilters(
  *                       $extendedFiltersBuilder->startGrouping()
  *                                                  ->attributeValueFilter("http://purl.org/ontology/iron#prefLabel", "cancer AND NOT (breast OR ovarian)")
  *                                              ->endGrouping()
  *                                              ->and_()
  *                                              ->startGrouping()
  *                                                  ->attributeValueFilter("http://purl.org/ontology/nhccn#useGroupSignificant", "http://purl.org/ontology/doha#liver_cancer", TRUE)
  *                                                  ->or_()
  *                                                  ->attributeValueFilter("http://purl.org/ontology/nhccn#useGroupSignificant", "cancer")
  *                                              ->endGrouping()
  *                                              ->and_()
  *                                              ->datasetFilter("file://localhost/data/ontologies/files/doha.owl")                                               
  *                                              ->getExtendedFilters())
  *                   ->send()
  *                   ->getResultset();
  * 
  * @endcode 
  * 
  * This code will produce this "extended_filters" parameter value:
  * 
  *  (http%253A%252F%252Fpurl.org%252Fontology%252Firon%2523prefLabel:cancer%2BAND%2BNOT%2B%2528breast%2BOR%2Bovarian%2529) 
  *  AND (http%253A%252F%252Fpurl.org%252Fontology%252Fnhccn%2523useGroupSignificant[uri]:http%255C%253A%252F%252Fpurl.org%252Fontology%252Fdoha%2523liver_cancer 
  *  OR http%253A%252F%252Fpurl.org%252Fontology%252Fnhccn%2523useGroupSignificant:cancer) AND 
  *  dataset:%22file%3A%2F%2Flocalhost%2Fdata%2Fontologies%2Ffiles%2Fdoha.owl%22
  *  
  * @see http://techwiki.openstructs.org/index.php/Search
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class ExtendedFiltersBuilder
  {
    /**
    * Extended filters parameter string to use to feed $search->extendedFilters(...)
    */
    private $extendedFilters = "";
    
    function __construct(){}
    
    /**
    * Return the list of filters generated by the ExtendedFiltersBuilder class
    * used by the structWSF Search endpoint for the "extended_filters" parameter.
    */
    function getExtendedFilters()
    {
      return($this->extendedAttributes);
    }

    /**
    * Add a dataset URI to filter
    *     
    * @param mixed $dataset Dataset URI to add to the extended filters query.
    * @return ExtendedFiltersBuilder
    */
    public function datasetFilter($dataset)
    {
      $this->extendedAttributes .= "dataset:".urlencode('"'.$dataset.'"');
      
      return($this);
    }
    
    /**
    * Add a type URI to filter
    * 
    * @param mixed $type Type URI to add to the extended filters query.
    * @param mixed $enableInference Enable inferencing for this type filter.
    * @return ExtendedFiltersBuilder
    */
    public function typeFilter($type, $enableInference = FALSE)
    {
      if($enableInference === FALSE)
      {
        $this->extendedAttributes .= "type:".urlencode('"'.$type.'"');
      }
      else
      {
        $this->extendedAttributes .= "type:".urlencode('"'.$type.'"')." OR ".
                                     "inferred_type:".urlencode('"'.$type.'"');
      }
      
      return($this);
    }
    
    /**
    * Add an attribute/value filter
    * 
    * @param mixed $attribute Attribute URI to add to the extended filters query.
    * @param mixed $value Value to filter by. By default, all values are used ("*")
    * @param boolean $valueIsUri Specify if the value (or set of values) for this attribute have to be considered
    *                            as URIs (this should be specified to TRUE if the attribute is an object property)
    * @return ExtendedFiltersBuilder
    */
    public function attributeValueFilter($attribute, $value="*", $valueIsUri = FALSE)
    {
      // Check if there are Search endpoint control characters in the query.
      // If there are, then we don't escape the values and we assume
      // they are properly escaped.
      
      str_replace(array(' OR ', ' AND ', ' NOT ', '\\', '+', '-', '&', 
                               '|', '!', '(', ')', '{', '}', '[', ']', '^', 
                               '~', '*', '?', '"', ';', ' '), "", $value, $found);
      
      if($found > 0)
      {
        $this->extendedAttributes .= urlencode(urlencode($attribute)).($valueIsUri === TRUE ? "[uri]" : "").":".
                                     urlencode(urlencode($value));
      }
      else
      {
        $this->extendedAttributes .= urlencode(urlencode($attribute)).($valueIsUri === TRUE ? "[uri]" : "").":".
                                     urlencode(urlencode($this->escape($value)));  
      }
      
      return($this);
    }
    
    /**
    * Add a AND operator to the extended filters query
    */
    public function and_()
    {
      $this->extendedAttributes .= " AND ";
      
      return($this);
    }

    /**
    * Add a OR operator to the extended filters query
    */
    public function or_()
    {
      $this->extendedAttributes .= " OR ";
      
      return($this);
    }

    /**
    * Add a NOT operator to the extended filters query
    */
    public function not_()
    {
      $this->extendedAttributes .= " NOT ";
      
      return($this);
    }

    /**
    * Start grouping a series of filters
    */
    public function startGrouping()
    {
      $this->extendedAttributes .= "(";
      
      return($this);
    }
    
    /**
    * End grouping a series of filters
    */
    public function endGrouping()
    {
      $this->extendedAttributes .= ")";
      
      return($this);
    }
    
    /**
    * Escape reserver values characters by the Search endpoint.
    * 
    * @param mixed $string Value to filter
    */
    private function escape($string)
    {
      $match = array('\\', '+', '-', '&', '|', '!', '(', ')', '{', '}', '[', ']', '^', '~', '*', '?', ':', '"', ';', ' ');
      $replace = array('\\\\', '\\+', '\\-', '\\&', '\\|', '\\!', '\\(', '\\)', '\\{', '\\}', '\\[', '\\]', '\\^', '\\~', '\\*', '\\?', '\\:', '\\"', '\\;', '\\ ');
      $string = str_replace($match, $replace, $string);

      return $string;
    }          
  }      
  
//@}    
?>