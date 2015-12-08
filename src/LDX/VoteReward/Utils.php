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

  public static function translateColors($string) {
    $message = preg_replace_callback("/(\\\&|\&)[0-9a-fk-or]/", function($matches) {
      return str_replace("\\§", "&", str_replace("&", "§", $matches[0]));
    }, $string);
    return $string;
  }

}
