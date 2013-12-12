Introduction
============

The **OSF Web Services PHP API** is a framework available to PHP developers to help them generate queries to any
OSF web service endpoint. Each OSF web service endpoint has its own WebServiceQuery class in the
OSF Web Services PHP API. This class is used to generate any query, to send it to be endpoint of a OSF instance
and to get back a resultset. The resultset can then be manipulated by using the Resultset API. This same API
can be used to transform the resultset into different formats.


Documentation
=============

How to use the API
------------------

This API is used to generate OSF queries to different web service endpoints. This API framework is composed
of a series of classes that are used to help PHP developers create OSF queries in their respective PHP applications.

The use of this API is simple. Developers normally have three easy steps to do:

+ Instantiate the class of the web service they want to query
+ Define all the parameters/features/behaviors of the web service by invoking different methods of the class
+ Send the resulting query using the send() method

Here is an example of a query that is generated using the OSF Web Services PHP API and sent to specific
OSF network instance:

```php
  <?php
  
  //
  // Step #1: Instantiate the class of the web service then want to query
  //
  
  // Create the SearchQuery object
  $search = new SearchQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
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

The OSF PHP API does comply with the [PSR-0 Standard Document](https://gist.github.com/1234504) 
for auto-loading the classes of the framework. The SplClassLoader class that has been developed by
the same group can be used as the classes auto-loader.

Here is an example of how you can auto-load the classes of the OSF PHP API framework:

```php
  <?php

  include_once("SplClassLoader.php");
  
  // Load the \ws namespace where all the web service code is located 
  $loader_ws = new SplClassLoader('StructuredDynamics\osf\php\api\ws');
  $loader_ws->register();
  
  // Load the \framework namespace where all the supporting (utility) code is located
  $loader_framework = new SplClassLoader('StructuredDynamics\osf\php\api\framework');
  $loader_framework->register();
 
  // Use the SearchQuery class
  use StructuredDynamics\osf\php\api\ws\search\SearchQuery;
  
  // Create the SearchQuery object
  $search = new SearchQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
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
Here are some examples of how each of the web services can be used.

Auth: Lister
------------
```php
  <?php
  
  // Use the AuthListerQuery class
  use \StructuredDynamics\osf\php\api\ws\auth\lister\AuthListerQuery;
  
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

Auth Registrar Access
---------------------
```php
  <?php

  use \StructuredDynamics\osf\framework\Namespaces;
  use \StructuredDynamics\osf\php\api\ws\auth\registrar\access\AuthRegistrarAccessQuery;
  use \StructuredDynamics\osf\php\api\ws\auth\lister\AuthListerQuery;
  use \StructuredDynamics\osf\php\api\framework\CRUDPermission;
    
  // Get all the web services registered on this instance with a 
  
  // Create the AuthListerQuery object
  $authlister = new AuthListerQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
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

  // Create a new Access record
  $ara = new AuthRegistrarAccessQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
  $ara->create("some-group", "http://localhost/ws/dataset/my-new-dataset-3/", new CRUDPermission(TRUE, TRUE, TRUE, TRUE), $webservices);
  
  $ara->send();

  if($ara->isSuccessful())
  {
    // Now, let's make sure that  the record access is properly created.'
    // Create the AuthListerQuery object
    $authlister = new AuthListerQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
    
    // Specifies that we want to get all the list of all registered web service endpoints.
    $authlister->getDatasetUsersAccesses("http://localhost/ws/dataset/my-new-dataset-3/");
    
    // Send the auth lister query to the endpoint
    $authlister->send();
    
    // Get back the resultset returned by the endpoint
    $resultset = $authlister->getResultset();
    
    print_r($resultset);      
  }  
  else
  {
    echo "Access record creation failed: ".$ara->getStatus()." (".$ara->getStatusMessage().")\n";
    echo $ara->getStatusMessageDescription();    
  }  
  
  ?>
