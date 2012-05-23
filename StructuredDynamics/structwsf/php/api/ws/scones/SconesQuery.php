<?php

  /*! @ingroup StructWSFPHPAPIWebServices structWSF PHP API Web Services */
  //@{

  /*! @file \StructuredDynamics\structwsf\php\api\ws\scones\SconesQuery.php
      @brief SconesQuery class description
   */

  namespace StructuredDynamics\structwsf\php\api\ws\scones;

  /**
  * Scones to a structWSF Scones web service endpoint
  * 
  * The scones web service system (subject concepts or named entities) is used 
  * to perform subject concepts and named entities tagging on a target document. 
  * The GATE system is used to perform the tagging. A GATE XML annotation file 
  * is returned to the user. 
  * 
  * This Web service is intended to be used by users that wants to tag subjects 
  * concepts and named entities using the content of a target structWSF instance.
  * Since the scones instance is re-using the ontologies & named entities defined on 
  * a specific structWSF instance, tagging will be performed using this specific 
  * information. So, if a specific structWSF instance is hosted, maintained and 
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
  *  use \StructuredDynamics\structwsf\php\api\ws\scones\SconesQuery;
  *  
  *  $scones = new SconesQuery("http://localhost/ws/");
  *  
  *  // Specify the document (in this case, a web page) you want to tag using that Scones instance.
  *  $scones->document("http://fgiasson.com");
  *  
  *  try
  *  {
  *    // Tag the document
  *    $scones->send();
  *  }
  *  catch(Exception $e){}
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
  * @see http://techwiki.openstructs.org/index.php/Scones
  * @see https://github.com/structureddynamics/Scones
  * 
  * @author Frederick Giasson, Structured Dynamics LLC.  
  */
  class SconesQuery extends \StructuredDynamics\structwsf\php\api\framework\WebServiceQuery
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
      
      $this->setEndpoint("scones/");
      
      // Set default parameters for this query
      $this->params["docmime"] = "text/plain";
      
      $this->application("defaultApplication");

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
    * @see http://techwiki.openstructs.org/index.php/Scones#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function document($document)
    {
      $this->params["document"] = urlencode($document);
    }  
    
    /**
    * Specifies the application to use to tag the content of the input document. If other 
    * applications are available, these should be listed somewhere on the website of the 
    * agent that host the service. 
    * 
    * @param mixed $application Application to use to tag the content of the input document. 
    *                           If other applications are available, these should be listed 
    *                           somewhere on the website of the agent that host the service. 
    * 
    * @see http://techwiki.openstructs.org/index.php/Scones#Web_Service_Endpoint_Information
    * 
    * @author Frederick Giasson, Structured Dynamics LLC.* 
    */
    public function application($application)
    {
      $this->params["application"] = urlEncode($application);
    } 
   }       
 
//@}    
?>