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
  
  // Get the description of the Broading_schools record
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
