<?php
class Orbis_Destination {
  
  public $original_url;
  public $domain;
  public $destination;
  
  function __construct($url) {
    $this->original_url = $url;
    $this->domain = substr($url, 0, strpos($url, '.com')+4);
    $this->destination = $this->find_destination($url);
  }
  
  // Get a response header for a given URL
  function get_response($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);
    if($status_code == 302 or $status_code == 301){
      return $response;
    }
    else {
      return false;
    }
  }

  // Extract the location from a response header
  function get_location($response) {
    preg_match_all('/^Location:(.*)$/mi', $response, $matches);
    if (!empty($matches[1])) {
      return urldecode(trim($matches[1][0]));
    }
    else {
      return false;
    }
  }

  // Get cURL responses until the location contains /discovery
  function find_destination($url) {
    if ($response = $this->get_response($url)) {
      $location = $this->get_location($response);
      if (substr($location, 0, 10) != '/discovery') {
        return $this->find_destination($this->domain . $location);
      }
      else return $this->domain . $location;
    }
    else {
      return false;
    }
  }
  
  // Return the resulting destination
  function get_result() {
    if (!empty($this->destination)) {
      return '<p>' . $this->destination . '</p><p>(<a href="' . $this->destination . '" target="_blank">Test link</a>)</p>';
    }
    else {
      return '<p>No redirect URL found.</p>';
    }
  }
}
?>