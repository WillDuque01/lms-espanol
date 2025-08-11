<div>
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-semibold">Builder: {{ $course->slug }}</h2>
    <button wire:click="addChapter" class="px-3 py-2 bg-blue-600 text-white rounded">Añadir capítulo</button>
  </div>
  <div class="space-y-4">
    @foreach($chapters as $c)
      <div class="border rounded p-3">
        <div class="flex items-center justify-between">
          <h3 class="font-medium">{{ $c['title'] }}</h3>
          <div class="space-x-2">
            <button wire:click="addLesson({{ $c['id'] }}, 'text')" class="text-sm px-2 py-1 bg-gray-200 rounded">Texto</button>
            <button wire:click="addLesson({{ $c['id'] }}, 'video')" class="text-sm px-2 py-1 bg-gray-200 rounded">Video</button>
            <button wire:click="addLesson({{ $c['id'] }}, 'pdf')" class="text-sm px-2 py-1 bg-gray-200 rounded">PDF</button>
            <button wire:click="addLesson({{ $c['id'] }}, 'quiz')" class="text-sm px-2 py-1 bg-gray-200 rounded">Quiz</button>
          </div>
        </div>
        <ul class="mt-2 list-disc pl-5">
          @foreach($c['lessons'] as $l)
            <li>Lección #{{ $l['id'] }} — {{ $l['type'] }} (pos {{ $l['position'] }})</li>
          @endforeach
        </ul>
      </div>
    @endforeach
  </div>

  <script>
    window.addEventListener('order-saved',()=>{
      // toast/feedback
    });
  </script>
</div>


