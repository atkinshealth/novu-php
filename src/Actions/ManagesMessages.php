<?php

namespace Novu\SDK\Actions;

use Novu\SDK\Resources\Message;
use Novu\SDK\Resources\Paginated;

trait ManagesMessages
{

    /**
     * Get Messages
     *
     * @param array $queryParams
     * @return Paginated<Message>
     */
    public function getMessages(array $queryParams = [])
    {
        $response = $this->get("messages", $queryParams);
        $response['data'] = array_map(fn ($value) => new Message($value, $this), $response['data']);
        return new Paginated($response);
    }

    /**
     * Delete Message
     *
     * @param string $messageId
     * @return \Novu\SDK\Resources\Message
     */
    public function deleteMessage($messageId)
    {
        $response = $this->delete("messages/{$messageId}")['data'];

        return new Message($response, $this);
    }

}
