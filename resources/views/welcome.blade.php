

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modern Blogging Platform</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Custom CSS for animations */
    .fade-in-up {
      animation: fadeInUp 0.8s ease-out;
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .scale-up {
      transition: transform 0.3s ease;
    }
    .scale-up:hover {
      transform: scale(1.03);
    }
  </style>
</head>
<body class="bg-gray-900 text-gray-100">

  <header class="bg-gray-800 shadow-lg fixed w-full z-10">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-3xl font-extrabold text-blue-400">Blog<span class="text-purple-400">Sphere</span></h1>
      <nav class="space-x-4 flex items-center">
        <a href="#blog-peek" class="text-gray-300 hover:text-blue-400 transition">Recent Posts</a>
        <a href="{{ route('blogs.index') }}" class="text-gray-300 hover:text-blue-400 transition">All Blogs</a>
        
        @auth
          <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-green-500 text-white font-semibold rounded-full shadow hover:bg-green-600 transition">
            Dashboard
          </a>
          <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-sm text-red-400 hover:text-red-300 transition">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-full shadow hover:bg-purple-700 transition">
            Login
          </a>
          <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-full shadow hover:bg-blue-700 transition">
            Register
          </a>
        @endauth
      </nav>
    </div>
  </header>

  <section class="pt-40 pb-24 text-center bg-gray-900 overflow-hidden">
    <div class="max-w-4xl mx-auto px-6">
      <h2 class="text-5xl md:text-7xl font-extrabold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 fade-in-up">
        Share Your Story. Instantly.
      </h2>
      <p class="text-xl md:text-2xl mb-10 text-gray-400 fade-in-up" style="animation-delay: 0.2s;">
        The fastest way for creators to connect, write, and publish engaging content to the world.
      </p>
      
      @auth
        <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-green-500 text-white font-bold text-lg rounded-xl shadow-lg hover:bg-green-600 transition scale-up fade-in-up" style="animation-delay: 0.4s;">
          Go to Dashboard
        </a>
      @else
        <a href="{{ route('register') }}" class="px-8 py-4 bg-blue-600 text-white font-bold text-lg rounded-xl shadow-lg hover:bg-blue-700 transition scale-up fade-in-up" style="animation-delay: 0.4s;">
          Start Writing Now! (It's Free)
        </a>
      @endauth
    </div>
  </section>
  
  <section id="blog-peek" class="py-20 max-w-7xl mx-auto px-6 bg-gray-800 rounded-xl shadow-2xl mb-20">
    <h3 class="text-4xl font-extrabold text-center mb-16 text-blue-300">Latest Community Insights</h3>
    
    <div class="grid md:grid-cols-3 gap-10">
      @forelse ($posts as $post)
        <div class="bg-gray-900 p-6 rounded-3xl shadow-xl border border-gray-700 hover:border-blue-500 transition scale-up">
          @if ($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="h-40 w-full object-cover rounded-xl mb-4">
          @else
            <div class="h-40 bg-gray-700 rounded-xl mb-4 flex items-center justify-center text-gray-500">No Image</div>
          @endif
          <h4 class="text-xl font-bold mb-3 text-white">{{ $post->title }}</h4>
          <p class="text-gray-400 text-sm mb-4">{{ Str::limit($post->description, 70) }}</p>
          <p class="text-xs text-blue-500">By {{ $post->user->name ?? 'Guest' }}</p>
        </div>
      @empty
        <p class="text-center text-gray-500 col-span-3">No posts published yet. Be the first to start a discussion!</p>
      @endforelse
    </div>
    
    <div class="text-center mt-12">
        <a href="{{ route('blogs.index') }}" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-full shadow hover:bg-purple-700 transition">
            View All {{ count($posts) > 0 ? count($posts) : '' }} Posts
        </a>
    </div>
  </section>

  <section id="features" class="py-20 max-w-6xl mx-auto px-6">
    <h3 class="text-3xl font-extrabold text-center mb-12 text-blue-400">Why BlogSphere?</h3>
    <div class="grid md:grid-cols-3 gap-8">
      <div class="bg-gray-800 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition scale-up border border-gray-700">
        <h4 class="text-2xl font-semibold mb-3 text-white">⚡ Instant Publishing</h4>
        <p class="text-gray-400">Zero lag. Get your ideas from mind to worldwide in seconds.</p>
      </div>
      <div class="bg-gray-800 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition scale-up border border-gray-700">
        <h4 class="text-2xl font-semibold mb-3 text-white">🎨 Elegant Design</h4>
        <p class="text-gray-400">Beautiful, responsive designs ensure your content always looks professional.</p>
      </div>
      <div class="bg-gray-800 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition scale-up border border-gray-700">
        <h4 class="text-2xl font-semibold mb-3 text-white">🔒 Secure Platform</h4>
        <p class="text-gray-400">Built on Laravel, offering robust security for all user data and interactions.</p>
      </div>
    </div>
  </section>

  <footer class="bg-gray-900 text-gray-500 py-10 text-center border-t border-gray-800 mt-10">
    <p>© 2025 BlogSphere. All rights reserved.</p>
    <p class="text-sm mt-2">Built with Laravel & Tailwind CSS.</p>
  </footer>

</body>
</html>