```  

Auth: Registrar WS
------------------
```php
  <?php
  
  use \StructuredDynamics\osf\framework\Namespaces;                     
  use \StructuredDynamics\osf\php\api\ws\auth\registrar\ws\AuthRegistrarWsQuery;
  use \StructuredDynamics\osf\php\api\ws\auth\lister\AuthListerQuery;
  use \StructuredDynamics\osf\php\api\framework\CRUDPermission;
  
  // Register a new web service endpoint to the OSF instance
  $arws = new AuthRegistrarWsQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');

  // Define the title 
  $arws->title("A new web service endpoint");
  
  // Define the endpoint's URI
  $arws->endpointUri("http://localhost/wsf/ws/new/");
  
  // Define the access URL
  $arws->endpointUrl("http://localhost/ws/new/");
  
  // Specifies that READ permission are needed to use this web service endpoint
  $arws->crudUsage(new CRUDPermission(FALSE, TRUE, FALSE, FALSE));
  
  $arws->send();

  if($arws->isSuccessful())
  {
    // Now, let's use the auth: lister endpoint to make sure we can see it in the OSF instance
    $authlister = new AuthListerQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
    
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
    
    print_r($webservices);
  }
  else
  {
    echo "Web service registration failed: ".$arws->getStatus()." (".$arws->getStatusMessage().")\n";
    echo $arws->getStatusMessageDescription();  
  }  
  
  ?>
```    

Dataset: Create
---------------
```php
  <?php

  // Use the DatasetCreateQuery class
  use \StructuredDynamics\osf\php\api\ws\dataset\create\DatasetCreateQuery;
  
  // Create the DatasetCreateQuery object
  $dcreate = new DatasetCreateQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
  // Set the URI of the new dataset
  $dcreate->uri("http://localhost/ws/dataset/my-new-dataset/");
  
  // Set the title of the dataset
  $dcreate->title("My Brand New Dataset");
  
  // Set the description of the dataset
  $dcreate->description("This is something to look at!");
  
  // Set the creator's URI
  $dcreate->creator("http://localhost/people/bob/");
  
  
  // Get all the web services registered on this instance with a 
  use \StructuredDynamics\osf\php\api\ws\auth\lister\AuthListerQuery;
  use \StructuredDynamics\osf\framework\Namespaces;
  
  // Create the AuthListerQuery object
  $authlister = new AuthListerQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
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
  
  use \StructuredDynamics\osf\php\api\framework\CRUDPermission;
  
  // We make this new dataset world readable
  $dcreate->globalPermissions(new CRUDPermission(FALSE, TRUE, FALSE, FALSE));
  
  // Send the crud read query to the endpoint
  $dcreate->send();
  
  // Now we make sure we create the new dataset by looking into the system
  // using the Auth Lister again
  
  // Create the AuthListerQuery object
  $authlister = new AuthListerQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
  // Specifies that we want to get all the list of all registered web service endpoints.
  $authlister->getDatasetUsersAccesses("http://localhost/ws/dataset/my-new-dataset/");
  
  // Send the auth lister query to the endpoint
  $authlister->send();
  
  // Get back the resultset returned by the endpoint
  $resultset = $authlister->getResultset();
  
  print_r($resultset);
 
  ?>
```

Dataset: Read
-------------
```php
  <?php

  use \StructuredDynamics\osf\php\api\ws\dataset\read\DatasetReadQuery;
  
  $dRead = new DatasetReadQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');

  // Specify the Dataset URI for which we want its description
  $dRead->uri("http://localhost/ws/dataset/my-new-dataset-3/");
  
  $dRead->send();
  
  if($dRead->isSuccessful())
  {
    // Get the RDF+N3 serialization of the resultset    
    echo $dRead->getResultset()->getResultsetRDFN3();
  }
  else
  {
    echo "Dataset read failed: ".$dRead->getStatus()." (".$dRead->getStatusMessage().")\n";
    echo $dRead->getStatusMessageDescription();  
  }
  
  ?>
