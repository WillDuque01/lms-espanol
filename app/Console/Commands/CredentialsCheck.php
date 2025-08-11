<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CredentialsCheck extends Command
{
    protected $signature = 'credentials:check';
    protected $description = 'Lista variables .env faltantes por integración';

    public function handle(): int
    {
        $sets = [
            'Google OAuth' => ['GOOGLE_CLIENT_ID','GOOGLE_CLIENT_SECRET','GOOGLE_REDIRECT_URI'],
            'Pusher/Ably'  => ['PUSHER_APP_ID','PUSHER_APP_KEY','PUSHER_APP_SECRET'],
            'S3/R2'        => ['AWS_ACCESS_KEY_ID','AWS_SECRET_ACCESS_KEY','AWS_BUCKET'],
            'Vimeo/CF'     => ['VIMEO_TOKEN','CLOUDFLARE_STREAM_TOKEN'],
            'Gmail SMTP'   => ['MAIL_HOST','MAIL_USERNAME','MAIL_PASSWORD'],
            'Make HMAC'    => ['WEBHOOKS_MAKE_SECRET'],
        ];

        foreach ($sets as $name => $keys) {
            $missing = array_filter($keys, fn ($k) => empty(env($k)));
            if ($missing) {
                $this->warn("$name faltantes: ".implode(', ', $missing));
            } else {
                $this->info("$name OK");
            }
        }
        return self::SUCCESS;
    }
}
