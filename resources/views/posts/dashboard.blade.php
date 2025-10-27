<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 p-8 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold mb-6 text-blue-400">Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>

        @if (session('success'))
            <div class="bg-green-600/20 border border-green-500 text-green-300 p-4 rounded-xl mb-6">{{ session('success') }}</div>
        @endif
        
        <div class="bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700 mb-8 flex justify-between items-center flex-wrap">
            <div class="flex space-x-6 text-center">
                <div class="p-3 bg-gray-700 rounded-lg">
                    <p class="text-3xl font-bold text-white">{{ $totalPosts }}</p>
                    <p class="text-sm text-gray-400">Total Posts</p>
                </div>
                <div class="p-3 bg-gray-700 rounded-lg">
                    <p class="text-3xl font-bold text-green-400">{{ $publishedCount }}</p>
                    <p class="text-sm text-gray-400">Published</p>
                </div>
                <div class="p-3 bg-gray-700 rounded-lg">
                    <p class="text-3xl font-bold text-yellow-400">{{ $draftCount }}</p>
                    <p class="text-sm text-gray-400">Drafts</p>
                </div>
            </div>
            
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="{{ route('posts.create') }}" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                    + New Blog Post
                </a>
                <a href="{{ route('blogs.index') }}" class="bg-purple-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-700 transition">
                    View Public Blogs
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
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
                        <tr class="hover:bg-gray-700 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                {{ Str::limit($post->title, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($post->status == 'published') bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $post->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('posts.edit', $post) }}" class="text-blue-400 hover:text-blue-300">Edit</a>
                                
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
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