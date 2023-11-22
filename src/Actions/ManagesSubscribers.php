<?php

namespace Novu\SDK\Actions;

use Novu\SDK\Resources\FeedNotification;
use Novu\SDK\Resources\Notification;
use Novu\SDK\Resources\Paginated;
use Novu\SDK\Resources\Subscriber;
use Novu\SDK\Resources\SubscriptionPreference;
use Novu\SDK\Resources\Workflow;

trait ManagesSubscribers
{
    /**
     * Create a new subscriber.
     *
     * @param  array $data
     * @param  bool  $wait
     * @return \Novu\SDK\Resources\Subscriber
     */
    public function createSubscriber(array $data, $wait = true)
    {
        $subscriber = $this->post("subscribers", $data)['data'];

        return new Subscriber($subscriber, $this);
    }

    /**
     * Bulk creates subscribers.
     *
     * @param array $data
     *
     * @return array
     */
    public function bulkCreateSubscribers(array $data): array
    {
        return $this->post('subscribers/bulk', ['subscribers' => $data])['data'];
    }

    /**
     * Update a given subscriber
     *
     * @param  string $subscriberId
     * @param  array  $data
     * @return \Novu\SDK\Resources\Subscriber
     */
    public function updateSubscriber($subscriberId, array $data)
    {
        $subscriber = $this->put("subscribers/{$subscriberId}", $data)['data'];

        return new Subscriber($subscriber, $this);
    }

    /**
     * Delete the given subscriber.
     *
     * @param  string  $subscriberId
     * @return \Novu\SDK\Resources\Subscriber
     */
    public function deleteSubscriber($subscriberId)
    {
        $response = $this->delete("subscribers/{$subscriberId}")['data'];

        return new Subscriber($response, $this);
    }

    /**
     * Update a given subscriber credentials [ Come back to this---->]
     *
     * @param  string $subscriberId
     * @param  array  $data
     * @return \Novu\SDK\Resources\Subscriber
     */
    public function updateSubscriberCredentials($subscriberId, array $data)
    {
        $subscriber = $this->put("subscribers/{$subscriberId}/credentials", $data)['data'];

        return new Subscriber($subscriber, $this);
    }

    /**
     * Fetch list of subscribers [ Come back to this for pagination---->]
     *
     * @return \Novu\SDK\Resources\Subscriber
     */
    public function getSubscriberList()
    {
        $subscribers = $this->get("subscribers");

        return new Subscriber($subscribers, $this);
    }

    /**
     * Fetch one subscriber
     *
     * @param  string $subscriberId
     * @return \Novu\SDK\Resources\Subscriber
     */
    public function getSubscriber($subscriberId)
    {
        $subscriber = $this->get("subscribers/{$subscriberId}")['data'];

        return new Subscriber($subscriber, $this);
    }

    /**
     * Fetch a subscriber preferences
     *
     * @param  string  $subscriberId
     * @return SubscriptionPreference[]
     */
    public function getSubscriberPreferences($subscriberId)
    {
        $preferences = $this->get("subscribers/{$subscriberId}/preferences")['data'];

        return array_map(fn ($preference) => new SubscriptionPreference($preference, $this), $preferences);
    }

    /**
     * Update a given subscriber preferences [ Come back to this---->]
     *
     * @param  string $subscriberId
     * @param  string $templateId
     * @param  array  $data
     * @return \Novu\SDK\Resources\SubscriptionPreference
     */
    public function updateSubscriberPreference($subscriberId, $templateId, array $data)
    {
        $result = $this->patch("subscribers/{$subscriberId}/preferences/{$templateId}", $data)['data'];

        return new SubscriptionPreference($result, $this);
    }

    /**
     * Update subscriber online status
     *
     * @param  string $subscriberId
     * @param  bool $isOnlineStatus
     * @return \Novu\SDK\Resources\Subscriber
     */
    public function updateSubscriberOnlineStatus($subscriberId, $isOnlineStatus)
    {
        $subscriber = $this->patch("subscribers/{$subscriberId}/online-status",
            [
                'json' => [
                    'isOnline' => $isOnlineStatus
                ]
            ]
        )['data'];

        return new Subscriber($subscriber, $this);
    }

    /**
     * Get a notification feed for a particular subscriber [Come back to this for pagination]
     *
     * @param  string  $subscriberId
     * @return Paginated<\Novu\SDK\Resources\FeedNotification>
     */
    public function getNotificationFeedForSubscriber($subscriberId)
    {
        $response = $this->get("subscribers/{$subscriberId}/notifications/feed");

        $response['data'] = array_map(fn ($value) => new FeedNotification($value, $this), $response['data']);
        return new Paginated($response);
    }

    /**
     * Get the unseen notification count for subscribers feed
     *
     * @param  string  $subscriberId
     * @return int
     */
    public function getUnseenNotificationCountForSubscriber($subscriberId)
    {
        $feed = $this->get("subscribers/{$subscriberId}/notifications/unseen")['data'];

        return $feed;
    }

    /**
     * Mark a subscriber feed message as seen - [Deprecated]
     *
     * @param  string  $subscriberId
     * @param  string  $messageId
     * @param  array $data
     * @param  bool  $wait
     * @return Paginated<\Novu\SDK\Resources\FeedNotification>
     */
    public function markSubscriberFeedMessageAsSeen($subscriberId, $messageId, array $data, $wait = true)
    {
        $response = $this->post("subscribers/{$subscriberId}/messages/{$messageId}/seen", $data)['data'];

        $response['data'] = array_map(fn ($value) => new FeedNotification($value, $this), $response['data']);
        return new Paginated($response);
    }

    /**
     * Mark message action as seen - [Deprecated]
     *
     * @param  string  $subscriberId
     * @param  string  $messageId
     * @param  string  $type
     * @param  array   $data
     * @param  bool    $wait
     * @return Paginated<\Novu\SDK\Resources\FeedNotification>
     */
    public function markSubscriberMessageActionAsSeen($subscriberId, $messageId, $type, array $data, $wait = true)
    {
        $response = $this->post("subscribers/{$subscriberId}/messages/{$messageId}/actions/{$type}", $data)['data'];

        $response['data'] = array_map(fn ($value) => new FeedNotification($value, $this), $response['data']);
        return new Paginated($response);
    }
}
