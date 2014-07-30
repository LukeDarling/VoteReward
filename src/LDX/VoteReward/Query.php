<?php
namespace LDX\VoteReward;
class Query extends \Threaded {
  public function __construct($plugin,$p,$url,$return) {
    $result = file_get_contents($url);
    if($return) {
      $plugin->give($p,$result);
    }
  }
}
?>
