<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Blog Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-bold mb-10 text-center text-blue-400">Latest Blogs</h1>
        
        <div class="flex justify-end mb-6 space-x-4">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
                    Log In to Post
                </a>
            @endauth
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($posts as $post)
                <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-700 flex flex-col">
                    @if ($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="h-48 w-full object-cover">
                    @endif
                    
                    @if ($post->video_path)
            <div class="w-full mb-8">
                <h3 class="text-xl font-semibold mb-3 text-blue-300">Video Content</h3>
                <video controls class="w-full rounded-xl shadow-lg border-2 border-gray-700">
                    <source src="{{ asset('storage/' . $post->video_path) }}" type="video/mp4"> 
                    Your browser does not support the video tag.
                </video>
            </div>
        @endif
                    <div class="p-6 flex flex-col flex-grow">
                        <h2 class="text-xl font-bold mb-3 text-white">{{ $post->title }}</h2>
                        
                        <p class="text-gray-400 text-sm mb-4 flex-grow">{{ Str::limit($post->description, 100) }}</p>
                        
                        <a href="{{ route('blogs.show', $post) }}" class="text-blue-500 hover:text-blue-400 font-semibold text-sm mb-4">
                            Read More &rarr;
                        </a>
                        
                        <div class="mt-auto pt-4 border-t border-gray-700 text-xs text-gray-500">
                            By: <span class="text-blue-400">{{ $post->user->name ?? 'Guest' }}</span> on {{ $post->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 col-span-full">No blog posts found. Be the first to post!</p>
            @endforelse
        </div>
    </div>
</body>
</html>