<x-app-layout>
    <x-slot name="title">
        {{ $user->name . ' ' . '(' . $user->username . ')' }}
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="bg-base-100 rounded-xl shadow-lg">
                <div class="flex flex-col w-full lg:flex-row py-5">
                    <div class="grid flex-grow w-36 rounded-box place-items-center lg:place-content-start">
                        <div class="ps-10">
                            <h4 class="font-semibold">Update Photo</h4>
                            <small>
                                Update your account's photo.
                            </small>
                        </div>
                    </div>
                    <div class="grid flex-grow rounded-box place-items-center">
                        <div class="indicator">
                            <div>
                                <div class="indicator-item indicator-bottom top-16 left-14">
                                    <label for="photoInput" class="btn btn-primary btn-sm btn-circle"><box-icon
                                            type='solid' name='edit' color='white'></box-icon></label>
                                    <input type="file" name="photo" id="photoInput" style="display: none;"
                                        accept="image/*">
                                    <input type="submit" style="display: none;" id="submitButton">
                                </div>
                                <div class="avatar" id="imagePreview">
                                    <div class="w-36 rounded-full shadow-md">
                                        <img id="imagePreview" class="rounded-full border" draggable="false"
                                            src="{{ !empty($user->photo) ? \Storage::url($user->photo) : asset('assets/images/user.jpg') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-base-100 rounded-xl shadow-lg mt-8">
                <div class="flex flex-col w-full lg:flex-row py-5">
                    <div class="grid flex-grow w-36 rounded-box place-items-center lg:place-content-start">
                        <div class="ps-10">
                            <h4 class="font-semibold">Profile Information</h4>
                            <small>
                                Update your account's profile information and username.
                            </small>
                        </div>
                    </div>
                    <div class="grid flex-grow rounded-box place-items-center">
                        <div class="form-control w-full px-10">
                            <label class="label">
                                <span class="label-text">Nama</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="input input-bordered @error('name') input-error @enderror" />
                            <label class="label">
                                @error('name')
                                    <small class="label-text text-red-600">{{ $message }}</small>
                                @enderror
                            </label>

                            <label class="label">
                                <span class="label-text">Username</span>
                            </label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                class="input input-bordered @error('username') input-error @enderror" />
                            <label class="label">
                                @error('username')
                                    <small class="label-text text-red-600">{{ $message }}</small>
                                @enderror
                            </label>
                            <button class="btn btn-primary btn-sm w-20 ms-auto">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-base-100 rounded-xl shadow-lg mt-8">
                <div class="flex flex-col w-full lg:flex-row py-5">
                    <div class="grid flex-grow w-36 rounded-box place-items-center lg:place-content-start">
                        <div class="ps-10">
                            <h4 class="font-semibold">Update Password</h4>
                            <small>
                                Ensure your account is using a long, random password to stay secure.
                            </small>
                        </div>
                    </div>
                    <div class="grid flex-grow rounded-box place-items-center">
                        <div class="form-control w-full px-10">
                            <label class="label">
                                <span class="label-text">Password</span>
                            </label>
                            <input type="password" name="old_password"
                                class="input input-bordered @error('old_password') input-error @enderror" />
                            <label class="label">
                                @error('old_password')
                                    <small class="label-text text-red-600">{{ $message }}</small>
                                @enderror
                            </label>

                            <label class="label">
                                <span class="label-text">Password baru</span>
                            </label>
                            <input type="password" name="password"
                                class="input input-bordered @error('password') input-error @enderror" />
                            <label class="label">
                                @error('password')
                                    <small class="label-text text-red-600">{{ $message }}</small>
                                @enderror
                            </label>

                            <label class="label">
                                <span class="label-text">Konfirmasi Password</span>
                            </label>
                            <input type="password" name="password_confirmation"
                                class="input input-bordered @error('password_confirmation') input-error @enderror" />
                            <label class="label">
                                @error('password_confirmation')
                                    <small class="label-text text-red-600">{{ $message }}</small>
                                @enderror
                            </label>
                            <button class="btn btn-primary btn-sm w-20 ms-auto">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const photoInput = document.getElementById("photoInput");
            photoInput.addEventListener("change", function() {
                const submitButton = document.getElementById("submitButton");
                submitButton.style.display = "none";

                submitButton.click();
            });
        });
    </script>
@endpush
