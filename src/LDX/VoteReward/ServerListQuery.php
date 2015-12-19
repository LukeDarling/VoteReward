<?php

namespace LDX\VoteReward;

class ServerListQuery {

  private $status = [];

  public function __construct($check, $claim) {
    $this->status = ["check" => ["url" => $check, "code" => 0], "claim" => ["url" => $claim, "code" => 0]];
  }

  public function getCheckURL() {
    return $this->status["check"]["url"];
  }
  
  public function getClaimURL() {
    return $this->status["claim"]["url"];
  }

  public function setVoted($value) {
    return $this->status["check"]["code"] = $value;
  }

  public function hasVoted() {
    return $this->status["check"]["code"] == 1;
  }

  public function setClaimed($value) {
    return $this->status["claim"]["code"] = $value;
  }

  public function hasClaimed() {
    return $this->status["claim"]["code"] == 1;
  }

}
