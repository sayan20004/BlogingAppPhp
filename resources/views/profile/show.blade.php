<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $user->name }}'s Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Alpine.js for interactivity --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }

        .initials-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            color: white;
            background: linear-gradient(to bottom right, #3b82f6, #a855f7);
        }

        .form-input {
             width: 100%;
             background-color: #374151; 
             color: #e5e7eb; 
             padding: 0.75rem 1rem; 
             border: 1px solid #4b5563; 
             border-radius: 0.75rem; 
             transition: all 0.3s;
        }
        .form-input:focus {
             outline: none;
             border-color: #3b82f6; 
             box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5); 
        }
        .form-label {
            display: block;
            color: #9ca3af; 
            font-weight: 500; 
            margin-bottom: 0.25rem; 
        }
        .error-text {
            font-size: 0.875rem;
            color: #f87171;
            margin-top: 0.25rem; 
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 p-4 md:p-8 min-h-screen">

    <div class="max-w-4xl mx-auto" x-data="{ editMode: false, profilePreview: null }">


        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 sm:mb-8 gap-4">
             <a href="{{ route('dashboard') }}" class="text-blue-400 hover:text-blue-300 transition duration-150">&larr; Back to Dashboard</a>
             <div class="flex space-x-3">
                <button @click="editMode = !editMode; if (!editMode) profilePreview = null;" {{-- Reset preview on cancel --}}
                        x-text="editMode ? 'Cancel Edit' : 'Edit Profile'"
                        :class="editMode ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-blue-600 hover:bg-blue-700'"
                        class="text-white font-bold py-2 px-4 rounded-lg transition duration-150">
                    Edit Profile
                </button>

                 <form action="{{ route('logout') }}" method="POST">
                     @csrf
                     <button type="submit" class="bg-red-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700 transition duration-150">
                         Logout
                     </button>
                 </form>
             </div>
        </div>


        <div class="bg-gray-800 p-6 md:p-8 rounded-xl shadow-lg border border-gray-700">

            <h1 class="text-3xl font-bold mb-6 text-center text-blue-400">Your Profile</h1>


            @if (session('success'))
                <div class="bg-green-600/20 border border-green-500 text-green-300 p-4 rounded-xl mb-6 text-center">{{ session('success') }}</div>
            @endif


            @if ($errors->any())
                <div class="bg-red-900/20 border border-red-700 text-red-300 p-4 rounded-xl mb-6">
                    <p class="font-bold mb-2">Please correct the errors:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')


                <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6 mb-8">

                    <div class="flex-shrink-0">
                        {{-- Show Preview if available --}}
                        <template x-if="profilePreview">
                            <img :src="profilePreview" alt="Profile Preview" class="w-24 h-24 rounded-full object-cover border-4 border-gray-600">
                        </template>


                         <template x-if="!profilePreview && '{{ $user->profile_image_path }}'">
                             <img src="{{ asset('storage/' . $user->profile_image_path) }}" alt="Profile Picture" class="w-24 h-24 rounded-full object-cover border-4 border-gray-600">
                         </template>


                         <template x-if="!profilePreview && !'{{ $user->profile_image_path }}'">
                            <div class="initials-circle w-24 h-24 text-4xl border-4 border-gray-600">
                                {{ $user->initials }}
                            </div>
                         </template>
                    </div>


                    <div x-show="editMode" x-cloak class="flex-grow w-full sm:w-auto">
                        <label for="profile_image" class="form-label">Change Profile Picture (Image or GIF)</label>
                        <input type="file" id="profile_image" name="profile_image" accept="image/jpeg,image/png,image/gif"
                               class="w-full bg-gray-700 text-gray-200 px-4 py-2 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-blue-600"
                               {{-- Alpine event to handle file selection and preview --}}
                               @change="
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        profilePreview = e.target.result;
                                    };
                                    reader.readAsDataURL($event.target.files[0]);
                               ">
                        @error('profile_image')<p class="error-text">{{ $message }}</p>@enderror
                         <p class="text-xs text-gray-500 mt-1">Max file size: 2MB. Allowed types: JPG, PNG, GIF.</p>
                    </div>
                </div>


                <h3 class="text-xl font-semibold text-blue-400 mb-4 mt-6 border-t border-gray-700 pt-4">Personal Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="form-label">Name</label>
                        <span x-show="!editMode" class="block py-3 px-1 text-gray-100">{{ $user->name }}</span>
                        <input x-show="editMode" x-cloak type="text" id="name" name="name" required value="{{ old('name', $user->name) }}" class="form-input">
                        @error('name')<p x-show="editMode" class="error-text">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="form-label">Email</label>
                         <span x-show="!editMode" class="block py-3 px-1 text-gray-100">{{ $user->email }}</span>
                        <input x-show="editMode" x-cloak type="email" id="email" name="email" required value="{{ old('email', $user->email) }}" class="form-input">
                        @error('email')<p x-show="editMode" class="error-text">{{ $message }}</p>@enderror
                    </div>
                     <div>
                        <label for="dob" class="form-label">Date of Birth</label>
                         <span x-show="!editMode" class="block py-3 px-1 text-gray-100">{{ $user->dob ? $user->dob->format('F j, Y') : 'Not Set' }}</span>
                        <input x-show="editMode" x-cloak type="date" id="dob" name="dob" value="{{ old('dob', $user->dob ? $user->dob->format('Y-m-d') : '') }}" class="form-input" max="{{ now()->format('Y-m-d') }}">
                         @error('dob')<p x-show="editMode" class="error-text">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="phone" class="form-label">Phone</label>
                         <span x-show="!editMode" class="block py-3 px-1 text-gray-100">{{ $user->phone ?? 'Not Set' }}</span>
                        <input x-show="editMode" x-cloak type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input" placeholder="+1234567890">
                         @error('phone')<p x-show="editMode" class="error-text">{{ $message }}</p>@enderror
                    </div>
                </div>


                 <h3 class="text-xl font-semibold text-blue-400 mb-4 mt-8 border-t border-gray-700 pt-4">Address (Optional)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="village" class="form-label">Village</label>
                        <span x-show="!editMode" class="block py-3 px-1 text-gray-100">{{ $user->village ?? 'Not Set' }}</span>
                        <input x-show="editMode" x-cloak type="text" id="village" name="village" value="{{ old('village', $user->village) }}" class="form-input">
                        @error('village')<p x-show="editMode" class="error-text">{{ $message }}</p>@enderror
                    </div>
                     <div>
                        <label for="post" class="form-label">Post Office</label>
                        <span x-show="!editMode" class="block py-3 px-1 text-gray-100">{{ $user->post ?? 'Not Set' }}</span>
                        <input x-show="editMode" x-cloak type="text" id="post" name="post" value="{{ old('post', $user->post) }}" class="form-input">
                         @error('post')<p x-show="editMode" class="error-text">{{ $message }}</p>@enderror
                    </div>
                     <div>
                        <label for="police_station" class="form-label">Police Station</label>
                        <span x-show="!editMode" class="block py-3 px-1 text-gray-100">{{ $user->police_station ?? 'Not Set' }}</span>
                        <input x-show="editMode" x-cloak type="text" id="police_station" name="police_station" value="{{ old('police_station', $user->police_station) }}" class="form-input">
                         @error('police_station')<p x-show="editMode" class="error-text">{{ $message }}</p>@enderror
                    </div>
                     <div>
                        <label for="district" class="form-label">District</label>
                        <span x-show="!editMode" class="block py-3 px-1 text-gray-100">{{ $user->district ?? 'Not Set' }}</span>
                        <input x-show="editMode" x-cloak type="text" id="district" name="district" value="{{ old('district', $user->district) }}" class="form-input">
                         @error('district')<p x-show="editMode" class="error-text">{{ $message }}</p>@enderror
                    </div>
                </div>


                 <div x-show="editMode" x-cloak class="mt-8 border-t border-gray-700 pt-6">
                     <h3 class="text-xl font-semibold text-blue-400 mb-4">Change Password (Leave blank to keep current)</h3>
                     <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                         <div>
                             <label for="current_password" class="form-label">Current Password</label>
                             <input type="password" id="current_password" name="current_password" class="form-input" autocomplete="current-password">
                             @error('current_password')<p class="error-text">{{ $message }}</p>@enderror
                         </div>
                         <div>
                             <label for="new_password" class="form-label">New Password</label>
                             <input type="password" id="new_password" name="new_password" class="form-input" autocomplete="new-password">
                             @error('new_password')<p class="error-text">{{ $message }}</p>@enderror
                         </div>
                         <div>
                             <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                             <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-input" autocomplete="new-password">
                             {{-- No error needed here, 'confirmed' rule handles mismatch --}}
                         </div>
                     </div>
                      <p x-show="editMode" class="text-xs text-gray-500 mt-2">Password must be at least 8 characters, include uppercase, lowercase, numbers, and symbols.</p>
                 </div>



                <div x-show="editMode" x-cloak class="mt-8 text-center border-t border-gray-700 pt-6">
                    <button type="submit" class="bg-green-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-green-700 transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/profile-preview.js') }}"></script>
</body>
</html>