<?php

  /*! @ingroup OSFPHPAPIWebServices OSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\osf\php\api\ws\scones\SconesQuery.php
      @brief SconesQuery class description
   */

  namespace StructuredDynamics\osf\php\api\ws\scones;

  /**
  * Scones to a OSF Scones web service endpoint
  * 
  * The Scones web service system (subject concepts or named entities) is used 
  * to perform subject concepts and named entities tagging on a target document.
  * 
  * This Scones application is meant to be use in conjunction with the Scones 
  * OSF (Open Semantic Framework) web service endpoint.
  * 
  * This Web service is intended to be used by users that wants to tag subjects 
  * concepts and named entities using the content of a target OSF instance.
  * Since the scones instance is re-using the ontologies & named entities defined on 
  * a specific OSF instance, tagging will be performed using this specific 
  * information. So, if a specific OSF instance is hosted, maintained and 
  * defined by an a Health related organization, than their scones web service 
  * should be better at tagging Health related documents.
  * 
  * So, not all scones instance are equal, and some are expected to be better at 
  * tagging specific articles than other, depending on the domain defined on a 
  * specific node. 
  * 
  * Here is a code example of how this class can be used by developers: 
  * 
  * @code
  * 
  *  use \StructuredDynamics\osf\php\api\ws\scones\SconesQuery;
  *  
  *  $scones = new SconesQuery("http://localhost/ws/");
  *  
  *  // Specify the document (in this case, a web page) you want to tag using that Scones instance.
  *  $scones->document("http://fgiasson.com");
  *  
  *  // Tag the document
  *  $scones->send();
  *
  *  if($scones->isSuccessful())
  *  {
  *    // Output the Gate tagged document.
  *    echo $scones->getResultset();
  *  }
  *  else
  *  {
  *    echo "Scones tagging failed: ".$scones->getStatus()." (".$scones->getStatusMessage().")\n";
  *    echo $scones->getStatusMessageDescription();       
  *  }
  *
  *  
  * @endcode
  * 
  * @see http://wiki.opensemanticframework.org/index.php/Scones
  * @see https://github.com/structureddynamics/Scones
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class SconesQuery extends \StructuredDynamics\osf\php\api\framework\WebServiceQuery
  {
    /**
    * Constructor
    * 
    * @param mixed $network OSF network where to send this query. Ex: http://localhost/ws/
    * @param mixed $appID The Application ID of the instance instance to key. The APP-ID is related to the API-KEY
    * @param mixed $apiKey The API Key of the OSF web service endpoints
    * @param mixed $userID The ID of the user that is doing the query
    */
    function __construct($network, $appID, $apiKey, $userID)
    {
      // Set the OSF network & credentials to use for this query.
      $this->setNetwork($network);
      $this->appID = $appID;
      $this->apiKey = $apiKey;
      $this->userID = $userID;
      
      // Set default configarations for this web service query
      $this->setSupportedMimes(array("text/xml", 
                                     "application/json", 
                                     "application/rdf+xml",
                                     "application/rdf+n3",
                                     "application/iron+json",
                                     "application/iron+csv"));
                                    
      $this->setMethodPost();

      $this->mime("application/json");
      
      $this->setEndpoint("scones/");
      
      $this->plainConceptTagger();
      $this->noStemming();
      $this->sourceInterface("default");
    }
    
    /**
    * Document content to process; or URL of a document accessible on the web to extract/process
    * 
    * The document types accessible at that URL can be either: 
    * 
    *  + a plain text document
    *  + a HTML document
    *  + a PDF document
    *  + a MS Word document
    *  + a Email document
    *  + a RTF document
    *  + a SGML document
    *  + a XML document  
    * 
    * @param mixed $document Full text document, or URL where the document can be accessed of the
    *                        document to tag using Scones.
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Scones#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function document($document)
    {
      $this->params["document"] = urlencode($document);
      
      return($this);
    }  
    
    /**
    * Specifies the type of Scones tagger to be the "plain"
    * 
    * @param mixed $type Type of the Scones tagger. Can be "plain" or "noun"
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Scones#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function plainConceptTagger()
    {
      $this->params["type"] = "plain";
      
      return($this);
    }   
    
    /**
    * Specifies that we want to use stemming when performing the tagging operation.
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Scones#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function withStemming()
    {
      $this->params["stemming"] = "true";
      
      return($this);
    }   
    
    /**
    * Specifies that we don't want to use stemming when performing the tagging operation.
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Scones#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function noStemming()
    {
      $this->params["stemming"] = "false";
      
      return($this);
    }   
    
    /**
    * Specifies the type of Scones tagger to be the "noun"
    * 
    * @param mixed $type Type of the Scones tagger. Can be "plain" or "noun"
    * 
    * @see http://wiki.opensemanticframework.org/index.php/Scones#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function nounConceptTagger()
    {
      $this->params["type"] = "noun";
      
      return($this);
    }      
   }       
 
//@}    
?>