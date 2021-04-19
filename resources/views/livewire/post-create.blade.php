<style>
    table {
        display: flex;
        justify-content: center;
    }

    .button {
        background-color: orange; /* Green */
        border: none;
        color: white;
        padding: 7px 35px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create PostController') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div>
                    <form action="/posts/{{ isset($post)?$post['id']:'' }}" method="POST">
                        @if(!empty($post['id']))
                            @method('PUT')
                        @else
                            @method('POST')
                        @endif
                        @csrf
                        <table>
                            <tr>
                                <td>Title</td>
                                <td><input type="text" name="title" value="{{ $post['title'] }}"></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>
                                    <textarea name="description" cols="30"
                                              rows="10">{{ $post['description'] }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Author</td>
                                <td><input type="text" name="author" value="{{ Auth::user()->name }}" disabled></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="button" type="submit">
                                        {{ !empty($post['id'])?'Update':'Add' }}
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
