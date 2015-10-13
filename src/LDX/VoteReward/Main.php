<?php

namespace LDX\VoteReward;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\item\Item;

class Main extends PluginBase {

  public function onEnable() {
    $this->reload();
  }

  public function reload() {
    $this->saveDefaultConfig();
    if(!is_dir($this->getDataFolder() . "Lists/")) {
      mkdir($this->getDataFolder() . "Lists/");
    }
    $this->config = $this->getConfig()->getAll();
    $this->items = [];
    foreach($this->config["Items"] as $i) {
      $r = explode(":",$i);
      $this->items[] = new Item($r[0],$r[1],$r[2]);
    }
    $this->commands = [];
    foreach($this->config["Commands"] as $i) {
      $this->commands[] = $i;
    }
  }

}
