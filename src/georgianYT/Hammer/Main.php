<?php

namespace georgianYT\Hammer;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {


    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label,array $args) : bool {
		switch($cmd->getName()){
			case "hammer":
				if($sender instanceof Player) {
					if($sender->hasPermission("hammer.give")){
						if(count($args) === 1){
							$playerName = $this->getServer()->getPlayerExact($args[0]);
							if($playerName instanceof Player){
								$cp = Item::get(257, 0, 1);
								$customcp = $cp->setCustomName(TextFormat::RED . "Hammer");
								$playerName->getInventory()->addItem($customcp);
							}
						}
					}
				} else {
					$sender->sendMessage(TextFormat::RED . "Use this Command in-game.");
					return true;
				}
			break;
		}
		return true;
    }
	
	
	public function onBlockBreak(BlockBreakEvent $event){
		$player = $event->getPlayer();
		$item = $event->getItem();
		$block = $event->getBlock();
		
		if($item->getId() == 257 && $item->getCustomName() == TextFormat::RED . "Hammer"){
			$level = $player->getLevel();
			for($count = 0; $count >= -2; $count--){
				$bpos = $level->getBlockIdAt($block->x + 1, $block->y + $count, $block->z);
				if($bpos != 7 && $bpos != 49){
					$level->setBlockIdAt($block->x + 1, $block->y + $count, $block->z, 0);
					$item = Item::get($bpos, 0, 1);	
					$level->dropItem(new Vector3($block->x + 1, $block->y + $count, $block->z), $item);
				}
				$bpos = $level->getBlockIdAt($block->x - 1, $block->y + $count, $block->z);
				if($bpos != 7 && $bpos != 49){
					$level->setBlockIdAt($block->x - 1, $block->y + $count, $block->z, 0);
					$item = Item::get($bpos, 0, 1);	
					$level->dropItem(new Vector3($block->x - 1, $block->y + $count, $block->z), $item);
				}
				$bpos = $level->getBlockIdAt($block->x - 1, $block->y + $count, $block->z + 1);
				if($bpos != 7 && $bpos != 49){
					$level->setBlockIdAt($block->x - 1, $block->y + $count, $block->z + 1, 0);
					$item = Item::get($bpos, 0, 1);	
					$level->dropItem(new Vector3($block->x - 1, $block->y + $count, $block->z + 1), $item);
				}
				$bpos = $level->getBlockIdAt($block->x, $block->y + $count, $block->z + 1);
				if($bpos != 7 && $bpos != 49){
					$level->setBlockIdAt($block->x, $block->y + $count, $block->z + 1, 0);
					$item = Item::get($bpos, 0, 1);	
					$level->dropItem(new Vector3($block->x, $block->y + $count, $block->z + 1), $item);
				}
				$bpos = $level->getBlockIdAt($block->x + 1, $block->y + $count, $block->z + 1);
				if($bpos != 7 && $bpos != 49){
					$level->setBlockIdAt($block->x + 1, $block->y + $count, $block->z + 1, 0);
					$item = Item::get($bpos, 0, 1);	
					$level->dropItem(new Vector3($block->x + 1, $block->y + $count, $block->z + 1), $item);
				}
				$bpos = $level->getBlockIdAt($block->x - 1, $block->y + $count, $block->z - 1);
				if($bpos != 7 && $bpos != 49){
					$level->setBlockIdAt($block->x - 1, $block->y + $count, $block->z - 1, 0);
					$item = Item::get($bpos, 0, 1);	
					$level->dropItem(new Vector3($block->x - 1, $block->y + $count, $block->z - 1), $item);
				}
				$bpos = $level->getBlockIdAt($block->x, $block->y + $count, $block->z - 1);
				if($bpos != 7 && $bpos != 49){
					$level->setBlockIdAt($block->x, $block->y + $count, $block->z - 1, 0);
					$item = Item::get($bpos, 0, 1);	
					$level->dropItem(new Vector3($block->x, $block->y + $count, $block->z - 1), $item);
				}
				$bpos = $level->getBlockIdAt($block->x + 1, $block->y + $count, $block->z - 1);
				if($bpos != 7 && $bpos != 49){
					$level->setBlockIdAt($block->x + 1, $block->y + $count, $block->z - 1, 0);
					$item = Item::get($bpos, 0, 1);	
					$level->dropItem(new Vector3($block->x + 1, $block->y + $count, $block->z - 1), $item);
				}
			}
			$bpos = $level->getBlockIdAt($block->x, $block->y - 1, $block->z);
			if($bpos != 7 && $bpos != 49){
				$level->setBlockIdAt($block->x, $block->y - 1, $block->z, 0);
				$item = Item::get($bpos, 0, 1);	
				$level->dropItem(new Vector3($block->x, $block->y - 1, $block->z), $item);
			}
			$bpos = $level->getBlockIdAt($block->x, $block->y - 2, $block->z);
			if($bpos != 7 && $bpos != 49){
				$level->setBlockIdAt($block->x, $block->y - 2, $block->z, 0);
				$item = Item::get($bpos, 0, 1);	
				$level->dropItem(new Vector3($block->x, $block->y - 2, $block->z), $item);
			}
		}
	}
	
	
}
