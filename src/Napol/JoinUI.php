<?php

namespace Napol;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Napol\JoinUITask;
use pocketmine\utils\TextFormat;

class JoinUI extends PluginBase implements Listener{

  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
     @mkdir($this->getDataFolder());  
    $this->Config = new Config($this->getDataFolder()."license.yml", Config::YAML,[
        "Your License Number" => "......."    
        ]);  
    $this->Config->save(); 
    $this->Config->reload();                      
        $this->getLogger()->info(TextFormat::YELLOW . "Checking data....");            
     if($this->Config->get("Your License Number") == "a1a2s3d4"){
         $this->getLogger()->info(TextFormat::GREEN . "Allowed to use plugin");     
    $this->Eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");  
     }else{
        $this->getLogger()->info(TextFormat::RED . "Not allowed to use plugin");
        $this->getPluginLoader()->disablePlugin($this);
     }   

    public function onDisable() : void{
        $this->getServer()->getLogger()->alert(TextFormat::RED . "§aJoinUI §cClosed!");
    }

    public function configmakerthingy() : void{
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    public function onJoin(PlayerJoinEvent $event) : void{
        $player = $event->getPlayer();
        $this->getServer()->getScheduler()->scheduleDelayedTask(new JoinUITask($this, $player), 40);
    }
}
