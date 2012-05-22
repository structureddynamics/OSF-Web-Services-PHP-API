Introduction
============

The **structWSF PHP API** is a framework available to PHP developers to help them generating queries to any
structWSF web service endpoint. Each structWSF web service endpoint has its own WebServiceQuery class in the
structWSF PHP API. This class is used to generate any query, to send it to be endpoint of a structWSF instance
and to get back a resultset. The resultset can then be manipulated by using the Resultset API. This same API
can be used to transform the resultset in different formats.


Documentation
=============

How to use the API
------------------

This API is used to generate structWSF queries to different web service endpoint. This API framework is composed
of a series of classes that are used to help PHP developers to create structWSF queries in their PHP applications.

The usage of this API is simple. Developers normally have 3 easy steps to do:

+ Instantiate the class of the web service then want to query
+ Define all the parameters/features/behaviors of the web service by invoking different methods of the class
+ Sending the query using the send() method

Here is an example of a query that is generated using the structWSF PHP API and sent to specific
structWSF network instance:

```php
  <?php
  
  //
  // Step #1: Instantiate the class of the web service then want to query
  //
  
  // Create the SearchQuery object
  $search = new SearchQuery("http://localhost/ws/");
  
  //
  // Step #2: Define all the parameters/features/behaviors of the web service by invoking different methods of the class
  //
  
  // Enable inference for this query
  $search->enableInference();
  
  // Exclude the aggregates records for this query
  $search->excludeAggregates();
  
  // Get 20 records in the returned resultset
  $search->items(20);
  
  // Start getting returning the results at the result number 40
  $search->page(40);
  
  // Set the query parameter with the search keyword "elm"
  $search->query("forest");
  
  //
  // Step #3: Sending the query using the send() method
  //
  
  // Send the search query to the endpoint
  $search->send();
  
  // Get back the resultset returned by the endpoint
  $resultset = $search->getResultset();
  
  // Print the PHP array serialization for that resultset
  print_r($resultset->getResultset());    
  
  ?>
```   

Auto-loading of Classes
-----------------------

