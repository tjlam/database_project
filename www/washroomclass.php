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
        $this->rating = $rating;
      }
    }

    //print washroom
    function print_washroom() {
      return "id: " . $this->id . " distance: " . $this->distance .
        " description: " . $this->description . " gender: " . $this->gender .
        " rating: " . $this->rating . '<br>';
    }
  }
?>
