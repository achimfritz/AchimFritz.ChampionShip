<?php
namespace AchimFritz\ChampionShip\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\User\Domain\Model\ForgotPasswordRequest;
use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\User;
use AchimFritz\ChampionShip\User\Domain\Model\RegistrationRequest;
use AchimFritz\ChampionShip\User\Domain\Model\ContactRequest;
use Neos\Flow\Mvc\ActionRequest;
use Neos\Flow\Mvc\Routing\UriBuilder;
use Neos\SwiftMailer\Message;

/**
 * A NotificationService
 *
 * @Flow\Scope("singleton")
 */
class NotificationService
{

    /**
     * @var array
     */
    protected $settings;

    /**
     * @var \Neos\Flow\ObjectManagement\ObjectManagerInterface
     * @Flow\Inject
     */
    protected $objectManager;

    /**
     * injectSettings
     *
     * @param array $settings
     * @return void
     */
    public function injectSettings($settings)
    {
        $this->settings = $settings;
    }
    
    /**
     * inviteUser
     *
     * @param User $user
     * @return void
     */
    public function inviteUser(User $user)
    {
        $from = $this->settings['mailFrom'];
        $to = $user->getEmail();

        $subject = 'Einladung: Tippen bis zum Anpfiff bei www.tipptrip.de';
        $body = 'Am 20.11.2022 ist es wieder soweit: Es wird WM-Geschichte geschrieben!!! '. chr(10) . chr(10);
        $body .= 'Du bist natürlich automatisch wieder bei www.tipptrip.de dabei.' . chr(10) . chr(10);
        $body .= 'Deine Zugangsdaten:' . chr(10);
        $body .= 'URL: https://www.tipptrip.de/' . chr(10);
        $body .= 'Username: ' . $user->getUsername() . chr(10). chr(10);
        $body .= 'Viel Spass wünscht Dir,' . chr(10);
        $body .= 'das www.tipptrip.de-Team';

        $mailMessage = $this->objectManager->get('Neos\SwiftMailer\Message');
        $mailMessage->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->send();
    }
    
    /**
     * registrationFinished
     *
     * @param User $user
     * @return void
     */
    public function registrationFinished(User $user)
    {
        $from = $this->settings['mailFrom'];
        $to = $user->getEmail();

        $subject = 'Registrierung www.tipptrip.de';
        $body = 'Deine Registrierung wurde erfolgreich abgeschlossen' . chr(10) . chr(10);
        $body .= 'Deine Zugangsdaten:' . chr(10);
        $body .= 'URL: https://www.tipptrip.de/' . chr(10);
        $body .= 'Username: ' . $user->getUsername() . chr(10);
        $body .= 'Dein Passwort: **********' . chr(10) . chr(10);
        $body .= 'Viel Spass wünscht Dir,' . chr(10);
        $body .= 'das www.tipptrip.de-Team';

        $mailMessage = $this->objectManager->get('Neos\SwiftMailer\Message');
        $mailMessage->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->send();
    }

    /**
     * @param ForgotPasswordRequest $forgotPasswordRequest
     * @param ActionRequest $actionRequest
     * @return void
     */
    public function forgotPasswordRequest(ForgotPasswordRequest $forgotPasswordRequest, ActionRequest $actionRequest)
    {
        $uriBuilder = new UriBuilder();
        $uriBuilder->reset()->setRequest($actionRequest);
        $uriBuilder->setCreateAbsoluteUri(true);
        $url = $uriBuilder->uriFor('index', array('hash' => $forgotPasswordRequest->getHash()), 'passwordRequest', 'AchimFritz.ChampionShip', 'User');

        $from = $this->settings['mailFrom'];
        $to = $forgotPasswordRequest->getUser()->getEmail();

        $subject = 'Passwort zurücksetzen / www.tipptrip.de';
        $body = 'hier kannst du Dein Passwort zurücksetzen:' . chr(10) . chr(10);
        $body .= $url . chr(10) . chr(10);
        $body .= 'Username: ' . $forgotPasswordRequest->getUser()->getUsername() . chr(10). chr(10);
        $body .= 'Viel Spass wünscht Dir,' . chr(10);
        $body .= 'das www.tipptrip.de-Team';
        $mailMessage = new Message();
        $mailMessage->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->send();
    }

    /**
     * registrationStarted
     *
     * @param User $user
     * @return void
     */
    public function registrationStarted(RegistrationRequest $registrationRequest)
    {
        $from = $this->settings['mailFrom'];
        $to = $registrationRequest->getEmail();

        $subject = 'Registrierung www.tipptrip.de';
        $body = 'Deine Registrierung wurde erfolgreich angelegt' . chr(10);
        $body .= 'Der Administrator wird Deine Daten prüfen und sich dann bei Dir melden' . chr(10) . chr(10);
        $body .= 'URL: https://www.tipptrip.de/' . chr(10) . chr(10);
        $body .= 'Viel Spass wünscht Dir,' . chr(10);
        $body .= 'das www.tipptrip.de-Team';

        $mailMessage = $this->objectManager->get('Neos\SwiftMailer\Message');
        $mailMessage->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->send();

        $to = $this->settings['mailTo'];
        $subject = 'registration start';
        $body = 'the user ' . $registrationRequest->getUsername() . ' / ' . $registrationRequest->getEmail() . ' has start a registration request';

        $mailMessage = $this->objectManager->get('Neos\SwiftMailer\Message');
        $mailMessage->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->send();
    }

    /**
     * contactStarted
     *
     * @param User $user
     * @return void
     */
    public function contactStarted(ContactRequest $contactRequest)
    {
        $from = $this->settings['mailFrom'];
        $to = $contactRequest->getEmail();

        $subject = 'Kontakt Anfrage www.tipptrip.de';
        $body = 'Deine Kontakt Anfrage ist bei uns eingegangen' . chr(10);
        $body .= 'Der Administrator wird Deine Daten prüfen und sich dann bei Dir melden' . chr(10) . chr(10);
        $body .= 'URL: https://www.tipptrip.de/' . chr(10) . chr(10);
        $body .= 'Viel Spass wünscht Dir,' . chr(10);
        $body .= 'das www.tipptrip.de-Team';

        $mailMessage = new Message();
        $mailMessage->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->send();

        $to = $this->settings['mailTo'];
        $subject = 'contact request';
        $body = 'the user ' . $contactRequest->getEmail() . ' has start a contact request';

        $mailMessage = new Message();
        $mailMessage->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->send();
    }
}
