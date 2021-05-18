<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Tip
 *
 * @Flow\Entity
 */
class TipGroupResultMatrix
{

    /**
     * @var array<\AchimFritz\ChampionShip\User\Domain\Model\User>
     * @ORM\ManyToMany
     */
    protected $users;

    /**
     * @var array<\AchimFritz\ChampionShip\Tip\Domain\Model\TipGroupResultMatrixRow>
     * @ORM\ManyToMany
     */
    protected $rows;

    /**
     * setUsers
     *
     * @param array<\AchimFritz\ChampionShip\User\Domain\Model\User>
     * @return void
     */
    public function setUsers($users)
    {
        $this->users= $users;
    }

    /**
     * getUsers
     *
     * @return array<\AchimFritz\ChampionShip\User\Domain\Model\User>
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * setRows
     *
     * @param array
     * @return void
     */
    public function setRows($rows)
    {
        $this->rows= $rows;
    }

    /**
     * getRows
     *
     * @return array
     */
    public function getRows()
    {
        return $this->rows;
    }
}
