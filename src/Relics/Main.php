<?php

namespace Relics;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener
{


    public function onEnable()
    {

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
        $this->getServer()->getLogger()->notice(TF::AQUA . TF::BOLD . "Relics" . TF::RESET . TF::GRAY . " has been loaded! Plugin by DuooIncc");
        $this->getServer()->getLogger()->notice(TF::GRAY . "Github: https://github.com/DuooIncc");
        $this->getServer()->getLogger()->notice(TF::GRAY . "Twitter: https://twitter.com/duooincurr");

    }

    public function onDisable()
    {

        $this->getServer()->getLogger()->warning(TF::AQUA . TF::BOLD . "Relics" . TF::RESET . TF::GRAY . "has been unloaded!");

    }

    public function onBreak(BlockBreakEvent $event)
    {
        //////////////////////// Relic ////////////////////////

        if ($event->getBlock()->getId() == 1) {

            if (mt_rand(1, 500) === 10) {

                $player = $event->getPlayer();
                $name = $player->getName();

                $tier1 = Item::get(Item::NETHER_STAR, 0, 1);
                $tier1->setCustomName(TF::RESET . TF::GOLD . TF::BOLD . "Common Relic" . TF::RESET . TF::GRAY . " (Click)" . PHP_EOL .
                    TF::GRAY . " * " . TF::GREEN . "A treasure found by mining" . PHP_EOL .
                    TF::GRAY . " * " . TF::GREEN . "Tap anywhere to see what it holds");

                $player->getInventory()->addItem($tier1);
                $player->addtitle(TF::GOLD . "Relic Found!!", TF::GREEN . TF::BOLD . "Wonder what's inside?" . TF::RESET);
                $this->getServer()->broadcastMessage(TF::RED . TF::BOLD . "(!) " . TF::RESET . TF::GREEN . $name . TF::GRAY . " has found a " . TF::GOLD . TF::BOLD . "Common Relic");

                if (mt_rand(1, 5000) === 10) {

                    $player = $event->getPlayer();
                    $name = $player->getName();

                    $tier2 = Item::get(Item::NETHER_STAR, 0, 1);
                    $tier2->setCustomName(TF::RESET . TF::GOLD . TF::BOLD . "Uncommon Relic" . TF::RESET . TF::GRAY . " (Click)" . PHP_EOL .
                        TF::GRAY . " * " . TF::GREEN . "A treasure found by mining" . PHP_EOL .
                        TF::GRAY . " * " . TF::GREEN . "Tap anywhere to see what it holds");

                    $player->getInventory()->addItem($tier2);
                    $player->addtitle(TF::GOLD . "Relic Found!!", TF::GREEN . TF::BOLD . "Wonder what's inside?" . TF::RESET);
                    $this->getServer()->broadcastMessage(TF::RED . TF::BOLD . "(!) " . TF::RESET . TF::GREEN . $name . TF::GRAY . " has found an " . TF::GOLD . TF::BOLD . "Uncommon Relic");

                }
            }
        }
    }

    //////////////////////// Open Relic ////////////////////////

    public function onTap(PlayerInteractEvent $event){

        $player = $event->getPlayer();
        $item = $player->getInventory()->getItemInHand();
        $give = $player->getInventory()->addItem();

        if ($item->getName() == TF::RESET . TF::GOLD . TF::BOLD . "Common Relic" . TF::RESET . TF::GRAY . " (Click)" . PHP_EOL .
            TF::GRAY . " * " . TF::GREEN . "A treasure found by mining" . PHP_EOL .
            TF::GRAY . " * " . TF::GREEN . "Tap anywhere to see what it holds") {

                foreach ($this->getConfig()->get("relic-loot") as $rewards) {

                    if($item instanceof PlayerInteractEvent)
                    $give = $player->getInventory()->addItem(Item::get($rewards(0,mt_rand($this->getConfig()->get("relic-max")))));
                    $this->getServer()->getScheduler()->scheduleDelayedTask($give, 100);
                    
        if ($item->getName() == TF::RESET . TF::GOLD . TF::BOLD . "Uncommon Relic" . TF::RESET . TF::GRAY . " (Click)" . PHP_EOL .
            TF::GRAY . " * " . TF::GREEN . "A treasure found by mining" . PHP_EOL .
            TF::GRAY . " * " . TF::GREEN . "Tap anywhere to see what it holds") {

                foreach ($this->getConfig()->get("relic-loot") as $rewards) {

                    if($item instanceof PlayerInteractEvent)
                    $give = $player->getInventory()->addItem(Item::get($rewards(0,mt_rand($this->getConfig()->get("relic-max")))));
                    $this->getServer()->getScheduler()->scheduleDelayedTask($give, 100);
                    }
                }
            }
        }
    }
