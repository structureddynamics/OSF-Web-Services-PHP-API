<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\dataset\create\DatasetCreateQuery.php
  
      DatasetCreateQuery class description

      @author Frederick Giasson, Structured Dynamics LLC.
   */

  namespace StructuredDynamics\structwsf\php\api\ws\dataset\create;

  use \StructuredDynamics\structwsf\php\api\framework\CRUDPermission;
  
  /**
  * Dataset Create Query to a structWSF Dataset Create web service endpoint
  * 
  * The Dataset: Create Web service is used to create a new dataset in a WSF 
  * (Web Services Framework). When a dataset is created, it gets described and 
  * registered to the WSF and accessible to the other Web services. 
  * 
  * @see http://techwiki.openstructs.org/index.php/Dataset:_Create
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class DatasetCreateQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("dataset/create/");
      
      // Set default parameters for this query
      $this->globalPermissions(new CRUDPermission(FALSE, FALSE, FALSE, FALSE));
    }
    
    /**
    * Set the URI of the new dataset to create
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param mixed $uri URI of the new dataset to create
    * 
    * @see http://techwiki.openstructs.org/index.php/Dataset:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function uri($uri)
    {
      $this->params["uri"] = urlencode($uri);
    }  
    
    /**
    * Set the title of the dataset to create
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param $title title of the dataset to create
    * 
    * @see http://techwiki.openstructs.org/index.php/Dataset:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function title($title)
    {
      $this->params["title"] = urlencode($title);
    }
    
    /**
    * Set the description of the dataset to create
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * @param $description description of the dataset to create
    * 
    * @see http://techwiki.openstructs.org/index.php/Dataset:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function description($description)
    {
      $this->params["description"] = urlencode($description);
    }    
    
    /**
    * Set the reference to the creator of this new dataset
    * 
    * **Optional**: This function could be called before sending the query 
    * 
    * @param mixed $creatorUri URI of the creator of this new dataset
    * 
    * @see http://techwiki.openstructs.org/index.php/Dataset:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function creator($creatorUri)
    {
      $this->params["creator"] = urlencode($creatorUri);
    }
    
    /**
    * Specifies which web service endpoint can have access to the data contained in this new dataset.
    * 
    * **Required**: This function must be called before sending the query 
    * 
    * Note: you can get the complete list of webservice endpoint URIs registered to a structWSF network
    *       instance by using the AuthListerQuery class and by using the getWebServicesList() function.
    * 
    * @param $webservicesUri An array of webservice URIs that have access to the content of this dataset.
    * 
    * @see http://techwiki.openstructs.org/index.php/Dataset:_Create#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function targetWebservices($webservicesUri)
    {
      $this->params["description"] = urlencode(implode(";", $webservicesUri));
    }   
    
    /**
    * Set the global permissions for this new dataset
    * 
    * The default value for this call is no global permissions enabled for anybody
    * 
    * @param mixed $crudPermission A CRUDPermission object instance that define the global CRUD permissions 
    *                              to use for this new dataset.
    */
    public function globalPermissions($crudPermission)
    {
      $this->params["globalPermissions"] = urlencode(($crudPermission->getCreate() ? "True" : "False").";".
                                                     ($crudPermission->getRead() ? "True" : "False").";".
                                                     ($crudPermission->getUpdate() ? "True" : "False").";".
                                                     ($crudPermission->getDelete() ? "True" : "False"));
    }     
   }       
   
   
 
//@}    
?>