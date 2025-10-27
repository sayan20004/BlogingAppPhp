<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-900 text-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md bg-gray-800 p-8 rounded-3xl shadow-2xl border border-gray-700">
        <h2 class="text-3xl font-bold mb-8 text-center text-gray-100">User Login</h2>

        @if ($errors->any())
            <div class="bg-red-900/20 border border-red-700 text-red-300 p-4 rounded-xl mb-6">
                <p class="font-bold mb-2">Login Failed:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-gray-400 font-medium mb-1">Email</label>
                <input type="email" id="email" name="email" required 
                       value="{{ old('email') }}"
                       class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-gray-500" placeholder="you@example.com">
                @error('email')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-gray-400 font-medium mb-1">Password</label>
                <input type="password" id="password" name="password" required 
                       class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                @error('password')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500">
                    <label for="remember" class="ml-2 block text-sm text-gray-400">Remember me</label>
                </div>
                <a href="#" class="text-sm text-blue-400 hover:text-blue-300">Forgot Password?</a>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition-all duration-300">
                    Log In
                </button>
            </div>
        </form>

        <p class="text-center text-gray-400 text-sm mt-6">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-semibold">Sign up here</a>
        </p>
    </div>
</body>
</html>