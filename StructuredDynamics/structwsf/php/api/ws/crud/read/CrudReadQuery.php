<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\crud\read\CrudReadQuery.php
  
      CrudReadQuery class description

      @author Frederick Giasson, Structured Dynamics LLC.
   */

  namespace StructuredDynamics\structwsf\php\api\ws\crud\read;

  /**
  * Crud Read Query to a structWSF Crud Read web service endpoint
  * 
  * The CRUD: Read Web service is used to get the description of 
  * a target instance record indexed in a dataset belonging to a WSF 
  * (Web Services Framework). 
  * 
  * @see http://techwiki.openstructs.org/index.php/CRUD:_Read
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class CrudReadQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("crud/read/");
      
      // Set default parameters for this query
      $this->excludeLinksback();
      $this->excludeReification();
    }
    
    /**
    * Set the URI(s) of the records' description needed to be returned by the user
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uris A single URI string, or an array or URI strings that refers to the
    *                    record(s) that have to be returned by the endpoint
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function uri($uris)
    {
      if(!is_array($uris))
      {
        $this->params["uri"] = urlencode($uris);
      }
      else
      {
        $this->params["uri"] = urlencode(implode(";", $uris));
      }
    }  
    
    /**
    * Set the URI(s) of the dataset where the instance record is indexed.
    * 
    * If this parameter is omitted (empty), the web service will query all the datasets of the 
    * system, that can be read by the requester, to try to find a definition for this record URI
    * 
    * **Optional**: This function could be called before sending the query 
    * 
    * @param mixed $uris A single URI string, or an array or URI strings that refers to the
    *                    datasets where the requested record URIs are indexed. If we have set
    *                    an array: array("a", "b", "c") for uri(), then we have to list the
    *                    dataset URIs in the same order, such that we have: array("dataset-a",
    *                    "dataset-b", "dataset-c").
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function dataset($uris)
    {
      if(!is_array($uris))
      {
        $this->params["dataset"] = urlencode($uris);
      }
      else
      {
        $this->params["dataset"] = urlencode(implode(";", $uris));
      }
    } 
    
    /**
    * Specifies that the reference to the other instance records referring to the target 
    * instance record will be added in the resultset.
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function includeLinksback()
    {
      $this->params["include_linksback"] = "True";
    } 
    
    /**
    * Specifies that the reference to the other instance records referring to the target 
    * instance record won't be added in the resultset.
    * 
    * This is the default behavior of this service.
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function excludeLinksback()
    {
      $this->params["include_linksback"] = "False";
    }         
    
    /**
    * Specifies that you want to include the reification information for the returned
    * records. Reified information is meta-information about some attribute/values
    * defined for the records.
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function includeReification()
    {
      $this->params["include_reification"] = "True";
    }     
    
    /**
    * Specifies that you want to exclude the reification information for the returned
    * records. Reified information is meta-information about some attribute/values
    * defined for the records.
    * 
    * This is the default behavior of the service.
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function excludeReification()
    {
      $this->params["include_reification"] = "False";
    }     
    
    /**
    * Set a list of attribute URIs to include in the resultset returned by the endpoint.
    * All the attributes used to defined the returned resultset that are not listed in this 
    * array will be ignored, and won't be returned by the endpoint. This is normally
    * used when you know the properties you need for your application, and that you want
    * to limit the bandwidth and minimize the size of the resultset.
    * 
    * **Optional**: This function could be called before sending the query 
    * 
    * @param mixed $attributes An array of attribute URIs to see in the resultset
    * 
    * @see http://techwiki.openstructs.org/index.php/CRUD:_Read#Web_Service_Endpoint_Information
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
   }       
 
//@}    
?>