<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>

    <div class="flex items-center justify-center flex-col lg:flex-row lg:flex-wrap lg:items-center gap-8">
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
                            <li><a>Report</a></li>
                            @auth
                                @if ($item->user->id === Auth::user()->id)
                                    <li>
                                        <form action="{{ route('post.delete', $item->identifier) }}" class="w-full"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="pr-28" type="submit">Hapus</button>
                                        </form>
                                    </li>
                                @endif
                            @endauth
                        </ul>
                    </div>

                    <a href="{{ route('profile.index', $item->user->username) }}">
                        <div class="card-top flex items-center gap-2">
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
                        </div>
                    </a>
                </div>

                @empty(!$item->photo)
                    <figure>
                        <div class="flex items-center justify-center">
                            <img draggable="false" class="h-[300px] object-cover object-center" src="{{ Storage::url($item->photo) ?? '' }}" alt="">
                        </div>
                    </figure>
                @endempty

                <div class="my-3">
                    <p>{{ $item->body }}</p>
                </div>

                <hr>

                <div class="mt-3 flex gap-3">
                    <form action="{{ route('post.like', $item->id) }}" method="post">
                        @csrf
                        <button class="flex gap-1 bg-white hover:bg-white border-0">
                            @php
                                $userLiked = $item->likes->contains('user_id', auth()->id());
                            @endphp
                            <box-icon name='heart' color='{{ $userLiked ? 'red' : '' }}'
                                type='{{ $userLiked ? 'solid' : '' }}'></box-icon>
                            <p>{{ $item->likes->count() }}</p>
                        </button>
                    </form>
                    <a href="{{ route('post.show', $item->identifier) }}"
                        class="flex gap-1 bg-white hover:bg-white border-0">
                        <box-icon name='message-square-dots'></box-icon>
                        <p>{{ $item->comments->count() }}</p>
                    </a>
                </div>
            </x-card>
        @endforeach
    </div>

    <dialog id="my_modal_3" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="pb-3 font-bold text-lg">Post</h3>
            <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-control mb-3">
                    <textarea name="body" class="textarea textarea-bordered @error('body') textarea-error @enderror"
                        placeholder="apa yg anda pikirkan?"></textarea>
                    @error('body')
                        <label class="label">
                            <small class="label-text text-red-600">{{ $message }}</small>
                        </label>
                    @enderror
                </div>
                <div class="form-control" tabindex="-100">
                    <input type="file" tabindex="-100" name="photo" class="dropify"
                        data-allowed-file-extensions="jpg png jpeg" />
                    @error('photo')
                        <label class="label">
                            <small class="label-text text-red-600">{{ $message }}</small>
                        </label>
                    @enderror
                </div>
                <div class="form-control mt-6">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </dialog>

    <div class="fixed right-0 bottom-0 mb-16 mr-5 lg:mr-16">
        <button onclick="my_modal_3.showModal()" class="btn btn-primary btn-circle grid place-items-center">
            <box-icon name='plus' size='md' color='white'></box-icon>
        </button>
    </div>

</x-app-layout>

@push('scripts')
    <script>
        $(document).click()
    </script>
@endpush