The structWSF PHP API does comply with the [PSR-0 Standard Document](https://gist.github.com/1234504) 
for auto-loading the classes of the framework. The SplClassLoader class that has been developed by
the same group can be used as the classes auto-loader.

Here is an example of how you can auto-load the classes of the structWSF PHP API framework:

```php
  <?php

  include_once("SplClassLoader.php");
  
  // Load the \ws namespace where all the web service code is located 
  $loader_ws = new SplClassLoader('StructuredDynamics\structwsf\php\api\ws');
  $loader_ws->register();
  
  // Load the \framework namespace where all the supporting (utility) code is located
  $loader_framework = new SplClassLoader('StructuredDynamics\structwsf\php\api\framework');
  $loader_framework->register();
 
  // Use the SearchQuery class
  use StructuredDynamics\structwsf\php\api\ws\search\SearchQuery;
  
  // Create the SearchQuery object
  $search = new SearchQuery("http://localhost/ws/");
  
  // Set the query parameter with the search keyword "elm"
  $search->query("elm");
  
  // Send the search query to the endpoint
  $search->send();
  
  // Get back the resultset returned by the endpoint
  $resultset = $search->getResultset();
  
  // Print different serializations for that resultset
  print_r($resultset->getResultset());
  
  echo $resultset->getResultsetJSON();
  echo $resultset->getResultsetXML();
  echo $resultset->getResultsetRDFXML();
  echo $resultset->getResultsetRDFN3();  
  
  ?>
```

Web Services Usage
==================
Here are some example of how each of the web services can be used.

Search
------
```php
  <?php

  // Use the SearchQuery class
  use StructuredDynamics\structwsf\php\api\ws\search\SearchQuery;
  
  // Create the SearchQuery object
  $search = new SearchQuery("http://demo.citizen-dan.org/ws/");
  
  // Set the query parameter with the search keyword "elm"
  $search->query("school");
  
  // Send the search query to the endpoint
  $search->send();
  
  // Get back the resultset returned by the endpoint
  $resultset = $search->getResultset();
  
  // Print different serializations for that resultset
  print_r($resultset->getResultset());
 
  ?>
```

Crud: Read
----------
```php
  <?php

  // Use the CrudReadQuery class
  use StructuredDynamics\structwsf\php\api\ws\crud\read\CrudReadQuery;
  
  // Create the CrudReadQuery object
  $cread = new CrudReadQuery("http://demo.citizen-dan.org/ws/");
  
  // Get the description of the Nursery_schools record
  $cread->uri("http://purl.org/ontology/muni#Nursery_schools");
  
  // Exclude possible linksback
  $cread->excludeLinksback();
  
  // Exclude possible reification statements
  $cread->excludeReification();
  
  // Send the crud read query to the endpoint
  $cread->send();
  
  print_r($cread);
  
  // Get back the resultset returned by the endpoint
  $resultset = $cread->getResultset();
  
  // Print different serializations for that resultset
  print_r($resultset->getResultset());
 
  ?>
```

Crud: Create
------------

```php
  <?php
  
  // Use the CrudCreateQuery class
  use \StructuredDynamics\structwsf\php\api\ws\crud\create\CrudCreateQuery;
  
  // Create the CrudCreateQuery object
  $crudCreate = new CrudCreateQuery("http://localhost/ws/");
  
  // Specifies where we want to add the RDF content
  $crudCreate->dataset("http://localhost/ws/dataset/my-new-dataset/");
  
  // Specifies the RDF content we want to add to this dataset
  $crudCreate->document('<?xml version="1.0"?>
                         <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                           xmlns:dc="http://purl.org/dc/elements/1.1/">
                           <rdf:Description rdf:about="http://www.w3.org/">
                             <dc:title>World Wide Web Consortium</dc:title> 
                           </rdf:Description>
                         </rdf:RDF>');

  // Specifies that the input document is serialized using RDF+XML
  $crudCreate->documentMimeIsRdfXml();  
  
  // Make sure we index that new RDF data everywhere in the structWSF instance
  $crudCreate->enableFullIndexationMode();
  
  // Import that new RDF data
  try
  {
    $crudCreate->send();
  }
  catch(Exception $e){}

  use StructuredDynamics\structwsf\php\api\ws\search\SearchQuery;
  
  if($crudCreate->isSuccessful())
  {
    // Now that it got imported, let's try to search for that new record using the Search endpoint.
    
    // Create the SearchQuery object
    $search = new SearchQuery("http://localhost/ws/");
    
    // Set the query parameter with the search keyword "elm"
    $search->query("Consortium");
    
    $search->excludeAggregates();
    
    // Send the search query to the endpoint
    $search->send();
    
    // Get back the resultset returned by the endpoint
    $resultset = $search->getResultset();
    
    // Print different serializations for that resultset
    print_r($resultset->getResultset());      
  }
  else
  {    
    echo "Importation failed: ".$crudCreate->getStatus()." (".$crudCreate->getStatusMessage().")\n";
    echo $crudCreate->getStatusMessageDescription();
  }
  ?>
```  

CRUD: Delete
---------------
```php
  <?php
  
  // Use the CrudDeleteQuery class
  use \StructuredDynamics\structwsf\php\api\ws\crud\delete\CrudDeleteQuery;
  
  // Create the CrudDeleteQuery object
  $crudDelete = new CrudDeleteQuery("http://localhost/ws/");
  
  // Specifies where the record we want to delete is indexed
  $crudDelete->dataset("http://localhost/ws/dataset/my-new-dataset/");
  
  // Specifies the URI of the record we want to delete from the system
  $crudDelete->uri("http://www.w3.org/");
  
  // Import that new RDF data
  try
  {
    $crudDelete->send();
  }
  catch(Exception $e){}

  if($crudDelete->isSuccessful())
  {
    echo "Record deleted";
  }
  else
  {    
    echo "Deletation failed: ".$crudDelete->getStatus()." (".$crudDelete->getStatusMessage().")\n";
    echo $crudDelete->getStatusMessageDescription();
  }  
  
  ?>
```  


CRUD: Update
---------------
```php
  <?php
  
  // Use the CrudCreateQuery class
  use \StructuredDynamics\structwsf\php\api\ws\crud\create\CrudCreateQuery;
  
  // Use the CrudUpdateQuery class
  use \StructuredDynamics\structwsf\php\api\ws\crud\update\CrudUpdateQuery;

  // Use the SearchQuery class  
  use StructuredDynamics\structwsf\php\api\ws\search\SearchQuery;
  
  
  // First, let's create our object that we will then modify.
  
  // Create the CrudCreateQuery object
  $crudCreate = new CrudCreateQuery("http://localhost/ws/");
  
  // Specifies where we want to add the RDF content
  $crudCreate->dataset("http://localhost/ws/dataset/my-new-dataset/");
  
  // Specifies the RDF content we want to add to this dataset
  $crudCreate->document('<?xml version="1.0"?>
                         <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                           xmlns:dc="http://purl.org/dc/elements/1.1/">
                           <rdf:Description rdf:about="http://www.w3.org/">
                             <dc:title>World Wide Web Consortium</dc:title> 
                           </rdf:Description>
                         </rdf:RDF>');

  // Specifies that the input document is serialized using RDF+XML
  $crudCreate->documentMimeIsRdfXml();  
  
  // Make sure we index that new RDF data everywhere in the structWSF instance
  $crudCreate->enableFullIndexationMode();
  
  // Import that new RDF data
  try
  {
    $crudCreate->send();
  }
  catch(Exception $e){}

  if($crudCreate->isSuccessful())
  {
    // Now that it got created, let's try to modify it.
    
    // Create the CrudUpdateQuery object
    $crudUpdate = new CrudUpdateQuery("http://localhost/ws/");
    
    // Specifies where we want to add the RDF content
    $crudUpdate->dataset("http://localhost/ws/dataset/my-new-dataset/");
    
    // Specifies the RDF content we want to add to this dataset
    $crudUpdate->document('<?xml version="1.0"?>
                           <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                             xmlns:dc="http://purl.org/dc/elements/1.1/">
                             <rdf:Description rdf:about="http://www.w3.org/">
                               <dc:title>CRUD: Update testing (was: World Wide Web Consortium)</dc:title> 
                             </rdf:Description>
                           </rdf:RDF>');

    // Specifies that the input document is serialized using RDF+XML
    $crudUpdate->documentMimeIsRdfXml();  
    
    // Import that new RDF data
    try
    {
      $crudUpdate->send();
    }
    catch(Exception $e){}

    if($crudUpdate->isSuccessful())
    {    
      // If the document has been properly updated, let's try to search for it.
      
      // Create the SearchQuery object
      $search = new SearchQuery("http://localhost/ws/");
      
      // Set the query parameter with the search keyword "elm"
      $search->query("Update testing");
      
      $search->excludeAggregates();
      
      // Send the search query to the endpoint
      $search->send();
      
      // Get back the resultset returned by the endpoint
      $resultset = $search->getResultset();
      
      // Print different serializations for that resultset
      print_r($resultset->getResultset());      
    }
    else
    {
      echo "Update failed: ".$crudUpdate->getStatus()." (".$crudUpdate->getStatusMessage().")\n";
      echo $crudUpdate->getStatusMessageDescription();      
    }
  }
  else
  {    
    echo "Creation failed: ".$crudCreate->getStatus()." (".$crudCreate->getStatusMessage().")\n";
    echo $crudCreate->getStatusMessageDescription();
  }  
  
  ?>
```  

Auth: Lister
------------
```php
  <?php
  
  // Use the AuthListerQuery class
  use \StructuredDynamics\structwsf\php\api\ws\auth\lister\AuthListerQuery;
  
  // Create the AuthListerQuery object
  $authlister = new AuthListerQuery("http://demo.citizen-dan.org/ws/");
  
  // Specifies that we want to get all the dataset URIs available to the server that send this query.
  $authlister->getDatasetsUri();
  
  // Send the auth lister query to the endpoint
  $authlister->send();
  
  // Get back the resultset returned by the endpoint
  $resultset = $authlister->getResultset();
  
  // Print different serializations for that resultset
  print_r($resultset->getResultset());
    
  ?>
```
  
Dataset: Create
---------------
```php
  <?php

  // Use the DatasetCreateQuery class
  use \StructuredDynamics\structwsf\php\api\ws\dataset\create\DatasetCreateQuery;
  
  // Create the DatasetCreateQuery object
  $dcreate = new DatasetCreateQuery("http://localhost/ws/");
  
  // Set the URI of the new dataset
  $dcreate->uri("http://localhost/ws/dataset/my-new-dataset/");
  
  // Set the title of the dataset
  $dcreate->title("My Brand New Dataset");
  
  // Set the description of the dataset
  $dcreate->description("This is something to look at!");
  
  // Set the creator's URI
  $dcreate->creator("http://localhost/people/bob/");
  
  
  // Get all the web services registered on this instance with a 
  use \StructuredDynamics\structwsf\php\api\ws\auth\lister\AuthListerQuery;
  use \StructuredDynamics\structwsf\framework\Namespaces;
  
  // Create the AuthListerQuery object
  $authlister = new AuthListerQuery("http://localhost/ws/");
  
  // Specifies that we want to get all the list of all registered web service endpoints.
  $authlister->getRegisteredWebServiceEndpointsUri();
  
  // Send the auth lister query to the endpoint
  $authlister->send();
  
  // Get back the resultset returned by the endpoint
  $resultset = $authlister->getResultset()->getResultset();
  
  $webservices = array();
  
  // Get all the URIs from the resultset array
  foreach($resultset["unspecified"] as $list)
  {
    foreach($list[Namespaces::$rdf."li"] as $item)
    {
      array_push($webservices, $item["uri"]);
    }
  }
  
  unset($authlister);
  
  // We make sure that this dataset will be accessible by all the 
  // registered web service endpoints of the network.
  $dcreate->targetWebservices($webservices);
  
  use \StructuredDynamics\structwsf\php\api\framework\CRUDPermission;
  
  // We make this new dataset world readable
  $dcreate->globalPermissions(new CRUDPermission(FALSE, TRUE, FALSE, FALSE));
  
  // Send the crud read query to the endpoint
  $dcreate->send();
  
  // Now we make sure we create the new dataset by looking into the system
  // using the Auth Lister again
  
  // Create the AuthListerQuery object
  $authlister = new AuthListerQuery("http://localhost/ws/");
  
  // Specifies that we want to get all the list of all registered web service endpoints.
  $authlister->getDatasetUsersAccesses("http://localhost/ws/dataset/my-new-dataset/");
  
  // Send the auth lister query to the endpoint
  $authlister->send();
  
  // Get back the resultset returned by the endpoint
  $resultset = $authlister->getResultset();
  
  print_r($resultset);
 
  ?>
```