<?php

namespace App\Controller;

use App\Entity\Actions\Feedings\BreastFeedingMethod;
use App\Entity\Actions\Feedings\Feeding;
use App\Entity\Actions\Feedings\FormulaFeedingMethod;
use App\Entity\Kid;
use App\Entity\States\Kid\Newborn;

class FeedingController
{
    public function feedUp(Kid $kid)
    {
        $kidState = $kid->getState();
        $feeding = new Feeding();

        if ($kidState instanceof Newborn) {
            $feeding->setFeedingMethod(new BreastFeedingMethod());
        } else {
            $feeding->setFeedingMethod(new FormulaFeedingMethod());
        }

        $feeding->execute();
    }
}