<?php

namespace LDX\VoteReward;

use pocketmine\Player;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class QueryTask extends AsyncTask {

  private $requests = [];

  function __construct(array $requests) {
    $this->requests = $requests;
  }

  public function onRun() {
    foreach($this->requests as $request) {
      $request->setData(file_get_contents(str_replace("{USERNAME}", $request->getPlayer()->getName(), $request->getURL())));
    }
  }

  public function onCompletion(Server $server) {
    $server->getPluginManager()->getPlugin("VoteReward")->returnQuery($this->requests);
  }

}