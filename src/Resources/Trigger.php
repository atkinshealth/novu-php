<?php

namespace Novu\SDK\Resources;

class Trigger extends Resource
{
    /**
     * If trigger was acknowledged or not
     * @var bool
     */
    public $acknowledged;

    /**
     * In case of an error, this field will contain the error message
     * @var string[]
     */
    public $error;

    /**
     * Status for trigger
     * @var string processed, trigger_not_active, subscriber_id_missing, error
     */
    public $status;

    /**
     * The transaction id for trigger.
     *
     * @var string
     */
    public $transactionId;

    /**
     * Return the array form of Trigger object.
     *
     * @return array
     */
    public function toArray(): array
    {
        $publicProperties = get_object_vars($this);

        unset($publicProperties['attributes']);
        unset($publicProperties['novu']);

        return array_filter($publicProperties, function ($value) {
            return null !== $value;
        });
    }
}
