<?php

namespace Novu\SDK\Resources;

use Novu\SDK\Novu;

class SubscriptionPreference
{
    public Workflow $workflow;
    public Preference $preference;

    public function __construct($data, Novu $novu = null)
    {
        $this->workflow = new Workflow($data['template'], $novu);

        $this->preference = new Preference($data['preference']);
    }

    public function toArray(): array
    {
        return [
            'workflow' => $this->workflow->toArray(),
            'preference' => $this->preference->toArray()
        ];
    }
}
