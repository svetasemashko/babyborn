<?php

namespace App\Entity\Actions\Feedings;

use App\Entity\Actions\AbstractAction;

// Context
class Feeding extends AbstractAction
{
    private FeedingMethod $method;

    public function setFeedingMethod(FeedingMethod $method)
    {
        $this->method = $method;
    }

    public function execute()
    {
        $this->method->feedUp();
    }
}