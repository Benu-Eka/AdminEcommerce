<x-guest-layout>
    <div class="max-w-sm mx-auto bg-white p-2">
        <div class="mb-8 text-center">
            <h2 class="text-xl font-extrabold text-gray-900 uppercase tracking-tighter">
                Registrasi <span class="text-red-600">Admin</span>
            </h2>
            <div class="flex items-center justify-center gap-2 mt-1">
                <span class="h-[1px] w-8 bg-red-200"></span>
                <p class="text-[10px] text-gray-500 uppercase tracking-[0.2em] font-medium">Internal System BJL</p>
                <span class="h-[1px] w-8 bg-red-200"></span>
            </div>
        </div>

        <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1" />
                <x-text-input id="nama_lengkap" 
                              class="block mt-1.5 w-full max-w-xs text-sm border-gray-200 focus:border-red-600 focus:ring-red-600/5 py-2.5 shadow-sm rounded-xl placeholder:text-gray-300 transition-all duration-200" 
                              type="text" 
                              name="nama_lengkap" 
                              :value="old('nama_lengkap')" 
                              required 
                              autofocus 
                              placeholder="Nama Lengkap Sesuai ID" />
                <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-1 text-[10px] font-medium" />
            </div>

            <div>
                <x-input-label for="username" :value="__('Username')" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1" />
                <div class="relative mt-1.5">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </span>
                    <x-text-input id="username" 
                                  class="block w-full max-w-xs pl-10 text-sm border-gray-200 focus:border-red-600 focus:ring-red-600/5 py-2.5 shadow-sm rounded-xl placeholder:text-gray-300 transition-all duration-200" 
                                  type="text" 
                                  name="username" 
                                  :value="old('username')" 
                                  required 
                                  placeholder="admin_bjl" />
                </div>
                <x-input-error :messages="$errors->get('username')" class="mt-1 text-[10px] font-medium" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email Perusahaan')" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1" />
                <x-text-input id="email" 
                              class="block mt-1.5 w-full max-w-xs text-sm border-gray-200 focus:border-red-600 focus:ring-red-600/5 py-2.5 shadow-sm rounded-xl placeholder:text-gray-300 transition-all duration-200" 
                              type="email" 
                              name="email" 
                              :value="old('email')" 
                              required 
                              placeholder="admin@bjl-commerce.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-[10px] font-medium" />
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="col-span-1">
                    <x-input-label for="password" :value="__('Password')" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1" />
                    <x-text-input id="password" 
                                  class="block mt-1.5 w-full max-w-xs text-sm border-gray-200 focus:border-red-600 focus:ring-red-600/5 py-2.5 shadow-sm rounded-xl transition-all duration-200"
                                  type="password"
                                  name="password"
                                  required 
                                  placeholder="••••••••"
                                  autocomplete="new-password" />
                </div>

                <div class="col-span-1">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi')" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1" />
                    <x-text-input id="password_confirmation" 
                                  class="block mt-1.5 w-full max-w-xs text-sm border-gray-200 focus:border-red-600 focus:ring-red-600/5 py-2.5 shadow-sm rounded-xl transition-all duration-200"
                                  type="password"
                                  name="password_confirmation" 
                                  placeholder="••••••••"
                                  required />
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-[10px] font-medium" />

            <div class="flex items-center gap-3 p-3 bg-red-50/50 border border-red-100 rounded-xl">
                <div class="flex-shrink-0 bg-red-600 text-white p-1 rounded-md shadow-sm">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[9px] text-red-400 font-bold uppercase tracking-tighter">Otomatis Terdaftar Sebagai</span>
                    <span class="text-[11px] text-red-800 font-bold leading-none">Super Administrator</span>
                </div>
            </div>

            <div class="flex flex-col gap-3 mt-6 pt-5 border-t border-gray-100">
                <button type="submit" class="group relative w-full bg-red-600 hover:bg-red-700 text-white text-[11px] font-bold py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-red-500/20 uppercase tracking-[0.15em] flex items-center justify-center overflow-hidden">
                    <span class="relative z-10">{{ __('Daftar Akun Admin') }}</span>
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                </button>

                <a class="text-center text-[10px] text-gray-400 hover:text-red-600 transition-colors uppercase font-bold tracking-widest" href="{{ route('login') }}">
                    {{ __('Sudah punya akses? Login') }}
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>