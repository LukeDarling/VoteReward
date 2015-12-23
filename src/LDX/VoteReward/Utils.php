<?php

namespace LDX\VoteReward;

class Utils {

  public static function hasPermission($player, $permission) {
    $base = "";
    $nodes = explode(".", $permission);
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
      return str_replace("§r", "§r§f", str_replace("\\§", "&", str_replace("&", "§", $matches[0])));
    }, $string);
    return $message;
  }

  public static function getURL($url) {
    $query = curl_init($url);
    curl_setopt($query, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($query, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($query, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($query, CURLOPT_FRESH_CONNECT, 1);
    curl_setopt($query, CURLOPT_AUTOREFERER, true);
    curl_setopt($query, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($query, CURLOPT_HTTPHEADER, array("User-Agent: VoteReward"));
    curl_setopt($query, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($query, CURLOPT_TIMEOUT, 5);
    $return = curl_exec($query);
    curl_close($query);
    return $return;
  }

}