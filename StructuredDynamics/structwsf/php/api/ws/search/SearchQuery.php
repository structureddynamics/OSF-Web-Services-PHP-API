<?php
               
  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\search\SearchQuery.php
      SearchQuery class description

      @author Frederick Giasson, Structured Dynamics LLC.
   */               
               
  namespace StructuredDynamics\structwsf\php\api\ws\search;
  
  /**
  * Ontology Read Query to a structWSF SPARQL web service endpoint
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
    }
  
    /**
    * Set the keywords to use for this search query.
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @param mixed $query Keywords to use to search for this query. Keywords can use some boolean operations. An empty string returns everything.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function query($query)
    {
      $this->params["query"] = $query;
    }
    
    /**
    * Set all the type filters to use for this search query
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
      
      $this->params["types"] = implode(";", $types);
    }
    
    /**
    * Set all the dataset filters to use for this search query
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @param mixed $datasets An array of datasets URI to use to filter the returned results.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function datasetsFilters($datasets)
    {
      if(!is_array($datasets))
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
      
      $this->params["datasets"] = implode(";", $datasets);
    }
    
    /**
    * Set all the attribute/value filters to use for this search query
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
              $filter = urlencode($attribute)."::".urlencode($value);
              
              str_replace(";", "%3B", $filter);
              
              array_push($attrs, $filter);
            }
          }
        }
      }
      
      $this->params["attributes"] = implode(";", $attrs);
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
    }
    
    /**
    * Set the attributes boolean operator to AND. If you have multiple attribute/value filters defined for this
    * search query, then the Search endpoint will AND all of them.
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function setAttributesBooleanOperatorToAnd()
    {
      $this->params["attributes_boolean_operator"] = "and";
    }
              
    /**
    * Set a list of attribute URIs to include in the resultset returned by the search endpoint.
    * All the attributes used to defined the returned resultset that are not listed in this 
    * array will be ignored, and won't be returned by the endpoint. This is normally
    * used when you know the properties you need for your application, and that you want
    * to limit the bandwidth and minimize the size of the resultset.
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
      
      $this->params["include_attributes_list"] = implode(";", $attributes);      
    }
    
    /**
    * Set the number of items to return in a single resultset 
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
    }

    /**
    * Set the offset of the resultset to return. By example, to get the item 90 to 100, this 
    * parameter should be set to 90. 
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
    }
    
    /**
    * Enable the inference for this query
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function enableInference()
    {
      $this->params["inference"] = "on";
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
    }
    
    /**
    * Include the aggregate records in the resultset of this query
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function includeAggregates()
    {
      $this->params["include_aggregates"] = "true";
    }
    
    /**
    * Specify a set of attributes URI for which we want their aggregated values.
    * This is used to get a list of values, and their counts for a given attribute.
    * 
    * @param mixed $attributes Array of attributes URI for which we want their aggregates
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function aggregateAttributes($attributes)
    {
      foreach($attributes as $key => $attribute)
      {
        $attributes[$key] = urlencode($attribute);
      }
      
      $this->params["aggregate_attributes"] = implode(";", $attributes);         
    }
    
    /**
    * Determines that the aggregated value returned by the endpoint is a literal. If the 
    * value is a URI (a reference to some record), then the literal value will be the 
    * preferred label of that referred record.
    * 
    * @see http://techwiki.openstructs.org/index.php/Search#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function setAggregateAttributesObjectTypeToLiteral()
    {
      $this->params["aggregate_attributes_object_type"] = "literal";         
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
    }
    
    public function numberOfAggregateAttributesObject($nb)
    {
      if($nb < -1)
      {
        $nb = -1;
      }
      
      $this->params["aggregate_attributes_object_nb"] = $nb; 
    }
    
    /**
    * The distance filter is a series of parameter that are used to filter records 
    * of the dataset according to the distance they are located from a given lat;long point
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
    }
    
    /**
    * The range filter is a series of parameter that are used to filter records of the 
    * dataset according to a rectangle bounds they are located in given their lat;long 
    * position.
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
    }    
  }
  
//@}    
?>