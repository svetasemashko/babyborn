<?php

namespace App\Entity\Actions\Feedings;

use App\Entity\Actions\AbstractAction;
use App\Entity\States\Kid\Newborn;
use App\Entity\States\Kid\State;

// Context
class Feeding extends AbstractAction
{
    private FeedingMethod $method;

    public function __construct(
        private State $state
    ) {}

    public function setFeedingMethod()
    {
        if ($this->state instanceof Newborn) {
            $this->method = new BreastFeedingMethod();
        } else {
            $this->method = new FormulaFeedingMethod();
        }
    }

    public function execute()
    {
        $this->setFeedingMethod();
        $this->method->feedUp();
    }
}