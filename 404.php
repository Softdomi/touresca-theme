<?php get_template_part('/template-parts/header') ?>

<div class="flex flex-col items-center justify-center text-center px-4 py-16">
    <h1 class="text-7xl md:text-9xl font-extrabold text-red-500">404</h1>
    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mt-4">Page Not Found</h2>
    <p class="text-gray-600 text-lg md:text-xl mt-2">Sorry, the page you are looking for does not exist or has been moved.</p>

    <img src="<?php echo get_template_directory_uri(); ?>/images/404.png" 
         alt="Error 404 Not Found" 
         class="w-64 md:w-80 lg:w-96 my-8">

    <a href="<?php echo home_url(); ?>" 
       class="px-6 py-3 text-lg font-semibold text-white bg-[#095763] rounded-xl shadow-md hover:bg-[#074a50] transition">
       Go to Homepage
    </a>
</div>

<?php get_template_part('/template-parts/footer') ?>
