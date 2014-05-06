<?php
namespace AchimFritz\ChampionShip\Security;

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\Tip;

/**
 * PolicyAspect 
 * 
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class PolicyAspect extends \AchimFritz\ChampionShip\Exception {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Policy\TipEditablePolicy
	 */
	protected $tipEditablePolicy;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Policy\UserEditablePolicy
	 */
	protected $userEditablePolicy;

	/**
	 * tipIsEditable 
	 * 
	 * @param \TYPO3\Flow\AOP\JoinPointInterface $joinPoint
	 * @throws Exception
	 * @return void
	 * @Flow\Before("method(AchimFritz\ChampionShip\Domain\Repository\TipRepository->update()) || method(AchimFritz\ChampionShip\Domain\Repository\TipRepository->add())")
	 */
	public function tipIsEditable(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint) {
		$tip = $joinPoint->getMethodArgument('object');
		if ($this->tipEditablePolicy->editAllowed($tip) === FALSE) {
			throw new \Exception('tip is not editable', 1398952499);
		}
	}

	/**
	 * userIsEditable 
	 * 
	 * @param \TYPO3\Flow\AOP\JoinPointInterface $joinPoint
	 * @throws Exception
	 * @Flow\Before("method(AchimFritz\ChampionShip\Domain\Repository\UserRepository->update())")
	 * @return void
	 */
	public function userIsEditable(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint) {
		$user = $joinPoint->getMethodArgument('object');
		if ($this->userEditablePolicy->editAllowed($user) === FALSE) {
			throw new \Exception('user is not editable', 1398952500);
		}
	}

}

?>
