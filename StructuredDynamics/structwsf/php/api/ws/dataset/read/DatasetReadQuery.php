<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\dataset\read\DatasetReadQuery.php
      @brief DatasetDeleteQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\dataset\read;
  
  /**
  * Dataset Read Query to a structWSF Dataset Read web service endpoint
  * 
  * The Dataset: Read Web service is used to get information (title, 
  * description, creator, contributor(s), creation date and last modification 
  * date) for a dataset belonging to the WSF (Web Services Framework). 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  use \StructuredDynamics\structwsf\php\api\ws\dataset\read\DatasetReadQuery;
  *  
  *  $dRead = new DatasetReadQuery("http://localhost/ws/");
  *
  *  // Specify the Dataset URI for which we want its description
  *  $dRead->uri("http://localhost/ws/dataset/my-new-dataset-3/");
  *  
  *  $dRead->send();
  *  
  *  if($dRead->isSuccessful())
  *  {
  *    // Get the RDF+N3 serialization of the resultset    
  *    echo $dRead->getResultset()->getResultsetRDFN3();
  *  }
  *  else
  *  {
  *    echo "Dataset read failed: ".$dRead->getStatus()." (".$dRead->getStatusMessage().")\n";
  *    echo $dRead->getStatusMessageDescription();  
  *  }
  * 
  * @endcode
  * 
  * @see http://techwiki.openstructs.org/index.php/Dataset:_Read
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class DatasetReadQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
                                    
      $this->setMethodGet();

      $this->mime("resultset");
      
      $this->setEndpoint("dataset/read/");
      
      // Set default parameters for this query
      $this->uri("all");
      $this->excludeMeta();
      $this->sourceInterface("default");      
    }
    
    /**
    * Set the URI of the dataset to get information about. If the value of the URI
    * is "all", then the description of all the datasets accessible to the requester
    * will be returned.
    * 
    * @param mixed $uri URI of the new dataset to create
    * 
    * @see http://techwiki.openstructs.org/index.php/Dataset:_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function uri($uri)
    {
      $this->params["uri"] = urlencode($uri);
    }  
    
    /**
    * Include possibly existing meta-data about the dataset when the webservice returns
    * the description of the dataset.
    * 
    * @see http://techwiki.openstructs.org/index.php/Dataset:_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function includeMeta()
    {
      $this->params["meta"] = "True";
    }
    
    /**
    * Exclude possibly existing meta-data about the dataset when the webservice returns
    * the description of the dataset.
    * 
    * *This is the default behavior of the service*
    * 
    * @see http://techwiki.openstructs.org/index.php/Dataset:_Read#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function excludeMeta()
    {
      $this->params["meta"] = "False";
    }
    
    /**
    * Source interface to use for this web service query.
    * 
    * @param mixed $interface Name of the interface to use.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function sourceInterface($interface)
    {
      $this->params["interface"] = $interface;
    }      
   }       
 
//@}    
?>