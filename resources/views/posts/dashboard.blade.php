<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Add this style block for the initials circle --}}
    <style>
        .initials-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            color: white;
            background: linear-gradient(to bottom right, #3b82f6, #a855f7); /* Default gradient */
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 p-4 md:p-8 min-h-screen">
    <div class="max-w-7xl mx-auto">

        {{-- Profile Pic/Initials and Welcome Message --}}
        <div class="flex items-center justify-between mb-6 flex-wrap gap-4"> {{-- Added gap for wrapping --}}
            <div class="flex items-center space-x-4">
                 {{-- Link wraps the profile image/initials --}}
                 <a href="{{ route('profile.show') }}" title="View/Edit Profile">
                     @if(Auth::user()->profile_image_path)
                         <img src="{{ asset('storage/' . Auth::user()->profile_image_path) }}" alt="Profile Picture" class="w-16 h-16 rounded-full object-cover border-4 border-gray-600 hover:border-blue-500 transition duration-150">
                     @else
                         {{-- Display initials if no profile image --}}
                         <div class="initials-circle w-16 h-16 text-2xl border-4 border-gray-600 hover:border-blue-500 transition duration-150">
                             {{ Auth::user()->initials }} {{-- Uses the getInitialsAttribute from User model --}}
                         </div>
                     @endif
                 </a>
                <h1 class="text-3xl md:text-4xl font-bold text-blue-400">Welcome, {{ Auth::user()->name }}!</h1>
            </div>

             {{-- Action Buttons --}}
             <div class="flex space-x-3 flex-wrap justify-end gap-2"> {{-- Added flex-wrap and gap --}}
                 <a href="{{ route('posts.create') }}" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-150">
                     + New Blog Post
                 </a>
                 <a href="{{ route('blogs.index') }}" class="bg-purple-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-700 transition duration-150">
                     View Public Blogs
                 </a>
                 {{-- Added Profile Button --}}
                 
                 <form action="{{ route('logout') }}" method="POST" class="inline">
                     @csrf
                     <button type="submit" class="bg-red-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700 transition duration-150">
                         Logout
                     </button>
                 </form>
             </div>
        </div>


        @if (session('success'))
            <div class="bg-green-600/20 border border-green-500 text-green-300 p-4 rounded-xl mb-6">{{ session('success') }}</div>
        @endif

        {{-- Stats Bar --}}
        <div class="bg-gray-800 p-4 md:p-6 rounded-xl shadow-lg border border-gray-700 mb-8 flex flex-col sm:flex-row justify-start items-center flex-wrap gap-4"> {{-- Added gap --}}
             <p class="text-lg font-semibold text-gray-300 shrink-0">Your Stats:</p>
            <div class="flex space-x-4 md:space-x-6 text-center flex-wrap gap-2"> {{-- Added flex-wrap and gap --}}
                <div class="p-3 bg-gray-700 rounded-lg min-w-[80px]"> {{-- Added min-width --}}
                    <p class="text-3xl font-bold text-white">{{ $totalPosts }}</p>
                    <p class="text-xs md:text-sm text-gray-400">Total Posts</p>
                </div>
                <div class="p-3 bg-gray-700 rounded-lg min-w-[80px]">
                    <p class="text-3xl font-bold text-green-400">{{ $publishedCount }}</p>
                    <p class="text-xs md:text-sm text-gray-400">Published</p>
                </div>
                <div class="p-3 bg-gray-700 rounded-lg min-w-[80px]">
                    <p class="text-3xl font-bold text-yellow-400">{{ $draftCount }}</p>
                    <p class="text-xs md:text-sm text-gray-400">Drafts</p>
                </div>
            </div>
        </div>

        <h2 class="text-3xl font-bold mb-4 text-blue-300">Your Posts Queue</h2>
        <div class="bg-gray-800 rounded-xl overflow-x-auto shadow-lg border border-gray-700">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($posts as $post)
                        <tr class="hover:bg-gray-700 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                {{ Str::limit($post->title, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($post->status == 'published') bg-green-200 text-green-800 @else bg-yellow-200 text-yellow-800 @endif">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $post->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('posts.edit', $post) }}" class="text-blue-400 hover:text-blue-300 transition duration-150">Edit</a>

                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 transition duration-150">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">You haven't created any posts yet. Start with a new one!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>