<?php
namespace AchimFritz\ChampionShip\Import\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip.Import".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\RestController;
use AchimFritz\ChampionShip\Import\Domain\Model\Match;


class KoMatchController extends RestController {

   /**
    * @var string
    */
   protected $resourceArgumentName = 'match';

   /**
    * @var AchimFritz\ChampionShip\Import\Domain\Factory\CupFactory
    * @Flow\Inject
    */
   protected $cupFactory;

   /**
    * @var AchimFritz\ChampionShip\Import\Domain\Factory\KoRoundFactory
    * @Flow\Inject
    */
   protected $koRoundFactory;

   /**
    * @var AchimFritz\ChampionShip\Import\Domain\Factory\KoMatchFactory
    * @Flow\Inject
    */
   protected $koMatchFactory;

   /**
    * @var array
    */
   protected $supportedMediaTypes = array('text/html', 'application/json', 'application/xml');

   /**
    * listAction 
    * 
    * @return void
    */
   public function listAction() {
      $contentType = $this->request->getHttpRequest()->getNegotiatedMediaType($this->supportedMediaTypes);
      if ($contentType === 'application/json') {
         return json_encode(array('foo' => 'bar'));
      }
      return $contentType;
   }


   /**
    * updateAction 
    * 
    * @param AchimFritz\ChampionShip\Import\Domain\Model\Match $match 
    * @return void
    */
   public function updateAction(Match $match) {
      try {
         $cup = $this->cupFactory->createFromMatch($match, array());

			$koRound = $this->koRoundFactory->createFromMatch($match, array(), $cup);
			$koMatch = $this->koMatchFactory->createFromKoMatch($match, $cup, $koRound);
      } catch (\Exception $e) {
         return json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode(), 'class' => get_class($e)));
      }
      $contentType = $this->request->getHttpRequest()->getNegotiatedMediaType($this->supportedMediaTypes);
      if ($contentType === 'application/json') {
			return json_encode(array('message' => 'OK ' . $match->getHomeTeam() . ' - ' . $match->getGuestTeam()));

      }
      return $contentType;
   }

      /**
    * resolveViewObjectName
    * 
    * @return void
    */
   protected function resolveViewObjectName() {
      $contentType = $this->request->getHttpRequest()->getNegotiatedMediaType($this->supportedMediaTypes);
      $format = $this->request->getFormat();
      if ($contentType === 'application/xml' OR $format === 'xml') {
         $this->request->setFormat('xml');
         $this->response->setHeader('Content-Type', 'application/xml');
         return parent::resolveViewObjectName();
      } elseif ($contentType === 'application/json' OR $format === 'json') {
         $this->request->setFormat('json');
         $this->response->setHeader('Content-Type', 'application/json');
         return parent::resolveViewObjectName();
         #return 'TYPO3\\Flow\\Mvc\\View\\JsonView';
      } else {
         return parent::resolveViewObjectName();
      }
   }

}

?>
