## The task

This repository includes a single class file, responsible for managing a url string and it's component parts.

There are 5 steps to this test:

1. Using a regex to parse a URL is very flawed, can you refactor the class to parse a URL without using regex?
2. Can you create functionality that can switch the URL scheme from HTTP to HTTPS and vice versa.
3. Can you create functionality that can add and remove query parameters.
4. Can you create functionality to return the URL with any changes made through the previously added functionality.
5. Can you create functionality to compare 2 URL objects. It should perform 2 different comparisons, firstly it should be able to compare 2 URLs are exactly the same, and second it should be able to compare if 2 URLs are the same while ignoring the query string.

You do not need to spend more than a couple of hours on this. Keep good design principles in mind.


Solutions :
1. Refer to Url.php Line : 9
   
2. change the URL scheme 


     //test code 
     $url = new Url('http://khalid.com');
     $modifiedUrl = $url->switchUrlScheme('https');
     echo $modifiedUrl; // Output: https://khalid.com
     
3. to add query params
    

     $url = new Url('http://example.com/?foo=bar&baz=qux');
     $modifiedUrl = $url->addQueryParam('abc', '123');
     echo $modifiedUrl; // Output: http://khalid.com/?foo=bar&baz=qux&abc=123 
    //to remove query params
     $modifiedUrl = $newUrl->removeQueryParam('foo');
     echo $modifiedUrl; // Output: http://khalid.com/?baz=qux&abc=123
     
     
4. Can you create functionality to return the URL with any changes made through the     previously added functionality.
    //test code 

         $url = new Url('http://khalid.com');
         $newUrl = $url->switchUrlScheme('https')->addQueryParam('foo', 'bar');
         $modifiedUrl = $url->getModifiedUrl();
         echo $modifiedUrl; // Output: https://khalid.com/?foo=bar

5. comparing Urls with and without query params

         $url1 = new Url('http://khalid.com');
        $url2 = new Url('https://khalid.com');
        $url3 = new Url('http://khalid.com/?foo=bar');
        $url4 = new Url('http://khalid.com/?baz=qux');
        
        // check if $url1 and $url2 are the same URL
        echo $url1->isUrlSame($url2) ;
        
        // check if $url1 and $url3 are the same URL ignoring query params
        echo $url1->isUrlSameIgnoringQueryParams($url3);
        
        // check if $url3 and $url4 are the same URL ignoring query params
        echo $url3->isUrlSameIgnoringQueryParams($url4) ;