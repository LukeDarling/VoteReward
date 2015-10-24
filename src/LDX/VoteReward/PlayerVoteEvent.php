<?php

namespace LDX\VoteReward;

use LDX\VoteReward\Main as VoteReward;
use pocketmine\event\plugin\PluginEvent;
use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerVoteEvent extends PluginEvent implements Cancellable {

  public static $handlerList = null;
  protected $player;

  public function __construct(VoteReward $plugin,Player $player,$data) {
    parent::__construct($plugin);
    $this->player = $player;
  }
}
