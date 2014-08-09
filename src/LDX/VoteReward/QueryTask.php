<?php

use pocketmine\Player;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class QueryTask extends AsyncTask{
    private $url, $data, $p, $ret;
    function __construct($url, $p, $ret){
        $this->url = $url;
        $this->p = $p;
        $this->ret = $ret;
    }
    public function onRun(){
        $this->data = file_get_contents($this->url);
    }
    public function onCompletion(Server $server){
        if($this->ret){
            if(($p = $server->getPlayer($this->p)) instanceof Player){
                $server->getPluginManager()->getPlugin("VoteReward")->give($p, $this->data);
            }
        }
    }
}