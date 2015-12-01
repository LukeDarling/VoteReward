<?php

namespace LDX\VoteReward;

use pocketmine\Player;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class QueryTask extends AsyncTask {

  function __construct(Request $request) {
    $this->request = $request;
  }

  public function onRun() {
    $this->request->setData(file_get_contents($this->request->getURL()));
  }

  public function onCompletion(Server $server) {
    if($this->request->shouldReturn()) {
      $server->getPluginManager()->getPlugin("VoteReward")->returnQuery($this->request->copy());
      unset($this->request);
    }
  }

}