```  

Dataset: Update
---------------
```php
  <?php
  
  use \StructuredDynamics\osf\php\api\ws\dataset\create\DatasetCreateQuery;
  use \StructuredDynamics\osf\php\api\ws\dataset\update\DatasetUpdateQuery;
  use \StructuredDynamics\osf\php\api\ws\dataset\read\DatasetReadQuery;
  use \StructuredDynamics\osf\php\api\ws\auth\lister\AuthListerQuery;
  use \StructuredDynamics\osf\framework\Namespaces;
  use \StructuredDynamics\osf\php\api\framework\CRUDPermission;
      
  // First, let's create a new dataset to update after
  
  // Create the DatasetCreateQuery object
  $dcreate = new DatasetCreateQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
  // Set the URI of the new dataset
  $dcreate->uri("http://localhost/ws/dataset/my-new-dataset-6/");
  
  // Set the title of the dataset
  $dcreate->title("My Brand New Dataset to update!");
  
  // Set the description of the dataset
  $dcreate->description("This is something to look at!");
  
  // Set the creator's URI
  $dcreate->creator("http://localhost/people/bob/");
  
  
  // Get all the web services registered on this instance with a 
  
  // Create the AuthListerQuery object
  $authlister = new AuthListerQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
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
  
  // We make this new dataset world readable
  $dcreate->globalPermissions(new CRUDPermission(FALSE, TRUE, FALSE, FALSE));
  
  // Send the crud read query to the endpoint
  $dcreate->send();   
  
  $dupdate = new DatasetUpdateQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
  // Set the URI of the dataset to update
  $dupdate->uri("http://localhost/ws/dataset/my-new-dataset-6/");
  
  // Set the title of the dataset
  $dupdate->title("My Brand New Updated Dataset!");
  
  // Set the description of the dataset
  // Here we want to keep the same as the old one
  $dupdate->description("This is something to look at!");
  
  // Set the contributors to this dataset. Keep Bob, and add Kelly.
  $dupdate->contributors(array("http://localhost/people/bob/", "http://localhost/people/kelly/"));  
  
  // Specify the date it got modifed, with our own date format.
  $dupdate->modified(date('l jS \of F Y h:i:s A'));
  
  // Update the description of the dataset
  $dupdate->send();

  if($dupdate->isSuccessful())
  {
    // Now that it is updated, use the Dataset Read endpoint to get the description
    // of our updated dataset in RDF+XML
    $dRead = new DatasetReadQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');

    // Specify the Dataset URI for which we want its description
    $dRead->uri("http://localhost/ws/dataset/my-new-dataset-6/");
    
    $dRead->send();
    
    if($dRead->isSuccessful())
    {
      // Get the RDF+XML serialization of the resultset    
      echo $dRead->getResultset()->getResultsetRDFXML();
    }    
    else
    {
      echo "Dataset read failed: ".$dRead->getStatus()." (".$dRead->getStatusMessage().")\n";
      echo $dRead->getStatusMessageDescription();       
    }
  } 
  else
  {
    echo "Dataset update failed: ".$dupdate->getStatus()." (".$dupdate->getStatusMessage().")\n";
    echo $dupdate->getStatusMessageDescription();     
  }  
  
  ?>
```  

Dataset: Delete
---------------
```php
  <?php
  
  use \StructuredDynamics\osf\php\api\ws\dataset\create\DatasetCreateQuery;
  use \StructuredDynamics\osf\php\api\ws\dataset\delete\DatasetDeleteQuery;
  use \StructuredDynamics\osf\php\api\ws\auth\lister\AuthListerQuery;
  use \StructuredDynamics\osf\framework\Namespaces;
  use \StructuredDynamics\osf\php\api\framework\CRUDPermission;
      
  // First, let's create a new dataset to delete after
  
  // Create the DatasetCreateQuery object
  $dcreate = new DatasetCreateQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
  // Set the URI of the new dataset
  $dcreate->uri("http://localhost/ws/dataset/my-new-dataset-5/");
  
  // Set the title of the dataset
  $dcreate->title("My Brand New Dataset to delete!");
  
  // Set the description of the dataset
  $dcreate->description("This is something to look at!");
  
  // Set the creator's URI
  $dcreate->creator("http://localhost/people/bob/");
  
  
  // Get all the web services registered on this instance with a 
  
  // Create the AuthListerQuery object
  $authlister = new AuthListerQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
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
  
  // We make this new dataset world readable
  $dcreate->globalPermissions(new CRUDPermission(FALSE, TRUE, FALSE, FALSE));
  
  // Send the crud read query to the endpoint
  $dcreate->send();
  
  // Now, let's delete that dataset!  
  $dDelete = new DatasetDeleteQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
  // Specify the URI of the dataset we want to remove
  $dDelete->uri("http://localhost/ws/dataset/my-new-dataset-5/");
  
  // Send que request
  $dDelete->send();
  
  if($dDelete->isSuccessful())
  {
    // Get the RDF+N3 serialization of the resultset    
    echo "Dataset deleted!";
  }
  else
  {
    echo "Dataset deletation failed: ".$dDelete->getStatus()." (".$dDelete->getStatusMessage().")\n";
    echo $dDelete->getStatusMessageDescription();  
  }
    
  ?>
