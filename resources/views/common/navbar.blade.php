<nav class="bg-gray-800 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold">MyApp</a>
            </div>

            <!-- Links -->
            <div class="hidden md:flex space-x-6 items-center">
                <a href="{{ url('/') }}" class="hover:text-gray-300">Home</a>
                <a href="{{ url('/about') }}" class="hover:text-gray-300">About</a>
                <a href="{{ url('/services') }}" class="hover:text-gray-300">Services</a>
                <a href="{{ url('/contact') }}" class="hover:text-gray-300">Contact</a>
            </div>

            <!-- Right side (Auth/User) -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <span>Hi, {{ Auth::user()->name }}</span>
                    <form method="POST" ">
                        @csrf
                        <button type="submit" class="hover:text-gray-300">Logout</button>
                    </form>
                @else
                    <a class="hover:text-gray-300">Login</a>
                    <a class="hover:text-gray-300">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>