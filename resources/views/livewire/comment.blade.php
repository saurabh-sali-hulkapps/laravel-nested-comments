<style>
    .tip {
        width: 0px;
        height: 0px;
        position: absolute;
        background: transparent;
        border: 10px solid #ccc;
    }

    .tip-up {
        top: -25px; /* Same as body margin top + border */
        left: 10px;
        border-right-color: transparent;
        border-left-color: transparent;
        border-top-color: transparent;
    }

    .dialog-box .body {
        position: relative;
        max-width: 100%;
        height: auto;
        margin: 20px 10px;
        padding: 5px;
        background-color: #DADADA;
        border-radius: 3px;
        border: 5px solid #ccc;
    }

    .body .message {
        min-height: 30px;
        border-radius: 3px;
        font-size: 14px;
        line-height: 1.5;
        color: #797979;

        display: flex;
        justify-content: space-between;
    }

    .name-time-div {
        display: flex;
        justify-content: space-between;
    }

    .anchor-form-span {
        display: flex;
        justify-content: space-between;
    }

    #edit {
        margin-top: -15px;
        background: none !important;
        border: none;
        outline: none;
        padding: 0 !important;
    }

    .edit-textarea {
        width: 90%;
        background: #E8E8E8;
        padding: 5px 10px;
        height: 10%;
        border-radius: 5px 5px 0px 0px;
        border: 2px solid black;
        transition: all 0.5s;
        margin-top: 10px;
        margin-left: 105px;
    }

    .reply-textarea {
        width: 90%;
        background: #E8E8E8;
        padding: 5px 10px;
        height: 10%;
        border-radius: 5px 5px 0px 5px;
        border: 2px solid black;
        transition: all 0.5s;
        margin-top: 10px;
        margin-left: 105px;
    }

    .e-button {
        background-color: orange; /* Green */
        padding: 10px 30px;
        margin-right: 15px;
        margin-bottom: 10px;
    }

    .r-button {
        background-color: red; /* Green */
        padding: 10px 30px;
        margin-right: 15px;
        margin-bottom: 10px;
    }

    .replies-div {
        box-sizing: border-box;
        margin-left: 30px;
    }
</style>

@foreach($comments as $key => $comment)
    <div class="dialog-box">
        <div class="body">
            <span class="tip tip-up"></span>
            <div class="name-time-div">
                <span>{{ $comment->user->name }}</span>
                <span>{{ $comment->created_at }}</span>
            </div>
            <div class="message">
                <span>{{ $comment->comment }}</span>
                <div class="anchor-form-span">
                    @if($key === 0 && $comment->user->id === Auth::user()->id)
                        <button id="edit" onclick="editComment({{ $comment->id }})">Edit</button>
                        &nbsp;&nbsp;&nbsp;
                        <form action="/comments/{{ $comment->id }}/" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit">Del</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <form method="POST"
          action="{{ route('posts.comments.replies.store',[ 'post'=>$post_id, 'comment'=>$comment->id ]) }}">
        @csrf
        <textarea class="reply-textarea" name="reply" placeholder="Add Reply..." cols="30" rows="10"></textarea>
        <br>
        <br>
        <button type="submit" class="button r-button">Reply</button>
    </form>
    <br>
    <div class="replies-div">
        @include('livewire.comment',['comments'=>$comment->replies])
    </div>
    <div id="edit-comment"></div>
@endforeach
<br>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!-- jQuery CDN -->
<script>
    function editComment(comment) {
        $('#edit-comment').show();
        $.ajax({
            url: "/comments/" + comment + "/edit",
            method: "GET",
            success: function (result) {
                let jsonData = JSON.parse(result);

                let htmlText = '';
                htmlText += '<form method="POST" action="/comments/' + jsonData["id"] + ' ">';
                htmlText += '@method("PUT")';
                htmlText += '@csrf';
                htmlText += '<textarea class="edit-textarea" name="comment" placeholder="Add Comment..." cols="30"' +
                    ' rows="10">' + jsonData["comment"] + '</textarea>';
                htmlText += '<br>';
                htmlText += '<br>';
                htmlText += '<button type="submit" class="button e-button">Update</button>';
                htmlText += '<button type="button" onclick="cancelComment()" class="button e-button">Cancel</button>';
                htmlText += '</form>';

                $("#edit-comment").html(htmlText);
            }
        });
    }

    function cancelComment() {
        $('#edit-comment').hide();
    }
</script>
