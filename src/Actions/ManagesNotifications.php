<?php

namespace Novu\SDK\Actions;

use Novu\SDK\Resources\Notification;
use Novu\SDK\Resources\NotificationStats;
use Novu\SDK\Resources\NotificationGraphStats;
use Novu\SDK\Resources\Paginated;

trait ManagesNotifications
{

    /**
     * Get A Notification
     *
     * @param  string $notificationId
     * @return \Novu\SDK\Resources\Notification
     */
    public function getNotification($notificationId)
    {
        $response = $this->get("notifications/{$notificationId}")['data'];

        return new Notification($response, $this);
    }

     /**
     * Get All Notifications
     * @param array $queryParams
     * @return Paginated<\Novu\SDK\Resources\Notification>
     */
    public function getNotifications(array $queryParams = [])
    {
        $uri = "notifications";

        if(! empty($queryParams)) {
            $uri .= '?' . http_build_query($queryParams);
        }

        $response = $this->get($uri);

        $response['data'] = array_map(fn ($value) => new Notification($value, $this), $response['data']);
        return new Paginated($response);
    }

     /**
     * Get Notification Statistics
     *
     * @return \Novu\SDK\Resources\NotificationStats
     */
    public function getNotificationStats()
    {
        $response = $this->get("notifications/stats")['data'];

        return new NotificationStats($response, $this);
    }

    /**
     * Get Notification Graph Stats
     * @param array $queryParams
     * @return \Novu\SDK\Resources\NotificationGraphStats[]
     */
    public function getNotificationGraphStats(array $queryParams = [])
    {
        $uri = "notifications/graph/stats";

        if(! empty($queryParams)) {
            $uri .= '?' . http_build_query($queryParams);
        }

        $response = $this->get($uri)['data'];

        return array_map(fn ($value) => new NotificationGraphStats($value, $this), $response);
    }

}
