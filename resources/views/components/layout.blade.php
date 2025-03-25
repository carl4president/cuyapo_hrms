<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUYAPO HRMS</title>
    @vite('resources/css/app.css')
</head>
<body>
<nav id="scrollspy-navbar" class="bg-blue-600 sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="relative flex h-16 items-center justify-between">
      <!-- Logo -->
      <div class="flex items-center">
        <a href="#" class="flex-shrink-0">
          <img class="h-10 w-auto rounded-full" src="{{ URL::to('assets/img/logo.png')}}" alt="Logo">
        </a>
      </div>

      <!-- Mobile menu button -->
      <div class="absolute inset-y-0 right-0 flex items-center sm:hidden">
        <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 text-white hover:bg-blue-700 focus:ring-2 focus:ring-white focus:outline-none">
          <svg id="menu-icon" class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
          <svg id="close-icon" class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Navbar Links with ScrollSpy -->
      <div id="scrollspy-links" class="hidden sm:flex sm:ml-auto" data-hs-scrollspy="#scrollspy-content" data-hs-scrollspy-scrollable-parent="#scrollspy-container">
        <ul class="flex space-x-6">
          <li><a href="#banner" class="text-white hover:text-gray-300 hs-scrollspy-active:text-yellow-400">Home</a></li>
          <li><a href="#vision-mission" class="text-white hover:text-gray-300 hs-scrollspy-active:text-yellow-400">Vision/Mission</a></li>
          <li><a href="#history" class="text-white hover:text-gray-300 hs-scrollspy-active:text-yellow-400">History</a></li>
          <li><a href="#contact" class="text-white hover:text-gray-300 hs-scrollspy-active:text-yellow-400">Contact</a></li>
          <li><a href=" {{ route('login') }}" class="text-white hover:text-gray-300 hs-scrollspy-active:text-yellow-400">Login</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Mobile menu -->
  <div id="mobile-menu" class="hidden sm:hidden">
    <div class="space-y-2 px-4 py-3 bg-blue-700">
      <a href="#banner" class="block text-white hover:text-gray-300 hs-scrollspy-active:text-yellow-400">Home</a>
      <a href="#vision-mission" class="block text-white hover:text-gray-300 hs-scrollspy-active:text-yellow-400">Vision/Mission</a>
      <a href="#history" class="block text-white hover:text-gray-300 hs-scrollspy-active:text-yellow-400">History</a>
      <a href="#contact" class="block text-white hover:text-gray-300 hs-scrollspy-active:text-yellow-400">Contact</a>
      <a href="/login" class="block text-white hover:text-gray-300 hs-scrollspy-active:text-yellow-400">Login</a>
    </div>
  </div>
</nav>

    <main>
       {{ $slot }}
    </main>
<script>
  const el = HSScrollspy.getInstance('[data-hs-scrollspy="#scrollspy-1"]', true);
  const collapse = HSCollapse.getInstance('[data-hs-collapse="#navbar-collapse-basic"]', true);

  el.element.on('beforeScroll', (instance) => {
    return new Promise((res) => {
      if (collapse.element.el.classList.contains('open')) {
        collapse.element.hide();
        HSStaticMethods.afterTransition(collapse.element.content, () => res(true));
      } else {
        res(true);
      }
    });
  });
</script>
</body>
</html>