```

Crud: Create
------------

```php
  <?php
  
  // Use the CrudCreateQuery class
  use \StructuredDynamics\osf\php\api\ws\crud\create\CrudCreateQuery;
  
  // Create the CrudCreateQuery object
  $crudCreate = new CrudCreateQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
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
  
  // Make sure we index that new RDF data everywhere in the OSF instance
  $crudCreate->enableFullIndexationMode();
  
  // Import that new RDF data
  $crudCreate->send();

  use StructuredDynamics\osf\php\api\ws\search\SearchQuery;
  
  if($crudCreate->isSuccessful())
  {
    // Now that it got imported, let's try to search for that new record using the Search endpoint.
    
    // Create the SearchQuery object
    $search = new SearchQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
    
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

Crud: Read
----------
```php
  <?php

  // Use the CrudReadQuery class
  use StructuredDynamics\osf\php\api\ws\crud\read\CrudReadQuery;
  
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

CRUD: Update
------------
```php
  <?php
  
  // Use the CrudCreateQuery class
  use \StructuredDynamics\osf\php\api\ws\crud\create\CrudCreateQuery;
  
  // Use the CrudUpdateQuery class
  use \StructuredDynamics\osf\php\api\ws\crud\update\CrudUpdateQuery;

  // Use the SearchQuery class  
  use StructuredDynamics\osf\php\api\ws\search\SearchQuery;
  
  
  // First, let's create our object that we will then modify.
  
  // Create the CrudCreateQuery object
  $crudCreate = new CrudCreateQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
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
  
  // Make sure we index that new RDF data everywhere in the OSF instance
  $crudCreate->enableFullIndexationMode();
  
  // Import that new RDF data
  $crudCreate->send();

  if($crudCreate->isSuccessful())
  {
    // Now that it got created, let's try to modify it.
    
    // Create the CrudUpdateQuery object
    $crudUpdate = new CrudUpdateQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
    
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
    $crudUpdate->send();

    if($crudUpdate->isSuccessful())
    {    
      // If the document has been properly updated, let's try to search for it.
      
      // Create the SearchQuery object
      $search = new SearchQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
      
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

CRUD: Delete
------------
```php
  <?php
  
  // Use the CrudDeleteQuery class
  use \StructuredDynamics\osf\php\api\ws\crud\delete\CrudDeleteQuery;
  
  // Create the CrudDeleteQuery object
  $crudDelete = new CrudDeleteQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
  // Specifies where the record we want to delete is indexed
  $crudDelete->dataset("http://localhost/ws/dataset/my-new-dataset/");
  
  // Specifies the URI of the record we want to delete from the system
  $crudDelete->uri("http://www.w3.org/");
  
  // Import that new RDF data
  $crudDelete->send();

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

Ontology: Create
----------------
```php
  <?php
  
  use \StructuredDynamics\osf\php\api\ws\ontology\create\OntologyCreateQuery;
  use \StructuredDynamics\osf\php\api\ws\ontology\read\OntologyReadQuery;
  use \StructuredDynamics\osf\php\api\ws\ontology\read\GetLoadedOntologiesFunction;
  
  $ontologyCreate = new OntologyCreateQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
  // Create the vcard ontology for which its description is located somewhere on the Web
  $ontologyCreate->uri("http://www.w3.org/2006/vcard/ns");
  
  // Enable advanced indexation to have access to it on all OSF endpoints
  $ontologyCreate->enableAdvancedIndexation();
  
  // Enable reasoner to persist inferred facts into all endpoints of OSF
  $ontologyCreate->enableReasoner();
  
  // Import the new ontology
  $ontologyCreate->send();

  if($ontologyCreate->isSuccessful())
  {
    // Now, let's use the ontology read service to make sure it got loaded.
    $ontologyRead = new OntologyReadQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
    
    $ontologyRead->ontology("http://www.w3.org/2006/vcard/ns");

    $getLoadedOntologies = new GetLoadedOntologiesFunction();
    
    $getLoadedOntologies->modeUris();
    
    $ontologyRead->getLoadedOntologies($getLoadedOntologies);
    
    $ontologyRead->send();
    
    echo $ontologyRead->getResultset()->getResultset();    
  }
  else
  {
    echo "Ontology importation failed: ".$ontologyCreate->getStatus()." (".$ontologyCreate->getStatusMessage().")\n";
    echo $ontologyCreate->getStatusMessageDescription();       
  }
    
  ?>
```  

Ontology: Read
--------------
```php
  <?php
  
  use \StructuredDynamics\osf\php\api\ws\ontology\read\OntologyReadQuery;
  use \StructuredDynamics\osf\php\api\ws\ontology\read\GetClassesFunction;
  
  // Create the Ontology Read query
  $ontologyRead = new OntologyReadQuery("http://demo.citizen-dan.org/ws/");
  
  // Enable the reasoner for this query
  $ontologyRead->enableReasoner();
  
  // Specify the MUNI ontology from the citizen demo website
  $ontologyRead->ontology("file://localhost/data/ontologies/files/demo.citizen-dan.org/muni.owl");
  
  // Specify that we want RDF+XML data as output
  $ontologyRead->mime("application/rdf+xml");
  
  // Prepare the function call to send to the endpoint.
  $getClassesFunction = new GetClassesFunction();
  
  // Sepcify that we want all the classes URIs from this ontology
  $getClassesFunction->getClassesUris();
  
  // Specify that we only want to first 20 results
  $getClassesFunction->limit(20);
  $getClassesFunction->offset(0);
  
  // Prepare the getClasses call
  $ontologyRead->getClasses($getClassesFunction);
  
  // Send the query
  $ontologyRead->send();
  
  if($ontologyRead->isSuccessful())
  {
    echo $ontologyRead->getResultset();
  }
  else
  {
    echo "Ontology importation failed: ".$ontologyRead->getStatus()." (".$ontologyRead->getStatusMessage().")\n";
    echo $ontologyRead->getStatusMessageDescription();       
  }  
  
  ?>
```  

Ontology: Update
----------------
```php
  <?php
  
  use \StructuredDynamics\osf\php\api\ws\ontology\create\OntologyCreateQuery;
  use \StructuredDynamics\osf\php\api\ws\ontology\update\OntologyUpdateQuery;
  use \StructuredDynamics\osf\php\api\ws\ontology\update\CreateOrUpdateEntityFunction;
  use \StructuredDynamics\osf\php\api\ws\ontology\update\UpdateEntityUriFunction;
  use \StructuredDynamics\osf\php\api\ws\ontology\read\OntologyReadQuery;
  use \StructuredDynamics\osf\php\api\ws\ontology\read\GetClassFunction;
  
  // First, let's create an initial ontology
  $ontologyCreate = new OntologyCreateQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
  // Create the vcard ontology for which its description is located somewhere on the Web
  $ontologyCreate->uri("http://www.w3.org/2006/vcard/ns");
  
  // Enable advanced indexation to have access to it on all OSF endpoints
  $ontologyCreate->enableAdvancedIndexation();
  
  // Enable reasoner to persist inferred facts into all endpoints of OSF
  $ontologyCreate->enableReasoner();
  
  // Import the new ontology
  $ontologyCreate->send();

  if($ontologyCreate->isSuccessful())
  {
    // Now, let's change the URI of the class "http://www.w3.org/2006/vcard/ns#Address"
    // to http://www.w3.org/2006/vcard/ns#Addr

    $ontologyUpdate = new OntologyUpdateQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
    
    $ontologyUpdate->ontology("http://www.w3.org/2006/vcard/ns");
    
    $updateEntityUriFunction = new UpdateEntityUriFunction();
    
    $updateEntityUriFunction->oldUri("http://www.w3.org/2006/vcard/ns#Address");
    
    $updateEntityUriFunction->newUri("http://www.w3.org/2006/vcard/ns#Addr");
    
    $ontologyUpdate->updateEntityUri($updateEntityUriFunction);
    
    $ontologyUpdate->send();
    
    if($ontologyUpdate->isSuccessful())
    {
      // Now, let's read information about the Address class, using its 
      // brand new URI.
      $ontologyRead = new OntologyReadQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
      
      $ontologyRead->mime("application/rdf+n3");
      
      $ontologyRead->ontology("http://www.w3.org/2006/vcard/ns");

      $getClass = new GetClassFunction();
      
      $getClass->uri("http://www.w3.org/2006/vcard/ns#Addr");
      
      $ontologyRead->getClass($getClass);
      
      $ontologyRead->send();      
      
      echo $ontologyRead->getResultset();
      print_r(var_export($ontologyRead, TRUE));
      
    }
    else
    {
      echo "Ontology update failed: ".$ontologyUpdate->getStatus()." (".$ontologyUpdate->getStatusMessage().")\n";
      echo $ontologyUpdate->getStatusMessageDescription();         
    } 
  }
  else
  {
    echo "Ontology importation failed: ".$ontologyCreate->getStatus()." (".$ontologyCreate->getStatusMessage().")\n";
    echo $ontologyCreate->getStatusMessageDescription();       
  }  
  
  ?>
``` 

Ontology: Delete
----------------
```php
  <?php

  use \StructuredDynamics\osf\php\api\ws\ontology\create\OntologyCreateQuery;
  use \StructuredDynamics\osf\php\api\ws\ontology\delete\OntologyDeleteQuery;
  use \StructuredDynamics\osf\php\api\ws\ontology\delete\DeleteClassFunction;
  
  $ontologyCreate = new OntologyCreateQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
  // Create the vcard ontology for which its description is located somewhere on the Web
  $ontologyCreate->uri("http://www.w3.org/2006/vcard/ns");
  
  // Enable advanced indexation to have access to it on all OSF endpoints
  $ontologyCreate->enableAdvancedIndexation();
  
  // Enable reasoner to persist inferred facts into all endpoints of OSF
  $ontologyCreate->enableReasoner();
  
  // Import the new ontology
  $ontologyCreate->send();

  if(!$ontologyCreate->isSuccessful())
  {
    // Now delete one of the class of this ontology
    $ontologyDelete = new OntologyDeleteQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
    
    $ontologyDelete->ontology("http://www.w3.org/2006/vcard/ns");
    
    $deleteClassFunction = new DeleteClassFunction();
    
    $deleteClassFunction->uri("http://www.w3.org/2006/vcard/ns#Address");
    
    $ontologyDelete->deleteClass($deleteClassFunction);

    $ontologyDelete->send();
    
    if($ontologyDelete->isSuccessful())
    {
      echo "Class successfully delete";
    }
    else
    {
      echo "Ontology class deletation failed: ".$ontologyDelete->getStatus()." (".$ontologyDelete->getStatusMessage().")\n";
      echo $ontologyDelete->getStatusMessageDescription();      
    }
  }
  else
  {
    echo "Ontology importation failed: ".$ontologyCreate->getStatus()." (".$ontologyCreate->getStatusMessage().")\n";
    echo $ontologyCreate->getStatusMessageDescription();       
  }
  
  ?>
``` 

Search
------
```php
  <?php

  // Use the SearchQuery class
  use StructuredDynamics\osf\php\api\ws\search\SearchQuery;
  
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

Scones
------
```php
  <?php
  
  use \StructuredDynamics\osf\php\api\ws\scones\SconesQuery;
  
  $scones = new SconesQuery('http://localhost/ws/', 'some-app-id', 'some-api-key', 'http://localhost/users/foo');
  
  // Specify the document (in this case, a web page) you want to tag using that Scones instance.
  $scones->document("http://fgiasson.com");
  
  // Tag the document
  $scones->send();

  if($scones->isSuccessful())
  {
    // Output the Gate tagged document.
    echo $scones->getResultset();
  }
  else
  {
    echo "Scones tagging failed: ".$scones->getStatus()." (".$scones->getStatusMessage().")\n";
    echo $scones->getStatusMessageDescription();       
  }
    
  ?>
```  