<?php

namespace Novu\SDK\Resources;

class Preference extends Resource
{

    /**
     * Whether the workflow as a whole is enabled
     *
     * @var bool
     */
    public $enabled;

    /**
     * Individual channel enabling preferences
     *
     * @var array
     */
    public $channels;

    /**
     * Some complicated thing that's not fully explained by the docs
     *
     * @var array
     */
    public $overrides;



    /**
     * Return the array form of Preference object.
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
