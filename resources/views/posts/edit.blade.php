<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post: {{ $post->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 flex justify-center min-h-screen p-8">
    <div class="w-full max-w-3xl bg-gray-800 p-8 rounded-xl shadow-2xl border border-gray-700">
        <h2 class="text-3xl font-bold mb-6 text-blue-400 text-center">Edit Blog Post</h2>

        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT') <div>
                <label for="title" class="block text-gray-400 font-medium mb-1">Blog Title</label>
                <input type="text" id="title" name="title" required value="{{ old('title', $post->title) }}"
                       class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500">
                @error('title')<p class="text-sm text-red-400 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="description" class="block text-gray-400 font-medium mb-1">Blog Description</label>
                <textarea id="description" name="description" required rows="6"
                          class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500">{{ old('description', $post->description) }}</textarea>
                @error('description')<p class="text-sm text-red-400 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="blog_image" class="block text-gray-400 font-medium mb-1">Blog Image (Current: @if($post->image_path) <a href="{{ asset('storage/'.$post->image_path) }}" target="_blank" class="text-green-400">View</a> @else None @endif)</label>
                <input type="file" id="blog_image" name="blog_image" 
                       class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-blue-600">
                @error('blog_image')<p class="text-sm text-red-400 mt-1">{{ $message }}</p>@enderror
            </div>
            
            <div>
                <label for="status" class="block text-gray-400 font-medium mb-1">Status</label>
                <select id="status" name="status" required
                        class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500">
                    <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft (Private)</option>
                    <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published (Public)</option>
                </select>
                @error('status')<p class="text-sm text-red-400 mt-1">{{ $message }}</p>@enderror
            </div>


            <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-xl hover:bg-green-700 transition-all duration-300">
                Update Blog Post
            </button>
            
            <a href="{{ route('dashboard') }}" class="block text-center text-blue-400 hover:text-blue-300 mt-4">
                ← Back to Dashboard
            </a>
        </form>
    </div>
</body>
</html>