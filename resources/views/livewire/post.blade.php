<style>
    .button {
        border: none;
        border-radius: 4px;
        color: white;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }

    .a-button {
        background-color: orange; /* Green */
        padding: 10px 30px;
    }

    .v-button {
        background-color: green; /* Green */
        padding: 7px 25px;
    }

    .e-button {
        background-color: blue; /* Green */
        padding: 7px 25px;
    }

    .d-button {
        background-color: red; /* Green */
        padding: 7px 25px;
    }

    .a-form {
        display: flex;
        justify-content: space-evenly;
    }

    .s-form {
        display: flex;
        justify-content: space-between;
    }

    .read-only {
        text-align: center;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div>
                    <div class="s-form">
                        <div>
                            <a class="button a-button" href="{{ route('posts.create') }}">Add</a>
                        </div>
                        <form action="/posts/" method="GET">
                            Search: <input type="text" name="search">
                            <button class="button a-button" type="submit">Go</button>
                        </form>
                    </div>
                    <table class="table-fixed w-full">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">@sortablelink('title','Title')</th>
                            <th class="px-4 py-2">Author</th>
                            <th class="px-4 py-2">@sortablelink('created_at','Created_At')</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td class="border px-4 py-2 read-only">{{ $post->title }}</td>
                                <td class="border px-4 py-2 read-only">{{ $post->user->name }}</td>
                                <td class="border px-4 py-2 read-only">{{ $post->created_at }}</td>
                                @if($post['user_id'] === Auth::user()->id)
                                    <td class="border px-4 py-2 a-form">
                                        <div>
                                            <a href="{{ route('posts.show',['post'=>$post->slug]) }}"
                                               class="button v-button">View</a>
                                        </div>
                                        <div>
                                            <a href="{{ route('posts.edit',['post'=>$post->id]) }}"
                                               class="button e-button">Edit</a>
                                        </div>
                                        <form action="/posts/{{ $post->id }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="button d-button">Del</button>
                                        </form>
                                    </td>
                                @else
                                    <td class="border px-4 py-2 read-only">
                                        <div>
                                            <a href="{{ route('posts.show', ['post'=>$post->slug]) }}"
                                               class="button v-button">View</a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                        <tfooter>
                            <tr>
                                <td class="border px-4 py-2 read-only" colspan="4">{{ $posts->links() }}</td>
                            </tr>
                        </tfooter>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
