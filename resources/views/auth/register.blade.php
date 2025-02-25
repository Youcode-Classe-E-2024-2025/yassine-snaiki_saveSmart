<x-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Register for SmartSave
                </h2>
            </div>
            @if ($errors->any())
                <div class=" text-center text-red-400">
                    <h2>
                        {{ $errors->first('message') }}
                    </h2>
                </div>
            @endif
            <form method="POST" action="register" class="mt-8 space-y-6">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('username')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('email')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('password')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirm
                        Password</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('password-confirm')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Register
                    </button>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <hr class="w-full border-gray-300">
                    <span class="px-3 text-gray-500 text-sm">or</span>
                    <hr class="w-full border-gray-300">
                </div>

                <div>
                    <a href="/auth/google"
                        class="group relative w-full flex justify-center py-2 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M23.494 12.27c0-.81-.07-1.56-.2-2.3h-10.6v4.37h6.16c-.27 1.38-1.1 2.54-2.35 3.32v2.77h3.77c2.21-2.04 3.47-5.04 3.47-8.16z" />
                            <path
                                d="M12 24c3.24 0 5.95-1.08 7.93-2.92l-3.77-2.77c-1.05.7-2.37 1.13-3.77 1.13-2.92 0-5.39-1.97-6.28-4.63H1.21v2.86C3.19 20.35 7.24 24 12 24z" />
                            <path
                                d="M5.72 14.88c-.25-.7-.39-1.44-.39-2.22s.14-1.52.39-2.22V7.59H1.21C.44 9.17 0 10.91 0 12.66c0 1.74.44 3.48 1.21 5.07l4.51-2.85z" />
                            <path
                                d="M12 4.84c1.74 0 3.29.6 4.52 1.78l3.36-3.36C17.95 1.02 15.24 0 12 0 7.24 0 3.19 3.64 1.21 7.59l4.51 2.85c.89-2.66 3.36-4.63 6.28-4.63z" />
                        </svg>
                        Continue with Google
                    </a>
                </div>

                <div class="text-center">
                    <a href="login" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Already have an account? Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>
