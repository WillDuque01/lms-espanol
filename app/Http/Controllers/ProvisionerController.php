<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ProvisionerController extends Controller
{
    public function save(Request $request)
    {
        $keys = [
            'GOOGLE_CLIENT_ID','GOOGLE_CLIENT_SECRET','GOOGLE_REDIRECT_URI',
            'PUSHER_APP_ID','PUSHER_APP_KEY','PUSHER_APP_SECRET','PUSHER_APP_CLUSTER',
            'AWS_ACCESS_KEY_ID','AWS_SECRET_ACCESS_KEY','AWS_BUCKET','AWS_ENDPOINT','AWS_DEFAULT_REGION','AWS_USE_PATH_STYLE_ENDPOINT',
            'VIMEO_TOKEN','CLOUDFLARE_STREAM_TOKEN','CLOUDFLARE_ACCOUNT_ID','YOUTUBE_ORIGIN',
            'MAIL_MAILER','MAIL_HOST','MAIL_PORT','MAIL_USERNAME','MAIL_PASSWORD','MAIL_ENCRYPTION','MAIL_FROM_ADDRESS','MAIL_FROM_NAME',
            'WEBHOOKS_MAKE_SECRET','MAKE_WEBHOOK_URL','DISCORD_WEBHOOK_URL',
            'GOOGLE_SERVICE_ACCOUNT_JSON_PATH','SHEET_ID','GOOGLE_SHEETS_ENABLED',
        ];
        $data = $request->only($keys);
        foreach ($data as $k => $v) {
            if ($v === null || $v === '') continue;
            $this->setEnv($k, (string) $v);
        }
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        return response()->noContent();
    }

    private function setEnv(string $key, string $value): void
    {
        $path = base_path('.env');
        if (!file_exists($path)) return;
        $content = file_get_contents($path);
        $pattern = "/^{$key}=.*$/m";
        $line = $key.'='.str_replace(["\\","\""],["\\\\","\\\""], $value);
        if (preg_match($pattern, $content)) {
            $content = preg_replace($pattern, $line, $content);
        } else {
            $content .= "\n{$line}";
        }
        file_put_contents($path, $content);
    }
}


