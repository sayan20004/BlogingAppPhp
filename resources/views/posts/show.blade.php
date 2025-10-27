<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $post->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-gray-800 p-10 rounded-xl shadow-2xl border border-gray-700">
        <a href="{{ route('blogs.index') }}" class="text-blue-400 hover:text-blue-300 mb-6 block">&larr; Back to All Blogs</a>
        
        <h1 class="text-5xl font-extrabold mb-4 text-white">{{ $post->title }}</h1>
        <p class="text-sm text-gray-500 mb-8">
            Published by: <span class="text-blue-400">{{ $post->user->name ?? 'Guest' }}</span> on {{ $post->created_at->format('M d, Y') }}
        </p>
        
        @if ($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover rounded-xl mb-8">
        @endif
        @if ($post->video_path)
            <img src="{{ asset('storage/' . $post->video_path) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover rounded-xl mb-8" type="video/mp4">
        @endif
        
        <div class="prose prose-invert text-gray-300">
            <p class="text-lg whitespace-pre-wrap">{{ $post->description }}</p>
        </div>
    </div>
</body>
</html>