<?php
namespace LDX\VoteReward;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\item\Item;
class Main extends PluginBase {
  private $items, $commands, $key, $url;
  public function onEnable() {
    if(!file_exists($this->getDataFolder() . "config.yml")) {
      @mkdir($this->getDataFolder());
      file_put_contents($this->getDataFolder() . "config.yml",$this->getResource("config.yml"));
    }
    $c = yaml_parse(file_get_contents($this->getDataFolder() . "config.yml"));
    $num = 0;
    $this->key = $c["API-Key"];
    $this->url = $c["Vote-URL"];
    $rewards = $c["Rewards"];
    foreach($rewards["Items"] as $i) {
      $r = explode(":",$i);
      $this->items[$num] = new Item($r[0],$r[1],$r[2]);
      $num++;
    }
    $num = 0;
    foreach($rewards["Commands"] as $i) {
      $this->commands[$num] = $i;
      $num++;
    }
  }
  public function onCommand(CommandSender $p,Command $cmd,$label,array $args) {
    if(!($p instanceof Player)) {
      $p->sendMessage("Command must be used in-game.");
      return true;
    }
    if($p->hasPermission("votereward") || $p->hasPermission("votereward.vote")) {
      $query = new QueryTask("http://minecraftpocket-servers.com/api/?object=votes&element=claim&key=" . $this->key . "&username=" . $p->getName(),$p->getName(),true);
      $this->getServer()->getScheduler()->scheduleAsyncTask($query);
    } else {
      $p->sendMessage("You do not have permission to vote.");
    }
    return true;
  }
  public function give(Player $p,$s) {
    if($s == "0") {
      $p->sendMessage("You haven't voted yet!\n" . $this->url . "\nVote now for cool rewards!");
    } else if($s == "1") {
      $query = new QueryTask("http://minecraftpocket-servers.com/api/?action=post&object=votes&element=claim&key=" . $this->key . "&username=" . $p->getName(),$p->getName(),false);
      $this->getServer()->getScheduler()->scheduleAsyncTask($query);
      foreach($this->items as $i) {
        $p->getInventory()->addItem($i);
      }
      foreach($this->commands as $i) {
        $this->getServer()->dispatchCommand(new ConsoleCommandSender(),str_replace("{PLAYER}",$p->getName(),$i));
      }
    } else if($s == "2") {
      $p->sendMessage("You've already voted today! Come back tomorrow to vote again.");
    } else {
      $this->getLogger()->warning(TextFormat::RED . "Error fetching vote status! Are you hosting your server on a mobile device, or is your Internet out?");
      $p->sendMessage("[VoteReward] Error fetching vote status!");
    }
  }
}
?>
