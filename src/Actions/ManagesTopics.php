<?php

namespace Novu\SDK\Actions;

use Novu\SDK\Resources\Topic;

trait ManagesTopics
{
    /**
     * Create a new topic.
     *
     * @param  array $data
     * @return \Novu\SDK\Resources\Topic
     */
    public function createTopic(array $data)
    {
        $topic = $this->post("topics", $data)['data'];

        return new Topic($topic, $this);
    }

    /**
     * Fetch one topic
     *
     * @param  string $topicId
     * @return \Novu\SDK\Resources\Topic
     */
    public function getTopics(array $queryParams = [])
    {
        $uri = 'topics';

        if (!empty($queryParams)) {
            $uri .= '?' . http_build_query($queryParams);
        }

        $response = $this->get($uri);
        $response['data'] = array_map(fn ($value) => new Topic($value, $this), $response['data']);
        return $response;
    }

    /**
     * Add Subscribers to Topic
     *
     * @param  string $topicKey
     * @param  array  $data
     * @return void
     */
    public function addSubscribersToTopic($topicKey, array $data)
    {
        return $this->post("topics/{$topicKey}/subscribers", ['subscribers' => $data])['data'];
    }

    /**
     * Remove Subscribers from this Topic
     *
     * @param  string $topicKey
     * @param  array  $data
     * @return void
     */
    public function removeSubscribersFromTopic($topicKey, array $data)
    {
        return $this->post("topics/{$topicKey}/subscribers/removal", ['subscribers' => $data]);
    }

    /**
     * Get Topic
     *
     * @param  string $topicKey
     * @return \Novu\SDK\Resources\Topic
     */
    public function topic($topicKey)
    {
        $topic = $this->get("topics/{$topicKey}")['data'];

        return new Topic($topic, $this);
    }

    /**
     * Rename Topic
     *
     * @param  string $topicKey
     * @param  string $topicName
     * @return \Novu\SDK\Resources\Topic
     */
    public function renameTopic($topicKey, $topicName)
    {
        $topic = $this->patch("topics/{$topicKey}", ['name' => $topicName])['data'];

        return new Topic($topic, $this);
    }
}
