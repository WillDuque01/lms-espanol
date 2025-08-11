<div>
  @php($cfg = $lesson->config ?? [])
  @if(($cfg['source'] ?? 'youtube') === 'youtube')
    <div class="aspect-video">
      <iframe id="ytplayer" type="text/html" width="100%" height="100%"
        src="https://www.youtube-nocookie.com/embed/{{ $cfg['video_id'] ?? '' }}?enablejsapi=1&origin={{ config('app.url') }}"
        frameborder="0" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
    </div>
    <script>
      (function(){
        const origin = @json(env('YOUTUBE_ORIGIN', config('app.url')));
        let player, lastValid = 0, ticking = false;
        function onYouTubeIframeAPIReady(){
          player = new YT.Player('ytplayer', {
            events: {
              'onReady': onPlayerReady,
              'onStateChange': onPlayerStateChange
            }
          });
        }
        function onPlayerReady(){
          // noop
        }
        function onPlayerStateChange(e){
          if(e.data === YT.PlayerState.PLAYING && !ticking){
            ticking = true;
            setInterval(async ()=>{
              const t = Math.floor(player.getCurrentTime());
              if(t > lastValid) lastValid = t;
              try{
                await fetch('/api/video/progress',{
                  method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'},
                  body:new URLSearchParams({
                    lesson_id: String(@json($lesson->id)), source:'youtube', last_second:String(lastValid)
                  })
                });
              }catch(_){/* noop */}
            },5000);
          }
        }
        window.onPlayerSeek = function(){
          const t = Math.floor(player.getCurrentTime());
          if(t > lastValid){ player.seekTo(lastValid, true); }
        }
        const tag=document.createElement('script'); tag.src='https://www.youtube.com/iframe_api';
        const firstScriptTag=document.getElementsByTagName('script')[0]; firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        window.onYouTubeIframeAPIReady = onYouTubeIframeAPIReady;
      })();
    </script>
  @endif
</div>


