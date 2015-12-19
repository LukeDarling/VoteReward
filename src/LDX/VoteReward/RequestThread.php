<?php

namespace LDX\VoteReward;

use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;

class RequestThread extends AsyncTask {

  private $queries = [];
  private $errors = [];
  private $rewards = 0;

  function __construct($id, array $queries) {
    $this->id = $id;
    $this->queries = $queries;
  }

  public function onRun() {
    foreach($this->queries as $query) {
      if(($return = @file_get_contents(str_replace("{USERNAME}", $this->id, $query->getCheckURL()))) != false) {
        $return = json_decode($return, true);
        $query->setVoted($return["voted"] ? 1 : -1);
        $query->setClaimed($return["claimed"] ? 1 : -1);
        if($query->hasVoted() == 1 && $query->hasClaimed() == -1) {
          if(($return = @file_get_contents(str_replace("{USERNAME}", $this->id, $query->getClaimURL()))) != false) {
            $return = json_decode($return, true);
            $query->setVoted($return["voted"] ? 1 : -1);
            $query->setClaimed($return["claimed"] ? 1 : -1);
            if($query->hasVoted() == 1 && $query->hasClaimed() == 1) {
              $this->rewards++;
            }
          } else {
            $this->errors[] = "Error sending claim data for #[{$this->id}] to \"" . str_replace("{USERNAME}", $this->id, $query->getCheckURL() . "\". Invalid VRC file or bad Internet connection.");
            $query->setVoted(-1);
            $query->setClaimed(-1);
          }
        }
      } else {
        $this->errors[] = "Error fetching vote data for #[{$this->id}] from \"" . str_replace("{USERNAME}", $this->id, $query->getCheckURL() . "\". Invalid VRC file or bad Internet connection.");
        $query->setVoted(-1);
        $query->setClaimed(-1);
      }
    }
  }

  public function onCompletion(Server $server) {
    foreach($this->errors as $error) {
      $server->getLogger()->warning("[VoteReward] $error");
    }
    $server->getPluginManager()->getPlugin("VoteReward")->rewardPlayer($server->getPlayerExact($this->id), $rewards);
  }

}
