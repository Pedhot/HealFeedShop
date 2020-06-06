<?php

namespace AnjayMabar;

use jojoe77777\FormAPI\FormAPI;
use Zedstar16\OnlineTime\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as T;

class Main extends PluginBase implements Listener{
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch($cmd->getName()){                    
            case "otui":
                if($sender instanceof Player){
                    $this->top($sender);
                }else{
                    $sender->sendMessage("§cGunakan Command Dalam Game!");
                } 
                break;
        }
        return true;
    }
	
	public function top(Player $player){
		$online = $this->main->getServer()->getPluginManager()->getPlugin("OnlineTime");
		$online_top = $online->getTotalTime();
		$message = "";
		if(count($online_top) > 0){
			arsort($online_top);
			$i = 1;
			foreach($online_top as $name => $online){
				$message .= "§f" . $i . ". " . $name . ":    " . $online . " §a\n";
				if($i >= 10){
					break;
				}
				++$i;
			}
		}
		$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null){
			$result = $data;
			if($result === null){
				return true;
			}
			switch($result){
				case 0;
				break;
			}
	    });
		$form->setTitle(T::GREEN . "Top 10 Online Player");
		$form->setContent("".$message);
        $form->addButton("Submit");
		$form->sendToPlayer($player);
		return $form;
	}
	
}