<?php

namespace LDX\VoteReward;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\item\Item;

class Main extends PluginBase {

  private $message = "";
  private $items = [];
  private $commands = [];

  public function onEnable() {
    $this->reload();
  }

  public function reload() {
    $this->saveDefaultConfig();
    if(!is_dir($this->getDataFolder() . "Lists/")) {
      mkdir($this->getDataFolder() . "Lists/");
    }
    $lists = [];
    foreach(scandir($this->getDataFolder() . "Lists/") as $file) {
      $ext = explode(".", $file);
      $ext = (count($ext) > 1 && isset($ext[count($ext) - 1]) ? strtolower($ext[count($ext) - 1]) : "");
      if($ext == "vrc") {
        $lists[] = $file;
      }
    }
    $config = $this->getConfig()->getAll();
    $this->message = $config["Message"];
    $this->items = [];
    foreach($config["Items"] as $i) {
      $r = explode(":", $i);
      $this->items[] = new Item($r[0], $r[1], $r[2]);
    }
    $this->commands = $config["Commands"];
  }

  public function getItems() {
    $clones = [];
    foreach($this->items as $item) {
      $clones[] = clone $item;
    }
    return $clones;
  }

  public function rewardPlayer(Player $player, int $multiplier) {
    foreach($this->getItems() as $item) {
      $item->setCount($item->getCount() * $multiplier);
      $player->addItem($item);
    }
    $commands = $this->commands;
    foreach($commands as $command) {
      preg_replace_callback("/(\\\&|\&)[0-9a-fk-or]/", function(array $matches) {
        return str_replace("\\§", "&", str_replace("&", "§", $matches[0]));
      }, $command);
      $this->getServer()->dispatchCommand(new ConsoleCommandSender, str_replace(array(
        "{USERNAME}",
        "{NICKNAME}",
        "{X}",
        "{Y}",
        "{Z}"
      ), array(
        $player->getName(),
        $player->getDisplayName(),
        $player->getX(),
        $player->getY(),
        $player->getZ()
      ), $command));
    }
    if(trim($message) != "") {
      $message = $this->message;
      preg_replace_callback("/(\\\&|\&)[0-9a-fk-or]/", function(array $matches) {
        return str_replace("\\§", "&", str_replace("&", "§", $matches[0]));
      }, $message);
      $message = str_replace(array(
        "{USERNAME}",
        "{NICKNAME}"
      ), array(
        $player->getName(),
        $player->getDisplayName()
      ), $message);
      foreach($this->getServer()->getOnlinePlayers() as $p) {
        $p->sendMessage($message);
      }
      $this->getServer()->getLogger()->info($message);
    }
  }

}
