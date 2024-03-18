<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Nwilging\LaravelDiscordBot\Contracts\Notifications\DiscordNotificationContract;
use Nwilging\LaravelDiscordBot\Support\Builder\ComponentBuilder;
use Nwilging\LaravelDiscordBot\Support\Builder\EmbedBuilder;

class TestNotification extends Notification implements DiscordNotificationContract
{
    use Queueable;

    public function via($notifiable): array
    {
        return ['discord'];
    }

    public function toDiscord($notifiable): array
    {
        $embedBuilder = new EmbedBuilder();
        $embedBuilder->addAuthor('Me!');

        $componentBuilder = new ComponentBuilder();
        $componentBuilder->addLinkButton('Tickle My Ass', 'http://ae.test/interactions');

        return [
            'contentType' => 'rich',
            'channelId' => '1195839867926626374',
            'embeds' => $embedBuilder->getEmbeds(),
            'components' => [
                $componentBuilder->getActionRow(),
            ],
        ];
    }
}
