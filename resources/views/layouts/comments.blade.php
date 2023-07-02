@foreach($comments as $comment)
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between">
            <div>
                <span>{{ $comment->user->name }}</span>
                <span class="text-muted">- دو دقیقه قبل</span>
            </div>
            @auth
                @if($comment->parent_id == 0)
                    <button onclick="ShowFormAndSetValueOfParentId(this)" class="btn btn-sm btn-primary" data-target="#sendComment" data-id="{{ $comment->id }}">پاسخ به نظر</button>
                @endif
            @endauth
        </div>

        <div class="card-body">
            {{ $comment->comment }}

            @include('layouts.comments', ['comments' => $comment->child])
        </div>
    </div>
@endforeach
