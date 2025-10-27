<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modern Registration Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-900 text-gray-100 flex items-center justify-center min-h-screen p-4">
  <div class="w-full max-w-2xl bg-gray-800 p-8 rounded-3xl shadow-2xl border border-gray-700 transform transition-transform duration-500 hover:scale-[1.01]">
    <h2 class="text-3xl font-bold mb-8 text-center text-gray-100">Create an Account</h2>
    
    @if ($errors->any())
        <div class="bg-red-900/20 border border-red-700 text-red-300 p-4 rounded-xl mb-6">
            <p class="font-bold mb-2">Whoops! Please correct the following errors:</p>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
      @csrf 
      <div>
        <h3 class="text-xl font-semibold text-blue-400 mb-4">Personal Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="name" class="block text-gray-400 font-medium mb-1">Full Name</label>
            <input type="text" id="name" name="name" required 
                   value="{{ old('name') }}"
                   class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-gray-500" placeholder="John Doe">
            @error('name')
                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
            @enderror
          </div>
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
            <label for="dob" class="block text-gray-400 font-medium mb-1">Date of Birth</label>
            <input type="date" id="dob" name="dob" required 
                   value="{{ old('dob') }}"
                   class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
            @error('dob')
                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="phone" class="block text-gray-400 font-medium mb-1">Phone Number</label>
            <input type="tel" id="phone" name="phone" required 
                   value="{{ old('phone') }}"
                   class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-gray-500" placeholder="+1 (555) 123-4567">
            @error('phone')
                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>

      <div>
        <h3 class="text-xl font-semibold text-blue-400 mb-4">Address</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="village" class="block text-gray-400 font-medium mb-1">Village</label>
            <input type="text" id="village" name="village" 
                   value="{{ old('village') }}"
                   class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
            @error('village')
                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="post" class="block text-gray-400 font-medium mb-1">Post</label>
            <input type="text" id="post" name="post" 
                   value="{{ old('post') }}"
                   class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
            @error('post')
                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="police_station" class="block text-gray-400 font-medium mb-1">Police Station</label>
            <input type="text" id="police_station" name="police_station" 
                   value="{{ old('police_station') }}"
                   class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
            @error('police_station')
                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="district" class="block text-gray-400 font-medium mb-1">District</label>
            <input type="text" id="district" name="district" 
                   value="{{ old('district') }}"
                   class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
            @error('district')
                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>

      <div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="password" class="block text-gray-400 font-medium mb-1">Password</label>
            <input type="password" id="password" name="password" required class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
            @error('password')
                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="confirm_password" class="block text-gray-400 font-medium mb-1">Confirm Password</label>
            <input type="password" id="confirm_password" name="password_confirmation" required class="w-full bg-gray-700 text-gray-200 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
          </div>
        </div>
      </div>

      <div class="text-center pt-4">
        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-300 transform hover:-translate-y-0.5">
          Register Now
        </button>
      </div>
    </form>
  </div>
</body>
</html>