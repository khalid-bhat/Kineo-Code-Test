<?php
final class Url
{
    private array $parts;
    private string $url;
    public function __construct(string $url)
    {
        $this->url = $url;

        // use parse_url instead of a regex 
        $this->parts = parse_url($this->url);      
    }
    public function getScheme(): string
    {
        return $this->parts['scheme'];
    }
    
    public function getHost(): string
    {
        return $this->parts['host'];
    }
    
    public function getPath(): string
    {
        return $this->parts['path'] ?? '';
    }
    // function to get the query parameter string (e.g. "id=1&name=abc") of the URL
    public function getQuery(): string
    {
        $query = $this->parts['query'] ?? '';
        if (!is_string($query)) {
            return '';
        }
        parse_str($query,$params);
        return http_build_query($params);
    }

    // function that changes scheme of URL e.g https to http or vice versa
    public function switchUrlScheme(string $scheme): Url  
    {
        $this->parts['scheme'] = $scheme;
        return $this;
    }

    // function that adds a query param to the URL and return the modified Url object
    public function addQueryParam(string $key, string $value): Url  
    {
        // Parse the existing query string into an associative array
        parse_str($this->getQuery(), $queryParams);     
        // Update the array with the new query parameter.         
        $queryParams[$key] = $value;                              
        $this->parts['query'] = http_build_query($queryParams);
        return $this;
    }

    // function that removes a query param from the URL and return the modified Url object
    public function removeQueryParam(string $key): Url        
    {
        parse_str($this->getQuery(), $queryParams);  
        // Remove the provided query parameter from the array          
        unset($queryParams[$key]);                            
        $this->parts['query'] = http_build_query($queryParams);
        return $this;
    }

    //get the modified url using this function
    public function getModifiedUrl(): string               
    {
        $url = $this->getScheme() . '://' . $this->getHost();
        if (!empty($this->getPath())) {
            $url .= $this->getPath();
        }
        if (!empty($this->getQuery())) {
            $url .= '?' . $this->getQuery();
        }
        return $url;
    }
    
    //check url is same including query params
    public function isUrlSame(Url $otherUrl): bool              
    {
       // sort the query params so that order of params doesn't matter
        $thisParams = $this->sortQueryParams();
        $otherParams = $otherUrl->sortQueryParams();
      
        // separately compare if the urls are same while using isUrlSameIgnoringQueryParams() and also check if sorted query param string is same
        return ( $this->isUrlSameIgnoringQueryParams($otherUrl)) && ($thisParams === $otherParams);
    }

    //check url is same excluding query paramas
    public function isUrlSameIgnoringQueryParams(Url $otherUrl): bool       
    {
         
    $thisParts = $this->parts;
    unset($thisParts['query']);
    // trim the right trailing slash from both URLs
    $thisUrl = $thisParts['scheme'] . '://' . rtrim($thisParts['host'] . $thisParts['path'], '/');
    
    $otherParts = $otherUrl->parts;
    unset($otherParts['query']);
    $otherUrl = $otherParts['scheme'] . '://' . rtrim($otherParts['host'] . $otherParts['path'], '/');
    
    return $thisUrl === $otherUrl;
    }
    // getQueryParams in alphabetical order
    public function sortQueryParams(): string
    {
        $query = $this->getQuery();
        parse_str($query,$params);
        //sort the query params alphabetically so that their order won't matter
        ksort($params);
        return http_build_query($params);
    }
}