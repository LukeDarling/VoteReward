<?php

namespace LDX\VoteReward;

class Request {

  private $list;
  private $player;
  private $type;
  private $data = [];

  public function __construct($player, $list, $type) {
    $this->player = $player;
    $this->list = $list;
    $this->type = $type;
  }

  public function getPlayer() {
    return $this->player;
  }

  public function getList() {
    return $this->list;
  }
  
  public function getURL() {
    return isset($this->list[strtolower($type)]) ? $this->list[strtolower($type)] : false;
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