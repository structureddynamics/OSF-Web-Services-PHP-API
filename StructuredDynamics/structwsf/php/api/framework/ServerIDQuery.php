<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\framework\ServerIDQuery.php  
      @brief CrudCreateQuery class description
   */

  namespace StructuredDynamics\osf\php\api\framework;

  class ServerIDQuery extends \StructuredDynamics\osf\php\api\framework\WebServiceQuery
  {
    /**
    * Constructor
    * 
    * @param mixed $network OSF network where to send this query. Ex: http://localhost/ws/
    */
    function __construct($network)
    {
      // Set the OSF network to use for this query.
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