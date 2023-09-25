<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>

    <div class="flex justify-center items-center flex-wrap gap-8">
        <div class="w-full bg-base-100 rounded-xl shadow-lg border px-5 py-3">
            <div class="flex flex-row-reverse justify-between items-center mb-3">
                <div class="dropdown dropdown-bottom dropdown-end">
                    <label tabindex="0" class="btn btn-square btn-outline hover:bg-white border-0">
                        <box-icon name='dots-horizontal-rounded'></box-icon></label>
                    <ul tabindex="0"
                        class="dropdown-content z-[1] menu p-2 shadow-xl border-solid border bg-base-100 rounded-box w-52">
                        <li><a>Download</a></li>
                        <li><a>Report</a></li>
                    </ul>
                </div>
                <a href="{{ route('profile.index', $post->user->username) }}">
                    <div class="card-top flex items-center gap-2">
                        <div class="avatar">
                            <div class="w-9 rounded-full">
                                <img
                                    src="{{ !empty($post->user->photo) ? \Storage::url($post->user->photo) : asset('assets/images/user.jpg') }}" />
                            </div>
                        </div>
                        <div style="line-height: 15px">
                            <div class="text-md font-semibold">{{ $post->user->name }}</div>
                            <small>{{ $post->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </a>
            </div>

            @empty(!$post->photo)
                <figure>
                    <div class="h-64 w-full bg-contain bg-center bg-no-repeat"
                        style="background-image: url('{{ Storage::url($post->photo) ?? '' }}');">
                    </div>
                </figure>
            @endempty

            <div class="my-3">
                <p class="leading-tight">{{ $post->body }}</p>
            </div>

            <hr>

            <div class="mt-3 flex gap-3">
                <form action="{{ route('post.like', $post->id) }}" method="post">
                    @csrf
                    <button class="flex gap-1 bg-white hover:bg-white border-0">
                        @php
                            $userLiked = $post->likes->contains('user_id', auth()->id());
                        @endphp
                        <box-icon name='heart' color='{{ $userLiked ? 'red' : '' }}'
                            type='{{ $userLiked ? 'solid' : '' }}'></box-icon>
                        <p>{{ $post->likes->count() }}</p>
                    </button>
                </form>
                <a href="" class="flex gap-1 bg-white hover:bg-white border-0">
                    <box-icon name='message-square-dots'></box-icon>
                    <p>{{ $post->comments->count() }}</p>
                </a>
            </div>
        </div>

        <div class="w-full bg-base-100 rounded-xl shadow-lg px-5 py-3">
            <div class="flex items-center justify-start gap-2">
                <box-icon name='message-square-dots'></box-icon>
                <h2 class="text-2xl font-bold">
                    Komentar
                </h2>
            </div>

            <hr>

            <div class="mt-3">
                <form action="{{ route('post.comment') }}" method="post">
                    @csrf
                    <label class="label">
                        <span class="label-text">Komentar</span>
                    </label>
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <textarea class="textarea textarea-bordered w-full" name="body" placeholder="Masukan komentar"></textarea>
                    <button class="btn btn-primary btn-block">Kirim</button>
                </form>
            </div>

            <div class="divider"></div>

            @foreach ($comment as $item)
                <div class="mb-4">
                    <div class="w-full shadow-md border rounded-xl px-5 py-3">
                        <a href="{{ route('profile.index', $item->user->username) }}"
                            class="card-top flex items-center gap-2 w-70">
                            <div class="avatar">
                                <div class="w-9 rounded-full">
                                    <img
                                        src="{{ !empty($item->user->photo) ? \Storage::url($item->user->photo) : asset('assets/images/user.jpg') }}" />
                                </div>
                            </div>
                            <div style="line-height: 15px">
                                <div class="text-md font-semibold">{{ $item->user->name }}</div>
                                <small>{{ $item->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                        <div class="mt-3">
                            <p class="leading-tight">{{ $item->body }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
