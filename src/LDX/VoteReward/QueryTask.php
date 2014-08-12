<?php
use pocketmine\Player;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
class QueryTask extends AsyncTask {
    function __construct($url,$p,$r) {
        $this->url = $url;
        $this->p = $p;
        $this->r = $r;
    }
    public function onRun() {
        $this->data = file_get_contents($this->url);
    }
    public function onCompletion(Server $server) {
        if($this->r) {
            $p = $server->getPlayer($this->p);
            if($p instanceof Player) {
                $server->getPluginManager()->getPlugin("VoteReward")->give($p,$this->data);
            }
        }
    }
}
?>
