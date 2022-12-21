<?php
declare(strict_types=1);

namespace App\Repositories\Webinargeek;

use App\Clients\WebinargeekServiceClient;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WebinarRepository
{
    private function getClient(): WebinargeekServiceClient
    {
        return app()->make(WebinargeekServiceClient::class);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getById(int $id): array
    {
        return $this->getClient()->get('v2/webinars/' . $id, [], true) ?? [];
    }

    /**
     * @param int $webinarId
     * @return array|null
     */
    public function getBroadcastsIdByWebinarId(int $webinarId): ?array
    {
        $cacheKey = 'wbgeek_webinar_' . $webinarId . '_broadcasts';
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $webinar = $this->getById($webinarId);
        if (empty($webinar['episodes'])) {
            return null;
        }

        $result = [];
        foreach ($webinar['episodes'] as $episode) {
            if (empty($episode['broadcasts'])) {
                continue;
            }

            foreach ($episode['broadcasts'] as $broadcast) {
                $result[] = $broadcast['id'];
            }
        }

        if (!empty($result)) {
            Cache::put($cacheKey, $result, 1800);
        }

        return $result;
    }

    /**
     * @param int $webinarId
     * @param array $data
     * @return array|null
     */
    public function addSubscriber(int $webinarId, array $data): ?array
    {
        $result = $this->getClient()->post('v2/webinars/' . $webinarId . '/series_subscribe', $data, true) ?? [];

        Log::info(json_encode($result));

        return !empty($result['subscriptions'][0]['id']) && !empty($result['subscriptions'][0]['watch_link'])
            ? $result['subscriptions'][0]
            : null;
    }

}
