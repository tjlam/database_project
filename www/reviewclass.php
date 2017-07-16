<?php
  class Review {
    public $id;
    public $wid;
    public $uid;
    public $rating;
    public $comment;
    public $timestamp;

    public function __contruct($id, $wid, $uid, $rating, $comment) {
      $this->id = $id;
      $this->wid = $wid;
      $this->uid = $uid;
      $this->rating = $rating;
      $this->$comment = $comment;
    }

    function printReview() {
      return $this->id . " " . $this->uid . " " . $this->rating . " " . $this->comment ;
    }
  }

?>
