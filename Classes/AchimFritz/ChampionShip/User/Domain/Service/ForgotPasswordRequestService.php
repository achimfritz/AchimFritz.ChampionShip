<?php
namespace AchimFritz\ChampionShip\User\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\ForgotPasswordRequest;
use TYPO3\Flow\Mvc\ActionRequest;
use TYPO3\Flow\Utility\Algorithms as UtilityAlgorithms;
/**
 * @Flow\Scope("singleton")
 */
class ForgotPasswordRequestService  {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @var \AchimFritz\ChampionShip\Service\NotificationService
	 * @Flow\Inject
	 */
	protected $notificationService;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\ForgotPasswordRequestRepository
	 */
	protected $forgotPasswordRequestRepository;

	/**
	 * @param ForgotPasswordRequest $forgotPasswordRequest
	 * @param ActionRequest $actionRequest
	 * @return ForgotPasswordRequest
	 */
	public function finish(ForgotPasswordRequest $forgotPasswordRequest, ActionRequest $actionRequest) {
		if ($forgotPasswordRequest->getEmail() !== NULL) {
			$users = $this->userRepository->findByEmail($forgotPasswordRequest->getEmail());
			foreach ($users as $user) {
				$request = clone($forgotPasswordRequest);
				$request->setUser($user);
				$token = UtilityAlgorithms::generateRandomToken(40);
				$request->setHash($token);
				$this->forgotPasswordRequestRepository->add($request);
				$this->notificationService->forgotPasswordRequest($request, $actionRequest);
			}
		}
		return $forgotPasswordRequest;
	}


}
