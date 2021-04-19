<style>
    .button {
        border: none;
        border-radius: 4px;
        color: white;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        float: right;
    }

    .a-button {
        background-color: orange; /* Green */
        padding: 10px 30px;
    }

    .container {
        margin-top: 15px;
    }

    textarea {
        width: 100%;
        background: #E8E8E8;
        padding: 5px 10px;
        height: 10%;
        border-radius: 5px 5px 0px 0px;
        border: 2px solid black;
        transition: all 0.5s;
        margin-top: 15px;
    }

    .description-div {
        margin-left: 10px;
    }

    .author-div {
        float: right;
        margin-right: 10px;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div>
                    <div class="text-center font-semibold text-xl">
                        <span>Post: </span>
                        <span>{{ $post->title }}</span>
                    </div>
                    <div class="font-semibold text-xl description-div">
                        <span>Description: </span>
                        <p>{{ $post->description }}</p>
                    </div>
                    <div class="font-semibold text-gray-900 author-div">
                        <span>Author: </span>
                        <span>{{ $post->user->name }}</span>
                    </div>
                    <div>
                        <br>
                        <hr>
                        <br>
                        <section id="app">
                            <div class="container">
                                <div class="row">
                                    <div class="col-6">
                                        <form method="post" action="/posts/{{ $post->id }}/comments">
                                            @csrf
                                            <textarea name="comment" placeholder="Add Comment..." cols="30"
                                                      rows="10"></textarea>
                                            <br>
                                            <br>
                                            <button type="submit" class="button a-button">Add Comment</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <br><br>
                        <hr>
                        <br>
                        <h4 class="font-semibold text-xl">Comments</h4>
                        @include('livewire.comment', ['comments' => $post->comments,'post_id'=>$post->id])
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function myFunction() {
        let x = document.getElementById("my-div");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>
