<?php
  //define washroom object

  class Washroom {
    public $id;
    public $longitude;
    public $latitude;
    public $building;
    public $room_num;
    public $description;
    public $gender;
    public $rating;
    public $distance;

    public function __construct($lat, $long, $building, $room_num, $description, $gender, $rating) {
      $this->latitude = (double) $lat;
      $this->longitude = (double) $long;
      $this->building = $building;
      $this->room_num = $room_num;
      $this->description = $description;
      $this->gender = $gender;
      $this->id = $building . $room_num;
      if ($rating == NULL) {
        $this->rating = "No ratings yet";
      } else {
        $this->rating = $rating . "/5";
      }
    }

    //print washroom
    function print_washroom() {
      return '<b>Name: </b>' . $this->id . '<br>' . '<b>Distance: </b>' . $this->distance .
        'm<br>' . '<b>Gender: </b>'. $this->gender . '<br>' . '<b>Description: </b>' . $this->description .
        '<br>' . '<b>Rating: </b>' . $this->rating . '<br>';

    }
  }
?>
