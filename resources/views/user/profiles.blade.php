<x-layout>



@error('password')
<p class="fixed top-28 left-1/2 translate-x-[-50%] bg-red-300 text-white py-2 px-4">{{ $message }}</p>
@enderror
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <!-- Header -->
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Who's using SaveSmart?</h1>
        <div id="password-form" class="fixed z-10 inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-2xl font-bold mb-4 text-center">Enter Password</h2>
                <form action="" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input type="password" id="profile-password" name="password" inputmode="numeric" pattern="[0-9]*" maxlength="4"
                            placeholder="Enter 4-digit password"
                            class="w-full text-center text-2xl p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required maxlength="4" inputmode="numeric">
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Submit
                    </button>
                    <button
                        class="w-full mt-1 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        onclick="event.preventDefault(); closePasswordForm()">
                        Cancel
                    </button>
                </form>
            </div>
        </div>
        <!-- Profiles Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
            @foreach (Auth::user()->profiles as $profile)
                <div class="group relative flex flex-col items-center">

                    <div class="w-32 h-32 cursor-pointer rounded-full overflow-hidden border-4 border-transparent group-hover:border-blue-500 transition-all duration-200"
                        onclick="openPasswordForm({{ json_encode($profile->id) }})">
                        <img src="{{ $profile->avatar }}" alt="{{ $profile->username }}"
                            class="w-full h-full object-cover">
                    </div>
                    <span class="mt-2 text-lg text-gray-900 group-hover:text-blue-500">{{ $profile->name }}</span>

                    <button onclick="showDeleteProfileModal({{ json_encode($profile->id) }})"
                        class="delete-btn absolute top-0 right-0 bg-red-500 text-white rounded-full p-2 hidden group-hover:block">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            @endforeach

            <!-- Add Profile Button -->
            <button onclick="showCreateProfileModal()" class="flex flex-col items-center cursor-pointer">
                <div
                    class="w-32 h-32 rounded-full border-4 border-gray-200 flex items-center justify-center hover:border-blue-500 transition-all duration-200">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <span class="mt-2 text-lg text-gray-900">Add Profile</span>
            </button>
        </div>

        <!-- Manage Profiles Button -->
        <button id="manageProfilesBtn" onclick="toggleManageMode()"
            class="px-6 py-2 border-2 border-gray-800 text-gray-800 rounded-md hover:bg-gray-800 hover:text-white transition-colors duration-200">
            Manage Profiles
        </button>
    </div>

    <!-- Create Profile Modal -->
    <div id="createProfileModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <h2 class="text-2xl font-bold mb-6">Create Profile</h2>
            <form id="createProfileForm" action="/user/profiles" method="POST" class="space-y-6"
                enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                    <div class="flex items-center space-x-4">
                        <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-200">
                            <img id="previewImage"
                                src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png">
                        </div>
                        <input type="file" id="profileImage" name="avatar" accept="image/*" class="hidden">
                        <button type="button" onclick="document.getElementById('profileImage').click()"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Choose Image
                        </button>
                    </div>
                </div>
                <div>
                    <label for="profileName" class="block text-sm font-medium text-gray-700 mb-2">username</label>
                    <input type="text" id="profileName" name="username"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">password</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required maxlength="4" inputmode="numeric">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">confirm
                        password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required maxlength="4" inputmode="numeric">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="hideCreateProfileModal()"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Create Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Profile Modal -->
    <form action="" method="POST" id="deleteProfileModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        @csrf
        @method('DELETE')
        <input type="hidden">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <h2 class="text-2xl font-bold mb-6">Delete Profile</h2>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this profile? This action cannot be undone.
            </p>
            <div class="flex justify-end space-x-4">
                <button onclick="event.preventDefault(); hideDeleteProfileModal();"
                    class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                    Delete Profile
                </button>
            </div>
        </div>
    </form>

    <script>
        let isManageMode = false;
        let currentProfileId = null;

        // Profile Image Preview
        document.getElementById('profileImage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Modal Controls
        function showCreateProfileModal() {
            document.getElementById('createProfileModal').classList.remove('hidden');
        }

        function hideCreateProfileModal() {
            document.getElementById('createProfileModal').classList.add('hidden');
            document.getElementById('createProfileForm').reset();
            document.getElementById('previewImage').src =
                'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png';
        }

        function showDeleteProfileModal(profileId) {
            currentProfileId = profileId;
            document.getElementById('deleteProfileModal').classList.remove('hidden');
        }

        function hideDeleteProfileModal() {
            document.getElementById('deleteProfileModal').classList.add('hidden');
            currentProfileId = null;
        }

        $deleteProfileModal = document.getElementById('deleteProfileModal');
        $deleteProfileModal.addEventListener('submit', function(e) {
            e.preventDefault();
            e.target.setAttribute('action', `/user/profiles/${currentProfileId}`);
            e.target.submit();
        })


        function toggleManageMode() {
            isManageMode = !isManageMode;
            const profiles = document.querySelectorAll('.profile-item');
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const manageButton = document.getElementById('manageProfilesBtn');

            profiles.forEach(profile => {
                if (isManageMode) {
                    profile.onclick = (e) => e.preventDefault();
                    profile.classList.add('cursor-default');
                } else {
                    profile.onclick = null;
                    profile.classList.remove('cursor-default');
                }
            });

            deleteButtons.forEach(btn => {
                btn.style.display = isManageMode ? 'block' : 'none';
            });

            manageButton.textContent = isManageMode ? 'Cancel' : 'Manage Profiles';
        }

        const passwordForm = document.getElementById('password-form');

        function openPasswordForm(id) {
            passwordForm.querySelector('form').setAttribute('action', `/user/profiles/${id}`);
            passwordForm.classList.remove('hidden');
        }

        function closePasswordForm() {
            passwordForm.querySelector('form').reset();
            passwordForm.classList.add('hidden');
        }

        document.getElementById("profile-password").addEventListener("input", validatePassword);

        document.getElementById("password_confirmation").addEventListener("input", validatePassword);

        document.getElementById("password").addEventListener("input", validatePassword);

        function validatePassword(){
            this.value = this.value.replace(/\D/g, "");
            if (this.value.length > 4) {
                this.value = this.value.slice(0, 4);
            }
        }

    </script>


</x-layout>
