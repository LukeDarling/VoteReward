<?php

namespace LDX\VoteReward;

use pocketmine\Player;

class Utils {

  public static function hasPermission($player,$permission) {
    $base = "";
    $nodes = explode(".",$permission);
    foreach($nodes as $key => $node) {
      $seperator = $key == 0 ? "" : ".";
      $base = "$base$seperator$node";
      if($player->hasPermission($base)) {
        return true;
      }
    }
    return false;
  }

}
