<?php
  require_once("WalkScore.php");
  $w = new WalkScore('YOUR API KEY HERE');

  // WalkScore example
  // Example data from http://www.walkscore.com/professional/api.php
  $options = array(
    'address' => '1119 208th Ave S, Seattle, WA',
    'lat' => 47.6085,
    'lon' => -122.3295,
  );
  printf("WalkScore for %s:\n", $options['address']);
  print_r($w->WalkScore($options));

  // Walking Distance (WalkShed) example
  // Example data from http://www.walkscore.com/professional/api.php
  $options = array(
    'lat' =>  47.5815,
    'lon' => -122.335,
  );
  printf("Walking Distance (WalkShed) for %s, %s:\n", $options['lat'], $options['lon']);
  print_r($w->WalkShed($options));

  // Public Transit API example
  // Example data from http://www.walkscore.com/professional/public-transit-api.php
  $options = array(
    'lat' => 47.6101359,
    'lon' => -122.3420567,
    'city' => 'Seattle',
    'state' => 'WA',
  );
  printf("Public Transit Score for %s, %s (%s, %s):\n", $options['city'], $options['state'], $options['lat'], $options['lon']);
  print_r($w->PublicTransit('score', $options));

  // Travel Time API example
  // Example data from http://www.walkscore.com/professional/travel-time-api.php
  $options = array(
    'mode' => 'walk',
    'origin' => '47.649677,-122.357569',
    'destination' => '47.646757,-122.361152',
  );
  printf("Travel time (walking) between %s and %s:\n", $options['origin'], $options['destination']);
  print_r($w->TravelTime($options));