<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\framework\ServerIDQuery.php  
      @brief CrudCreateQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\framework;

  class ServerIDQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      $this->setSupportedMimes(array("text/plain"));
                                    
      $this->setMethodGet();

      $this->mime("text/plain");
      
      $this->setEndpoint("");
      
      // Set default parameters for this query
      $this->sourceInterface("default");      
    } 
  }
?>