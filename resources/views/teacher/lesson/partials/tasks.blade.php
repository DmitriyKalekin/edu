<div class="d-flex form-group">
    <a class="site-btn-hollow col-md-4"
       href="{{ route('teacher.taskBlock.create', $lesson->id) }}">✚ @lang('content.task')</a>
</div>

@foreach($lesson->tasks() as $block)
    <div class="d-flex">
        <a style="font-size: 14px;border-width: 1px"
           href="{{ route('teacher.taskBlock.show', ['lesson'=>$lesson->id, 'taskBlock'=>$block->id]) }}"
           class="list-group-item list-group-item-action col-md-6">{{ $block->position + 1 }}
            : @lang('content.task')</a>
        <a class="site-btn-hollow col-md-3"
           href="{{route('teacher.taskBlock.edit', [$lesson->id, $block->id])}}"><i
                    class="fa fa-edit"></i></a>
        <form class="col-md-3 p-0"
              onsubmit="if(confirm('Delete step?')){return true}else{return false}"
              action="{{route('teacher.taskBlock.destroy', [$lesson, $block])}}"
              method="post">
            <input type="hidden" name="_method" value="Delete">
            {{ csrf_field() }}
            <button type="submit" class="site-btn-danger w-100">X</button>
        </form>
    </div>
@endforeach