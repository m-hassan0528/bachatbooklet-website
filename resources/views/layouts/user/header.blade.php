   <!-- Header/Navigation -->
   <nav class="bg-white shadow-md sticky top-0 z-50">
       <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
           <div class="flex justify-between items-center h-20">
               <!-- Logo 
               <div class="flex-shrink-0 flex items-center">
                   <a href="/" class="flex items-center">
                       <span class="text-3xl font-bold text-primary">Bachat</span>
                       <span class="text-3xl font-bold text-gray-800">Booklet</span>
                   </a>
               </div> -->

               <div class="flex-shrink-0 flex items-center">
                   <a href="{{ route('home') }}">
                       <img class="booklet-logo" src="{{ asset('images/booklet-logo-3.png') }}"
                           alt="Bachat Booklet Logo">
                   </a>
               </div>

               <!-- Navigation Links -->
               <div class="hidden md:flex items-center space-x-8">
                   <a href="{{ route('category') }}" class="text-gray-700 hover:text-primary font-medium transition">
                       Categories
                   </a>
                   <a href="#how-it-works" class="text-gray-700 hover:text-primary font-medium transition">How It
                       Works</a>
                   <a href="#order-book" class="text-gray-700 hover:text-primary font-medium transition">Order Book</a>
                   @if (Route::has('login'))
                   @auth
                   <a href="{{ url('/dashboard') }}"
                       class="text-gray-700 hover:text-primary font-medium transition">Dashboard</a>
                   @else
                   <a href="{{ route('login') }}"
                       class="bg-primary text-white px-6 py-2 rounded-full hover:bg-primary font-medium transition">Admin
                       Login</a>
                   @endauth
                   @endif
               </div>

               <!-- Mobile menu button -->
               <div class="md:hidden">
                   <button type="button" class="text-gray-700 hover:text-primary">
                       <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                               d="M4 6h16M4 12h16M4 18h16" />
                       </svg>
                   </button>
               </div>
           </div>
       </div>
   </nav>