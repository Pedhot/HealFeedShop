<?php

namespace pedhot\HFShop;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as C;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;

use onebone\economyapi\EconomyAPI;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {
	
	public function onEnable(){
        @eval(base64_decode("JHRoaXMtPmdldExvZ2dlcigpLT5pbmZvKEM6OkdSRUVOIC4gIltFbmFibGVkXSBQbHVnaW4gSGVhbEZlZWRTaG9wIEJ5IFBlZGhvdCIpOw=="));
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
	
	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
		switch($command->getName()){
			case "hfshop":
			if($sender instanceof Player){
	     		$this->onHFShop($sender);
				return true;
			}else{
				$sender->sendMessage(T::RED . "Run this command in game");
				return true;
			}
		}
	}
	
	public function onHFShop($sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $sender, int $data = null) {
			$result = $data;
            if($result === null){
                return true;
            }             
            switch($result){
				case 0:
				$sender->sendMessage(C::RED . "Cancelled");
				break;
				case 1:
				$this->onHeal($sender);
				break;
				case 2:
				$this->onFeed($sender);
				break;
			}
		});
		$name = $sender->getName();
		$economy = EconomyAPI::getInstance();
        $mymoney = $economy->myMoney($sender);
		$heal = $this->getConfig()->get("heal");
		$feed = $this->getConfig()->get("feed");
		$form->setTitle(C::GREEN . "HealFeedShop");
		$form->setContent("§aHii $name\n\n§echoose what you want\n§eYour money: $mymoney");
		$form->addButton("§cExit\n§fTap to Exit", 0, "textures\ui\cancel");
		$form->addButton("§l§aInstant Heal\n§e$heal");
		$form->addButton("§l§aInstant Food\n§e$food");
	}
	
	public function onHeal(Player $py) {
		$economy = EconomyAPI::getInstance();
        $mymoney = $economy->myMoney($py);
        $irn = $this->getConfig()->get("heal");
        $name = $py->getName();
        if($mymoney >= $irn){
          	$economy->reduceMoney($py, $irn);
			$py->setHealth(20);
		}else{
			$py->sendMessage("§cNo enough money!");
		}
    }
	
	public function onFeed(Player $py) {
		$economy = EconomyAPI::getInstance();
        $mymoney = $economy->myMoney($py);
        $irn = $this->getConfig()->get("feed");
        $name = $py->getName();
        if($mymoney >= $irn){
          	$economy->reduceMoney($py, $irn);
			$py->setFood(20);
		}else{
			$py->sendMessage("§cNo enough money!");
		}
    }
	
}
