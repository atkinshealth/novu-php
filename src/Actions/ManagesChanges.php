<?php

namespace Novu\SDK\Actions;

use Novu\SDK\Resources\Change;
use Novu\SDK\Resources\Paginated;

trait ManagesChanges
{

    /**
     * Get Changes
     *
     * @return Paginated<\Novu\SDK\Resources\Change>
     */
    public function getChanges(array $queryParams)
    {
        $uri = "changes";

        if(! empty($queryParams)) {
            $uri .= '?' . http_build_query($queryParams);
        }

        $response = $this->get($uri);

        $response['data'] = array_map(fn ($value) => new Change($value, $this), $response['data']);
        return new Paginated($response);
    }

    /**
     * Get Changes Count
     *
     * @return int
     */
    public function getChangesCount()
    {
        $response = $this->get("changes/count")['data'];

        return $response;
    }

    /**
     * Apply Bulk Changes
     *
     * @return \Novu\SDK\Resources\Change[]
     */
    public function applyBulkChanges(array $data)
    {
        $response = $this->post("changes/bulk/apply", $data)['data'];

        return array_map(fn ($value) => new Change($value, $this), $response);
    }

    /**
     * Apply Change
     *
     * @param string $changeId
     * @return \Novu\SDK\Resources\Change
     */
    public function applyChange($changeId, array $data)
    {
        $response = $this->post("changes/{$changeId}/apply", $data)['data'];

        return new Change($response, $this);
    }

}
