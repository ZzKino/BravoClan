<?php

namespace Itzdvbravo\BravoClan\Forms\SubForms;

use pocketmine\Player;
use Itzdvbravo\BravoClan\Forms\ClanForm;
use Itzdvbravo\BravoClan\Main;
use onebone\economyapi\EconomyAPI;
use jojoe77777\FormAPI\CustomForm;

Class CreateSubForm extends CustomForm{

	/*** @var Player*/
	private $player;

	public function __construct(Player $player){
		$this->player = $player;
		$callable = $this->getCallable();
		parent::__construct($callable);
	}
	/**
	* @return void
	*/
	public function setForm() :void {
		$player = $this->player;
		$this->setTitle("Members Form");
		$clan = Main::$file->getClan(Main::$clan->player[strtolower($player->getName())]);
		$m = Main::$file->clanMembers($clan['clan']);
        foreach ($m as $person){
            $info = Main::$file->getMember($person);
            if (Main::getInstance()->isOnline($person)){
                $this->addLabel("§e{$person} [{$info['kills']}/{$info['deaths']}] [§aON§e]");
            } else {
                $this->addLabel("§e{$person} [{$info['kills']}/{$info['deaths']}] [§4OFF§e]");
            }
        }
	}

	/**
	* @return callable
	*/
	public function getCallable() :callable{
		$callable = function(Player $player, ?array $data){
			if(is_null($data)){
				$form = new ClanForm($player);
				$player->sendForm($form);
				return;
			}
		};
		return $callable;
	}
}