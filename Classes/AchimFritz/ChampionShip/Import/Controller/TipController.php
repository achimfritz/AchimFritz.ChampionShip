<?php
namespace AchimFritz\ChampionShip\Import\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip.Import".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\RestController;
use AchimFritz\ChampionShip\Import\Domain\Model\Match;
use AchimFritz\ChampionShip\Import\Domain\Model\Tip;


class TipController extends RestController {

   /**
    * @var AchimFritz\ChampionShip\Import\Domain\Factory\TipFactory
    * @Flow\Inject
    */
   protected $tipFactory;

   /**
    * @var string
    */
   protected $resourceArgumentName = 'tip';

   /**
    * @var array
    */
   protected $supportedMediaTypes = array('text/html', 'application/json', 'application/xml');


   /**
    * updateAction 
    * 
    * @param AchimFritz\ChampionShip\Import\Domain\Model\Tip $tip
    * @return void
    */
   public function updateAction(Tip $tip) {
      try {
			$newTip = $this->tipFactory->createFromTip($tip);
      } catch (\Exception $e) {
			return json_encode(array('message' => 'ERROR ' . $tip->getHomeTeam() . ' - ' . $tip->getGuestTeam() . ' - ' . $e->getMessage()));
         #return json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode(), 'class' => get_class($e)));
      }
      $contentType = $this->request->getHttpRequest()->getNegotiatedMediaType($this->supportedMediaTypes);
      if ($contentType === 'application/json') {
			return json_encode(array('message' => 'OK ' . $tip->getHomeTeam() . ' - ' . $tip->getGuestTeam() . ' - ' . $newTip->getUser()->getDisplayName()));
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
