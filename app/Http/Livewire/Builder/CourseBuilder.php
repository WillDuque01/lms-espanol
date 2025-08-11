<?php

namespace App\Http\Livewire\Builder;

use App\Models\Course;
use App\Models\Chapter;
use App\Models\Lesson;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CourseBuilder extends Component
{
    public Course $course;
    public array $chapters = [];

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->chapters = $course->chapters()->with('lessons')->get()->map(fn($c)=>[
            'id'=>$c->id,'title'=>$c->title,'position'=>$c->position,
            'lessons'=>$c->lessons->map(fn($l)=>['id'=>$l->id,'type'=>$l->type,'position'=>$l->position])->toArray(),
        ])->toArray();
    }

    public function addChapter(): void
    {
        $pos = (int) (Chapter::where('course_id',$this->course->id)->max('position') ?? 0) + 1;
        Chapter::create(['course_id'=>$this->course->id,'title'=>'Nuevo capítulo','position'=>$pos]);
        $this->mount($this->course);
    }

    public function addLesson(int $chapterId, string $type): void
    {
        $pos = (int) (Lesson::where('chapter_id',$chapterId)->max('position') ?? 0) + 1;
        Lesson::create(['chapter_id'=>$chapterId,'type'=>$type,'position'=>$pos]);
        $this->mount($this->course);
    }

    public function saveOrder(array $chapters): void
    {
        DB::transaction(function() use ($chapters){
            foreach ($chapters as $i=>$c){
                Chapter::where('id',$c['id'])->update(['position'=>$i+1]);
                foreach (($c['lessons'] ?? []) as $j=>$l){
                    Lesson::where('id',$l['id'])->update(['position'=>$j+1]);
                }
            }
        });
        $this->mount($this->course);
        $this->dispatchBrowserEvent('order-saved');
    }

    public function render()
    {
        return view('livewire.builder.course-builder');
    }
}


