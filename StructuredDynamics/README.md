Auto-loading of Classes
=======================

The OSF Web Services PHP API does comply with the [PSR-0 Standard Document](https://gist.github.com/1234504) 
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
 
  // Load the \framework namespace where all the supporting (utility) code is located
  $loader_framework = new SplClassLoader('StructuredDynamics\osf\framework');
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