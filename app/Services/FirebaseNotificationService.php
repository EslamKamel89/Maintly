<?php

namespace App\Services;

use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseNotificationService
{
    private const BATCH_SIZE = 500;

    public function __construct(private readonly Messaging $messaging) {}

    /**
     * @param  array<int, string>  $tokens
     * @param  array<string, mixed>  $payload
     * @return void
     */
    public function sendToTokens(
        array $tokens,
        string $notificationId,
        string $routeName,
        string $title,
        string $content,
        array $payload = [],
    ) {
        $tokens = collect($tokens)
            ->filter(fn ($token) => is_string($token) && trim($token) !== '')
            ->unique()
            ->values()
            ->toArray();
        if ($tokens === []) {
            return;
        }
        $message = CloudMessage::new()
            ->withNotification(Notification::create($title, $content))
            ->withData([
                'id' => $notificationId,
                'route_name' => $routeName,
                'title' => $title,
                'content' => $content,
                'payload' => json_encode(
                    $payload,
                    JSON_THROW_ON_ERROR,
                ),
            ]);
        foreach (array_chunk($tokens, self::BATCH_SIZE) as $batch) {
            $this->messaging->sendMulticast($message, $batch);
        }
    }
}
