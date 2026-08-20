<?php

namespace App\Console\Commands;

use App\Services\FirebaseNotificationService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('firebase:test-notification {tokens* : One or more FCM registration tokens}')]
#[Description('Send a test Firebase notification to supplied FCM tokens')]
class TestFirebaseNotification extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(FirebaseNotificationService $notifications)
    {
        $tokens = $this->argument('tokens');
        $notifications->sendToTokens(
            tokens: $tokens,
            notificationId: 'test-1',
            routeName: '/workOrderScreen',
            title: 'Maintly Test Notification',
            content: 'Firebase notification integration is working',
            payload: [
                'work_order_id' => 9,
            ],
        );
        $this->info('Firebase notification sent.');

        return self::SUCCESS;
    }
}
