<?php
class WalkScore {

  function __construct($wsapikey) {
    // a Walk Score API key is required
    if (!isset($wsapikey)) {
      throw new Exception("Walk Score API key required");
    }
    $this->wsapikey = $wsapikey;
  }

  function make_api_call($url, $options) {
    $options['wsapikey'] = $this->wsapikey;
    $options['format'] = 'json';    
    $query = http_build_query($options);
    $response_url = $url . '?' . $query;
    $curlHandler = curl_init();
    curl_setopt($curlHandler, CURLOPT_URL, $response_url);
    curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curlHandler, CURLOPT_USERAGENT, $user_agent);
    curl_exec($curlHandler);
    $response_json = curl_multi_getcontent($curlHandler);
    $response = json_decode($response_json);
    return $response;
  }

  function PublicTransit($call, $options = array()) {
    $api_url = 'http://transit.walkscore.com/transit/';
    switch ($call) {
      case 'score':
        $api_url .= 'score/';
        break;
      case 'stop search':
        $api_url .= 'search/stops/';
        break;
      case 'network search':
        $api_url .= 'search/network/';
        break;
      case 'stop detail':
        $api_url .= 'stop/ID/';
        break;
      case 'route detail':
        $api_url .= 'route/ID/';
        break;
      case 'supported cities':
        $api_url .= 'supported/cities/';
        break;
    }
    return $this->make_api_call($api_url, $options);
  }

  function WalkScore($options = array()) {
    if (!is_array($options)) {
      throw new Exception("Input parameter must be an array.");
    }
    
    $response = $this->make_api_call('http://api.walkscore.com/score', $options);

    // stuff the status code description in the response object
    // so you don't have to look it up on the Walk Score website
    switch ($response->status) {
      case 1:
        $status_description = 'Walk Score successfully returned.';
        break;
      case 2: 
        $status_description = 'Score is being calculated and is not currently available.';
        break;
      case 30:
        $status_description = 'Invalid latitude/longitude.';
        break;
      case 40:
        $status_description = 'Your WSAPIKEY is invalid.';
        break;
      case 41:
        $status_description = 'Your daily API quota has been exceeded.';
        break;
      case 42:
        $status_description = 'Your IP address has been blocked.';
        break;
    }

    $response->status_description = $status_description;

    return $response;
  }
}
