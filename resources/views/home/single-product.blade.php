@extends('layouts.app')

@section('style')
    <style>
        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            max-width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px;
        }
        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
            border: 1px solid #888;
            max-width: 600px; /* Could be more or less, depending on screen size */
        }
        /* Add Zoom Animation */
        .animate {
            -webkit-animation: animatezoom 0.6s;
            animation: animatezoom 0.6s
        }
        @-webkit-keyframes animatezoom {
            from {-webkit-transform: scale(0)}
            to {-webkit-transform: scale(1)}
        }
        @keyframes animatezoom {
            from {transform: scale(0)}
            to {transform: scale(1)}
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('admin.layouts.errors')
                <div class="card">
                    <div class="card-header">
                        {{ $product->title }}
                    </div>

                    <div class="card-body">
                        @foreach($product->categories as $category)
                            <a href="#">{{ $category->name }}</a>
                        @endforeach

                        <br>

                        {{ $product->description }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">

                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mt-4">بخش نظرات</h4>
                    @auth
                        <button onclick="ShowFormAndSetValueOfParentId(this)" class="btn btn-sm btn-primary" data-id="0">ثبت نظر جدید</button>
                    @endauth
                </div>

                @guest
                    <div class="alert alert-warning">برای ثبت نظر لطفا وارد شوید..</div>
                @endguest

                @auth

                    <div id="id01" class="modal">

                        <form class="modal-content animate p-3" action="{{ route('send.comment') }}" method="post" id="sendCommentForm">
                            @csrf
                            <input type="hidden" name="commentable_id" value="{{ $product->id }}">
                            <input type="hidden" name="commentable_type" value="{{ get_class($product) }}">
                            <input type="hidden" name="parent_id" value="0" id="parent_id">
                            <div class="container">
                                <label for="message-text" class="col-form-label">پیام دیدگاه:</label>
                                <textarea class="form-control" name="comment" id="message-text"></textarea>

                                <button type="submit" class="btn btn-info btn-sm ml-5 my-3">ارسال نظر</button>
                                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="btn btn-default btn-sm my-3">لغو</button>
                            </div>
                        </form>
                    </div>

                @endauth

                @include('layouts.comments', ['comments' => $product->comments()->where('parent_id', 0)->get()])

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Get the modal
        let modal = document.getElementById('id01');

        // When the user clicks anywhere outside the modal, close it
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }

        // show the send comment form and set the value of parent id
        function ShowFormAndSetValueOfParentId(button) {
            document.getElementById('id01').style.display='block';
            let parent_id = document.getElementById('parent_id');
            parent_id.value = $(button).data('id'); // set the parent id of given comment
        }

        // send ajax request
        // document.querySelector('#sendCommentForm').addEventListener('submit', function (event) {
        //     event.preventDefault();
        //     let target = event.target;
        //     let data = {
        //         commentable_id: target.querySelector('input[name="commentable_id"]').value,
        //         commentable_type: target.querySelector('input[name="commentable_type"]').value,
        //         parent_id: target.querySelector('input[name="parent_id"]').value,
        //         comment: target.querySelector('textarea[name="comment"]').value,
        //     };
        //
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
        //             'Content-Type': 'application/json'
        //         }
        //     });
        //
        //     $.ajax({
        //         type: 'post',
        //         url: '/comments',
        //         data: JSON.stringify(data),
        //         success: function (data) {
        //             console.log(data);
        //         }
        //     });
        //
        //     target.querySelector('textarea[name="comment"]').value = '';
        //     modal.style.display = "none";
        // });
    </script>
@endsection
