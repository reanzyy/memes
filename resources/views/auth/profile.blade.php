<x-app-layout>
    <x-slot name="title">
        {{ $user->name }} ({{ $user->username }})
    </x-slot>

    <x-container>
        <div class="avatar" id="imagePreview">
            <div class="w-40 rounded-full">
                <img id="imagePreview" class="rounded-full" draggable="false"
                    src="{{ !empty($user->photo) ? \Storage::url($user->photo) : asset('assets/images/user.jpg') }}"
                    alt="Profil Pengguna" />
            </div>
        </div>

        <div class="flex items-center gap-1">
            <h4 class="text-2xl font-semibold">{{ $user->name }}</h4>
        </div>

        <div class="text-center">
            <div class="text-sm mb-2">{{ '@' . $user->username }}</div>
            <div class="flex gap-3">
                <div class="text-sm">100 Pengikut</div>
                <div class="text-sm">100 Mengikuti</div>
                <div class="text-sm">{{ $user->posts->count() }} Postingan</div>
            </div>
        </div>

        <form action="" method="post">
            @csrf
            @auth
                @if ($user->username !== $currentUser->username)
                    <button class="btn btn-primary w-72">Ikuti</button>
                @else
                    <a href="{{ route('profile.show') }}" class="btn btn-outline btn-primary w-72">Edit
                        profile</a>
                @endif
            @else
                <button class="btn btn-primary w-72">Ikuti</button>
            @endauth
        </form>
    </x-container>

    <div class="flex items-center justify-center flex-col lg:flex-row lg:flex-wrap lg:items-start gap-8 mt-8">
        @foreach ($posts as $item)
            <x-card>
                <div class="flex flex-row-reverse justify-between items-center mb-3">
                    <div class="dropdown dropdown-bottom dropdown-end -mx-3">
                        <label tabindex="0" class="btn btn-square btn-outline hover:bg-white border-0">
                            <box-icon name='dots-horizontal-rounded'></box-icon></label>
                        <ul tabindex="0"
                            class="dropdown-content z-[1] menu p-2 shadow-xl border-solid border bg-base-100 rounded-box w-52">
                            @if (!empty($item->photo))
                                <li><a>Download</a></li>
                            @endif
                            <li><a>Salin link</a></li>
                            @auth
                                @if ($item->user->id === Auth::user()->id)
                                    <li><a>Hapus</a></li>
                                @endif
                            @endauth
                        </ul>
                    </div>

                    <a href="{{ route('profile.index', $item->user->username) }}">
                        <div class="card-top flex items-center gap-2">
                            <div class="avatar">
                                <div class="w-9 rounded-full">
                                    <img src="{{ !empty($item->user->photo) ? \Storage::url($item->user->photo) : asset('assets/images/user.jpg') }}"
                                        alt="Profil Penulis" />
                                </div>
                            </div>
                            <div style="line-height: 15px">
                                <div class="text-md font-semibold">{{ $item->user->name }}</div>
                                <small>{{ $item->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </a>
                </div>

                @empty(!$item->photo)
                    <figure>
                        <div>
                            <img draggable="false" src="{{ Storage::url($item->photo) ?? '' }}" alt="Gambar Postingan" />
                        </div>
                    </figure>
                @endempty

                <div class="my-3">
                    <p>{{ $item->body }}</p>
                </div>

                <hr>

                <div class="mt-3 flex gap-3">
                    <button class="flex gap-1 bg-white hover:bg-white border-0">
                        <box-icon name='heart'></box-icon>
                        <p>{{ $item->likes->count() }}</p>
                    </button>
                    <a href="{{ route('post.show', $item->identifier) }}"
                        class="flex gap-1 bg-white hover:bg-white border-0">
                        <box-icon name='message-square-dots'></box-icon>
                        <p>{{ $item->comments->count() }}</p>
                    </a>
                </div>
            </x-card>
        @endforeach
    </div>

</x-app-layout>
