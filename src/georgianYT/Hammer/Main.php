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
                            $cp = Item::get(257, 0, 1);
                            $customcp = $cp->setCustomName(TextFormat::RED . "Hammer");
                            $playerName->getInventory()->addItem($customcp);
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

    public function onBlockBreak(BlockBreakEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $block = $event->getBlock();

        if ($item->getId() === Item::DIAMOND_PICKAXE && $item->getCustomName() === TextFormat::RED . "Hammer") {
            $level = $player->getLevel();
            for ($count = 0; $count >= -2; $count--) {
                for ($x = -1; $x <= 1; $x++) {
                    for ($z = -1; $z <= 1; $z++) {
                        $bpos = $level->getBlockIdAt($block->x + $x, $block->y + $count, $block->z + $z);
                        if ($bpos !== Block::AIR && $bpos !== Block::BEDROCK) {
                            $level->setBlockIdAt($block->x + $x, $block->y + $count, $block->z + $z, 0);
                            $item = Item::get($bpos, 0, 1);
                            $level->dropItem(new Vector3($block->x + $x, $block->y + $count, $block->z + $z), $item);
                        }
                    }
                }
            }
        }
    }
}
