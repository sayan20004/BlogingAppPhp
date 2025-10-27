<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Your Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-xl bg-gray-800 p-10 rounded-3xl shadow-2xl border border-gray-700 text-center">
        
        {{-- Display Success Message from Session --}}
        @if (session('success'))
            <div class="bg-green-600/20 border border-green-500 text-green-300 p-4 rounded-xl mb-6">
                <h3 class="text-2xl font-semibold">{{ session('success') }}</h3>
            </div>
        @endif

        <h1 class="text-4xl font-bold mb-4 text-blue-400">Welcome, {{ Auth::user()->name ?? 'User' }}!</h1>
        <p class="text-gray-400 text-lg mb-8">You are successfully registered and logged in.</p>
        
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4 mb-8">
            
            {{-- LINK to the Posts Queue (Dashboard) --}}
            <a href="{{ route('dashboard') }}" class="inline-block bg-blue-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-700 transition duration-300">
                Go to Post Queue (Dashboard) 📝
            </a>

            {{-- View All Blogs Button --}}
            <a href="{{ route('blogs.index') }}" class="inline-block bg-gray-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-gray-700 transition duration-300">
                View Public Blogs 📰
            </a>
            
        </div>
        
        {{-- Logout Form --}}
        <form action="{{ route('logout') }}" method="POST" class="inline-block">
            @csrf
            <button type="submit" class="bg-red-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-red-700 transition duration-300">
                Logout
            </button>
        </form>
        
    </div>
</body>
</html>