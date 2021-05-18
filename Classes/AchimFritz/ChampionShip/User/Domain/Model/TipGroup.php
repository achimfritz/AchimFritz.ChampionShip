<?php
namespace AchimFritz\ChampionShip\User\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A TipGroup
 *
 * @Flow\Entity
 */
class TipGroup
{
    
    /**
     * The name
     * @var string
     * @Flow\Identity
     * @Flow\Validate(type="NotEmpty")
     */
    protected $name;

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * setName
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
