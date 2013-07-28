<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use AchimFritz\ChampionShip\Domain\Model\GroupRound;

/**
 * A Match
 *
 * @Flow\Entity
 */
class CrossGroupRoundMatch extends KoMatch {

   /**
    * @var \AchimFritz\ChampionShip\Domain\Model\GroupRound
    * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
    */
   protected $winnerOfGroupRound;

   /**
    * @var \AchimFritz\ChampionShip\Domain\Model\GroupRound
    * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
    */
   protected $semiWinnerOfGroupRound;

   /**
    * getWinnerOfGroupRound 
    * 
    * @return GroupRound winnerOfGroupRound
    */
   public function getWinnerOfGroupRound() {
      return $this->winnerOfGroupRound;
   }

   /**
    * setWinnerOfGroupRound
    * 
    * @param GroupRound $winnerOfGroupRound
    * @return void
    */
   public function setWinnerOfGroupRound(GroupRound $winnerOfGroupRound) {
      $this->winnerOfGroupRound = $winnerOfGroupRound;
   } 

   /**
    * getSemiWinnerOfGroupRound 
    * 
    * @return GroupRound semiWinnerOfGroupRound
    */
   public function getSemiWinnerOfGroupRound() {
      return $this->semiWinnerOfGroupRound;
   }

   /**
    * setSemiWinnerOfGroupRound
    * 
    * @param GroupRound $semiWinnerOfGroupRound
    * @return void
    */
   public function setSemiWinnerOfGroupRound(GroupRound $semiWinnerOfGroupRound) {
      $this->semiWinnerOfGroupRound = $semiWinnerOfGroupRound;
   } 

}
?>
