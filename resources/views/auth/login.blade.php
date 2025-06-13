<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100 flex justify-center items-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg flex w-3/4 max-w-4xl">
        <!-- Form Section -->
        <div class="w-1/2 p-8">
            <div class="flex flex-col items-center">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-16 h-16">
                <h2 class="text-2xl font-bold mt-2">Log in</h2>

                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4 w-full">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            
            <form action="{{ route('login') }}" method="POST" class="mt-6">
                @csrf
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>

                <label class="block text-gray-700 mt-4">Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>

                <div class="flex items-center justify-between mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2">
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="text-red-400">Forgot password?</a>
                </div>

                <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-lg mt-4 hover:bg-red-600">
                    Login
                </button>
            </form>
        </div>

        <!-- Image Section -->
        <div class="w-1/2 bg-white relative flex justify-center items-center">
            <img src="{{ asset('images/bg.jpg') }}" class="absolute w-full h-full object-cover opacity-75">
            <img src="{{ asset('images/person.png') }}" class="relative w-2/3">
        </div>
    </div>

</body>
</html>
