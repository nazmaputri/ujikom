<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">
    <style>
  </style>
</head>
<body>
   <!-- ========== HEADER ========== -->
<header class="flex flex-wrap fixed md:justify-start md:flex-nowrap z-50 w-full py-2 bg-white shadow-md">
  <nav class="relative max-w-7xl w-full flex flex-wrap md:grid md:grid-cols-12 basis-full items-center px-4 md:px-12 mx-auto">
    <div class="md:col-span-3 flex items-center gap-2">
      <!-- Logo -->
       <div class="">
        <img src="{{ asset('storage/eduflix.png') }}" alt="image description" class="rounded-full bg-white w-12 h-12">
       </div>
      <!-- End Logo -->

      <!-- Teks hanya muncul di layar md ke atas -->
      <span class="md:block text-lg font-semibold text-sky-600">EduFlix</span>
    </div>

    <!-- Button Group -->
    <div class="flex items-center gap-x-1 md:gap-x-2 ms-auto py-1 md:order-3 md:col-span-3">
    <!-- Tombol Account -->
    <a href="/login" type="button" class="py-2 px-4 md:border-1 md:hover:bg-sky-600 border border-sky-600 md:border-sky-600 inline-flex items-center gap-x-2 text-sm font-medium rounded-xl md:rounded-full focus:outline-none transition ease-in-out duration-300">
        <!-- Teks Account hanya tampil di layar medium ke atas -->
        <span class="hidden md:block text-gray-700 hover:text-white">Masuk</span>
        <!-- Ikon hanya tampil di layar kecil -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-sky-400 block md:hidden w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
    </a>

      <div class="md:hidden">
        <button type="button" id="menu-toggle" class="hs-collapse-toggle size-[38px] flex justify-center items-center text-sm font-semibold rounded-xl border z text-orange hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-sky-400 dark:border-sky-400 dark:hover:bg-sky-400 dark:focus:bg-white" id="hs-navbar-hcail-collapse" aria-expanded="false" aria-controls="hs-navbar-hcail" aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-hcail">
          <svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
          <svg class="hs-collapse-open:block hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
      </div>
    </div>
    <!-- End Button Group -->

    <!-- Collapse -->
    <div id="hs-navbar-hcail" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block md:w-auto md:basis-auto md:order-2 md:col-span-6 bg-navbar-default md:bg-transparent rounded-lg pl-4 pb-4 pt-2 z-50 mt-2" aria-labelledby="hs-navbar-hcail-collapse">
      <div class="flex flex-col gap-y-4 gap-x-0 mt-5 md:flex-row md:justify-center md:items-center md:gap-y-0 md:gap-x-7 md:mt-0">
        <div>
          <a href="#home" class="relative inline-block hover:text-sky-600 focus:outline-none text-gray-700 transition-all duration-300 hover:translate-y-[-2px]" href="#" aria-current="page" id="link-home">Beranda</a>
        </div>
        <div>
          <a href="#about" class="inline-block hover:text-sky-600 focus:outline-none text-gray-700 transition-all duration-300 hover:translate-y-[-2px]" id="link-about">Tentang</a>
        </div>
        <div>
          <a href="#category" class="inline-block hover:text-sky-600 focus:outline-none text-gray-700 transition-all duration-300 hover:translate-y-[-2px]"id="link-category">Kategori</a>
        </div>
        <div>
            <a href="#price" class="inline-block hover:text-sky-600 focus:outline-none text-gray-700 transition-all duration-300 hover:translate-y-[-2px]"id="link-price">Harga</a>
        </div>
        <div>
            <a href="#rating" class="inline-block hover:text-sky-600 focus:outline-none text-gray-700 transition-all duration-300 hover:translate-y-[-2px]"id="link-rating">Rating</a>
          </div>
      </div>
    </div>
    <!-- End Collapse -->
  </nav>
</header>
<!-- ========== END HEADER ========== -->
</body>
</html>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const menuToggle = document.getElementById('menu-toggle');
  const menu = document.getElementById('hs-navbar-hcail');
  const openIcon = menuToggle.querySelector('.hs-collapse-open\\:hidden');
  const closeIcon = menuToggle.querySelector('.hs-collapse-open\\:block');
  const sections = ['home', 'about', 'category', 'price', 'rating'];
  const links = sections.map(section => document.getElementById('link-' + section));

  menuToggle.addEventListener('click', function () {
    if (window.innerWidth < 768) {
      if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        menu.style.maxHeight = menu.scrollHeight + 'px';
        menu.classList.add('bg-sky-100');
      } else {
        menu.style.maxHeight = '0px';
        setTimeout(() => {
          menu.classList.add('hidden');
        }, 300);
      }
      openIcon.classList.toggle('hidden');
      closeIcon.classList.toggle('hidden');
    }
  });

  window.addEventListener('resize', function () {
    if (window.innerWidth >= 768) {
      menu.style.maxHeight = 'none';
      menu.classList.remove('hidden');
      menu.classList.remove('bg-sky-100');
      openIcon.classList.remove('hidden');
      closeIcon.classList.add('block');
    }
  });
  function setActiveLink() {
    let scrollPos = window.scrollY + 100; // 100px offset for better accuracy
    sections.forEach((section, index) => {
      let sectionElement = document.querySelector('#' + section);
      if (sectionElement) {
        let sectionTop = sectionElement.offsetTop;
        let sectionHeight = sectionElement.offsetHeight;
        if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
          links.forEach(link => link.classList.remove('border-b-2', 'border-sky-400'));
          links[index].classList.add('border-b-2', 'border-sky-400');
        }
      }
    });
  }

  // Event listener for scroll to detect active section
  window.addEventListener('scroll', setActiveLink);

  // Event listener for click
  links.forEach(link => {
    link.addEventListener('click', function () {
      links.forEach(l => l.classList.remove('border-b-2', 'border-sky-400'));
      this.classList.add('border-b-2', 'border-sky-400');
    });
  });
});
</script>




