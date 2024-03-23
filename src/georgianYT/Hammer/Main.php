<?php

namespace georgianYT\Hammer;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\DiamondPickaxe;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
        switch ($cmd->getName()) {
            case "hammer":
                if ($sender instanceof Player) {
                    if (count($args) === 1 && $sender->hasPermission("hammer.give")) {
                        $playerName = $this->getServer()->getPlayerExact($args[0]);
                        if ($playerName instanceof Player) {
                            $hammer = new DiamondPickaxe();
                            $hammer->setCustomName(TextFormat::RED . "Hammer");
                            $playerName->getInventory()->addItem($hammer);
                            return true;
                        } else {
                            $sender->sendMessage(TextFormat::RED . "Player not found.");
                        }
                    } else {
                        $sender->sendMessage(TextFormat::RED . "Usage: /hammer <player>");
                    }
                } else {
                    $sender->sendMessage(TextFormat::RED . "Use this command in-game.");
                }
                break;
        }
        return false;
    }

    public function onBlockBreak(BlockBreakEvent $event){
        $player = $event->getPlayer();
        $item = $event->getItem();
        $block = $event->getBlock();

        if($item instanceof DiamondPickaxe && $item->getCustomName() === TextFormat::RED . "Hammer"){
            $level = $player->getLevel();
            for($count = 0; $count >= -2; $count--){
                $bpos = $level->getBlockIdAt($block->x + 1, $block->y + $count, $block->z);
                if($bpos !== Item::BEDROCK && $bpos !== Item::OBSIDIAN){
                    $level->setBlockIdAt($block->x + 1, $block->y + $count, $block->z, Item::AIR);
                    $item = Item::get($bpos, 0, 1);  
                    $level->dropItem(new Vector3($block->x + 1, $block->y + $count, $block->z), $item);
                }
                // Repeat similar checks for other adjacent blocks
                // ...
            }
            // Additional actions for breaking blocks below
            $bpos = $level->getBlockIdAt($block->x, $block->y - 1, $block->z);
            if($bpos !== Item::BEDROCK && $bpos !== Item::OBSIDIAN){
                $level->setBlockIdAt($block->x, $block->y - 1, $block->z, Item::AIR);
                $item = Item::get($bpos, 0, 1);  
                $level->dropItem(new Vector3($block->x, $block->y - 1, $block->z), $item);
            }
            $bpos = $level->getBlockIdAt($block->x, $block->y - 2, $block->z);
            if($bpos !== Item::BEDROCK && $bpos !== Item::OBSIDIAN){
                $level->setBlockIdAt($block->x, $block->y - 2, $block->z, Item::AIR);
                $item = Item::get($bpos, 0, 1);  
                $level->dropItem(new Vector3($block->x, $block->y - 2, $block->z), $item);
            }
        }
    }
}
