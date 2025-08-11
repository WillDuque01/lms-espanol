<!doctype html>
<html>
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Provisioner</title>
  <style>label{display:block;margin:.5rem 0 .25rem}input,select{width:100%;padding:.5rem} .grid{display:grid;gap:1rem;grid-template-columns:repeat(auto-fit,minmax(260px,1fr))} .card{border:1px solid #ddd;padding:1rem;border-radius:12px}</style>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/app.css'])
</head>
<body class="p-6">
  <h1 class="text-2xl font-semibold mb-4">Provisionar Integraciones</h1>
  <form id="prov" class="grid">
    <div class="card"><h3 class="font-medium mb-2">Google OAuth</h3>
      <label>CLIENT ID</label><input name="GOOGLE_CLIENT_ID">
      <label>CLIENT SECRET</label><input name="GOOGLE_CLIENT_SECRET">
      <label>REDIRECT URI</label><input name="GOOGLE_REDIRECT_URI" value="{{ url('/auth/google/callback') }}">
    </div>
    <div class="card"><h3 class="font-medium mb-2">Pusher</h3>
      <label>PUSHER_APP_ID</label><input name="PUSHER_APP_ID">
      <label>PUSHER_APP_KEY</label><input name="PUSHER_APP_KEY">
      <label>PUSHER_APP_SECRET</label><input name="PUSHER_APP_SECRET">
      <label>PUSHER_APP_CLUSTER</label><input name="PUSHER_APP_CLUSTER" value="mt1">
    </div>
    <div class="card"><h3 class="font-medium mb-2">S3/R2</h3>
      <label>AWS_ACCESS_KEY_ID</label><input name="AWS_ACCESS_KEY_ID">
      <label>AWS_SECRET_ACCESS_KEY</label><input name="AWS_SECRET_ACCESS_KEY">
      <label>AWS_BUCKET</label><input name="AWS_BUCKET">
      <label>AWS_ENDPOINT</label><input name="AWS_ENDPOINT" placeholder="https://... (R2/Wasabi)">
      <label>AWS_DEFAULT_REGION</label><input name="AWS_DEFAULT_REGION" placeholder="auto">
      <label>AWS_USE_PATH_STYLE_ENDPOINT</label><input name="AWS_USE_PATH_STYLE_ENDPOINT" value="true">
    </div>
    <div class="card"><h3 class="font-medium mb-2">Video</h3>
      <label>VIMEO_TOKEN</label><input name="VIMEO_TOKEN">
      <label>CLOUDFLARE_STREAM_TOKEN</label><input name="CLOUDFLARE_STREAM_TOKEN">
      <label>CLOUDFLARE_ACCOUNT_ID</label><input name="CLOUDFLARE_ACCOUNT_ID">
      <label>YOUTUBE_ORIGIN</label><input name="YOUTUBE_ORIGIN" value="{{ config('app.url') }}">
    </div>
    <div class="card"><h3 class="font-medium mb-2">SMTP</h3>
      <label>MAIL_MAILER</label><input name="MAIL_MAILER" value="smtp">
      <label>MAIL_HOST</label><input name="MAIL_HOST" value="smtp.hostinger.com">
      <label>MAIL_PORT</label><input name="MAIL_PORT" value="465">
      <label>MAIL_USERNAME</label><input name="MAIL_USERNAME">
      <label>MAIL_PASSWORD</label><input name="MAIL_PASSWORD" type="password">
      <label>MAIL_ENCRYPTION</label><input name="MAIL_ENCRYPTION" value="ssl">
      <label>MAIL_FROM_ADDRESS</label><input name="MAIL_FROM_ADDRESS" value="academy@letstalkspanish.io">
      <label>MAIL_FROM_NAME</label><input name="MAIL_FROM_NAME" value="LMS Español">
    </div>
    <div class="card"><h3 class="font-medium mb-2">Make/Discord/Sheets</h3>
      <label>WEBHOOKS_MAKE_SECRET</label><input name="WEBHOOKS_MAKE_SECRET">
      <label>MAKE_WEBHOOK_URL</label><input name="MAKE_WEBHOOK_URL">
      <label>DISCORD_WEBHOOK_URL</label><input name="DISCORD_WEBHOOK_URL">
      <label>GOOGLE_SERVICE_ACCOUNT_JSON_PATH</label><input name="GOOGLE_SERVICE_ACCOUNT_JSON_PATH" value="storage/app/keys/google.json">
      <label>SHEET_ID</label><input name="SHEET_ID">
      <label>GOOGLE_SHEETS_ENABLED</label><input name="GOOGLE_SHEETS_ENABLED" value="true">
    </div>
    <div>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
    </div>
  </form>
  <script>
    document.getElementById('prov').addEventListener('submit', async (e)=>{
      e.preventDefault();
      const data = Object.fromEntries(new FormData(e.target).entries());
      const res = await fetch('{{ url('/provisioner/save') }}',{method:'POST', headers:{'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]')?.content}, body:new URLSearchParams(data)});
      alert(res.ok? 'Guardado' : 'Error');
    });
  </script>
</body>
</html>


