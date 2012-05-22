<?php

  /*! @ingroup StructWSFPHPAPIFramework Framework of the structWSF PHP API library */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery.php
     Defines the WebServiceQuery class
   
     @author Frederick Giasson, Structured Dynamics LLC.
  */

  namespace StructuredDynamics\structwsf\php\api\framework;

  use \Exception;  
  
  /**
  * Class that defined all the methods and variables needed to send a structWSF query
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.
  */
  class WebServiceQuery
  {
    /** URL ending of the endpoing in the network (ex: /search/, /crud/read/, ...) */
    private $endpoint = "";

    /** HTTP method to use for sending the query (get or post) */
    private $method = "get";

    /** The mime type to use for this HTTP query */
    private $mime = "resultset";

    /** Timeout of the query in milliseconds */
    private $timeout = 0;

    /** Resultset returned by the remote endpoint */
    private $resultset;

    /** Base URL of the network (ex: http://localhost/ws/) */
    private $network = "http://localhost/ws/";
    
    /** Supported mime types by the endpoint */
    private $supportedMimes = array("resultset",
                                    "text/xml", 
                                    "application/json", 
                                    "application/rdf+xml",
                                    "application/rdf+n3",
                                    "application/iron+json",
                                    "application/iron+csv");

    /** HTTP status number of the query */
    private $httpStatus = "200";
    
    /** HTTP status message of the query */
    private $httpStatusMessage = "";
    
    /** HTTP status message description of the query */
    private $httpStatusMessageDescription = "";
                                    
    /** Parameters to use to send the query to the endpoint */
    protected $params = array();  
    
    function __construct(){}
    
    /**
    * Set the endpoint's URL ending.
    * Example: /search/, /crud/read/, etc.
    * 
    * @param mixed $endpoint
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    protected function setEndpoint($endpoint)
    {
      $this->endpoint = ltrim(rtrim($endpoint, "/"))."/";
    }
    
    /**
    * Set the HTTP method to GET for this query
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    protected function setMethodGet()
    {
      $this->method = "get";
    }
    
    /**
    * Set the HTTP method to POST for this query
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    protected function setMethodPost()
    {
      $this->method = "post";
    }

    /**
    * Get the resultset object of this query
    * 
    * @return Returns a Resultset object
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getResultset()
    {
      return($this->resultset);
    }
    
    /**
    * Send the HTTP query to the endpoint. This function should be called
    * once all the settings/parameters of the query have been previously
    * configured.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC. 
    */
    public function send()
    {
      $parameters = "";
      
      foreach($this->params as $param => $value)
      {
        $parameters .= $param."=".$value."&";  
      }
      
      $parameters = trim($parameters, "&");
      
      $wsq = new WebServiceQuerier(rtrim($this->network, "/")."/".$this->endpoint, 
                                   $this->method, 
                                   ($this->mime == "resultset" ? "text/xml" : $this->mime), 
                                   $parameters, 
                                   $this->timeout);
                                   
      $this->httpStatus = $wsq->getStatus();
      $this->httpStatusMessage = $wsq->getStatusMessage();
      $this->httpStatusMessageDescription = $wsq->getStatusMessageDescription();                                   
                                   
      if($wsq->getStatus() == 200)
      {
        if($this->mime != "resultset")
        {
          $this->resultset = $wsq->getResultset(); 
        }
        else
        {
          $data = $wsq->getResultset();
          
          if($data != "")
          {
            $resultset = new Resultset();        
            
            $resultset->importStructXMLResultset($data);
          
            $this->resultset = $resultset;
          }
        }         
      }      
      else
      {
        // Error
        if(isset($wsq->error))
        {
          throw new Exception('['.$wsq->error->level.']('.$wsq->error->id.')  '.$wsq->error->name.'. '.$wsq->error->description.'. '.$wsq->error->debugInfo);
        }
      }
      
      unset($wsq);
    }
    
    /**
    * Set all the supported mime types by the structWSF web service endpoint
    * 
    * @param mixed $mimes An array of mime types supported by the endpoint
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    protected function setSupportedMimes($mimes)
    {           
      // Make sure the internal namespace is there
      if(array_search("resultset", $mimes) === FALSE)
      {
        array_push($mimes, "resultset");
      }
            
      $this->supportedMimes = $mimes;
    }
    
    /**
    * Set the base structWSF network URL. This value is appended in from of the "endpoint URL"
    * to create the full endpoint's URL
    * Example: http://localhost/ws/
    * 
    * @param mixed $network Base structWSF network URL
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    protected function setNetwork($network)
    {
      $this->network = $network;
    }
    
    /**
    * Set the mime to use for this HTTP query
    * 
    * @param mixed $mime Mime to use for this HTTP query
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function mime($mime)
    {
      // Make sure the mime to set is supported. If it is not, we keep the default one.
      if(array_search($mime, $this->supportedMimes) !== FALSE)
      {
        $this->mime = $mime;
      }
    }
    
    /**
    * Set the timeout to use for this HTTP query
    * 
    * @param mixed $milliseconds Number of milliseconds before the HTTP query aboard. If the value 
    *                            is -1, then no timeout are defined for this HTTP query.
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function timeout($milliseconds)
    {
      if($milliseconds > 0)
      {
        $this->timeout = $milliseconds;
      }
    }  
    
    /**
    * Set the register_ip parameter for this query.
    * 
    * @param mixed $ip Registered IP address
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function registeredIp($ip)
    {
      $this->params["registered_ip"] = $ip; 
    } 
    
    /**
    * Check if the query that has been sent is successful or not
    * 
    * @return TRUE if the query has been successful; FALSE otherwise
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function isSuccessful()   
    {
      if($this->httpStatus == "200")
      {
        return(TRUE);
      }
      else
      {
        return(FALSE);
      }
    }
    
    /**
    * Get the HTTP status number of the query
    * 
    * @return Return a HTTP status code
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getStatus()
    {
      return($this->httpStatus);
    }
    
    /**
    * Get the HTTP status message of the query
    * 
    * @return Return a HTTP status message
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getStatusMessage()
    {
      return($this->httpStatusMessage);
    }
    
    /**
    * Get the HTTP status message description of the query
    * 
    * @return Return a HTTP status message description
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.
    */
    public function getStatusMessageDescription()
    {
      return($this->httpStatusMessageDescription);
    }
  }
  
?>