<?php

namespace LDX\VoteReward;

use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;

class RequestThread extends AsyncTask {

  private $queries;
  private $rewards;

  public function __construct($id, $queries) {
    $this->id = $id;
    $this->queries = $queries;
  }

  public function onRun() {
    foreach($this->queries as $query) {
      if(($return = Utils::getURL(str_replace("{USERNAME}", urlencode($this->id), $query->getCheckURL()))) != false && is_array(($return = json_decode($return, true))) && isset($return["voted"]) && is_bool($return["voted"]) && isset($return["claimed"]) && is_bool($return["claimed"])) {
        $query->setVoted($return["voted"] ? 1 : -1);
        $query->setClaimed($return["claimed"] ? 1 : -1);
        if($query->hasVoted() && !$query->hasClaimed()) {
          if(($return = Utils::getURL(str_replace("{USERNAME}", urlencode($this->id), $query->getClaimURL()))) != false && is_array(($return = json_decode($return, true))) && isset($return["voted"]) && is_bool($return["voted"]) && isset($return["claimed"]) && is_bool($return["claimed"])) {
            $query->setVoted($return["voted"] ? 1 : -1);
            $query->setClaimed($return["claimed"] ? 1 : -1);
            if($query->hasVoted() && $query->hasClaimed()) {
              $this->rewards++;
            }
          } else {
            $this->error = "Error sending claim data for \"" . $this->id . "\" to \"" . str_replace("{USERNAME}", urlencode($this->id), $query->getClaimURL()) . "\". Invalid VRC file or bad Internet connection.";
            $query->setVoted(-1);
            $query->setClaimed(-1);
          }
        }
      } else {
        $this->error = "Error fetching vote data for \"" . $this->id . "\" from \"" . str_replace("{USERNAME}", urlencode($this->id), $query->getCheckURL()) . "\". Invalid VRC file or bad Internet connection.";
        $query->setVoted(-1);
        $query->setClaimed(-1);
      }
    }
  }

  public function onCompletion(Server $server) {
    if(isset($this->error)) {
      $server->getPluginManager()->getPlugin("VoteReward")->getLogger()->error($this->error);
    }
    $server->getPluginManager()->getPlugin("VoteReward")->rewardPlayer($server->getPlayerExact($this->id), $this->rewards);
    array_splice($server->getPluginManager()->getPlugin("VoteReward")->queue, array_search($this->id, $server->getPluginManager()->getPlugin("VoteReward")->queue, true), 1);
  }

}
