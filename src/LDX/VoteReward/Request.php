<?php

namespace LDX\VoteReward;

class Request {

  private $url;
  private $player;
  private $type;
  private $data = [];

  public function __construct($player, $url, $type) {
    $this->player = $player;
    $this->url = $url;
    $this->type = $type;
  }

  public function getPlayer() {
    return $this->player;
  }
  
  public function getURL() {
    return $this->url;
  }

  public function getType() {
    return $this->type;
  }

  public function getData() {
    return $this->data;
  }

  public function setData($data) {
    $this->data = $data;
  }

}