<?php

namespace georgianYT\Hammer;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\VanillaItems;
use pocketmine\item\Item;
use pocketmine\item\Tool;
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
                            $hammer = VanillaItems::DIAMOND_PICKAXE(); //Use the class VanillaItems
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

    public function onBlockBreak(BlockBreakEvent $event) {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $block = $event->getBlock();

        if ($item instanceof Tool && $item->getCustomName() === TextFormat::RED . "Hammer") {
            $world = $block->getPosition()->getWorld();
            $radius = 1; // 3x3 hole, so radius is 1 block in each direction
            for ($x = -$radius; $x <= $radius; $x++) {
                for ($z = -$radius; $z <= $radius; $z++) {
                    $pos = $block->getPosition()->add($x, 0, $z);
                    $bpos = $world->getBlockAt($pos->x, $pos->y, $pos->z)->getTypeId();
                    if ($bpos !== VanillaBlocks::BEDROCK()->getTypeId() && $bpos !== VanillaBlocks::OBSIDIAN()->getTypeId()) {
                        $world->setBlockAt($pos->x, $pos->y, $pos->z, VanillaBlocks::AIR()->getTypeId());
                        $world->dropItem($pos, $bpos);
                    }
                }
            }
        }
    }
}
