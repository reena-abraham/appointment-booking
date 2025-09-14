<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Get started with a free and open source Tailwind CSS admin dashboard featuring a sidebar layout, advanced charts, and hundreds of components based on Flowbite">
    <meta name="author" content="Themesberg">
    <meta name="generator" content="Hugo 0.143.0">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <link rel="canonical" href="https://themesberg.com/product/tailwind-css/dashboard-windster">



    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://themewagon.github.io/windster/app.css">
    <link rel="apple-touch-icon" sizes="180x180" href="https://themewagon.github.io/windster/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://themewagon.github.io/windster/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://themewagon.github.io/windster/favicon-16x16.png">
    <link rel="icon" type="image/png" href="https://themewagon.github.io/windster/favicon.ico">
    <link rel="manifest" href="https://themewagon.github.io/windster/site.webmanifest">
    <link rel="mask-icon" href="https://themewagon.github.io/windster/safari-pinned-tab.svg" color="#5bbad5">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.5/dist/tailwind.min.css" rel="stylesheet">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@">
    <meta name="twitter:creator" content="@">
    <meta name="twitter:title" content="Tailwind CSS Dashboard - Windster">
    <meta name="twitter:description" content="Get started with a free and open source Tailwind CSS admin dashboard featuring a sidebar layout, advanced charts, and hundreds of components based on Flowbite">
    <meta name="twitter:image" content="https://themewagon.github.io/windster/">

    <!-- Facebook -->
    <meta property="og:url" content="https://themewagon.github.io/windster/">
    <meta property="og:title" content="Tailwind CSS Dashboard - Windster">
    <meta property="og:description" content="Get started with a free and open source Tailwind CSS admin dashboard featuring a sidebar layout, advanced charts, and hundreds of components based on Flowbite">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://themewagon.github.io/docs/images/og-image.jpg">
    <meta property="og:image:type" content="image/png">
</head>

<body class="bg-gray-50">

    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-THQTXJ7"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>


    <nav class="bg-white border-b border-gray-200 fixed z-30 w-full">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar" class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded">
                        <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <svg id="toggleSidebarMobileClose" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <a href="https://themewagon.github.io/windster/" class="text-xl font-bold flex items-center lg:ml-2.5">
                        <img src="https://themewagon.github.io/windster/images/logo.svg" class="h-6 mr-2" alt="Windster Logo">
                        <span class="self-center whitespace-nowrap">Appointment Booking</span>
                    </a>


                </div>
                <div class="flex items-center">

                    <?php if (!Yii::app()->user->isGuest): ?>
                        <?php
                        $user = User::model()->findByPk(Yii::app()->user->id);
                        ?>
                        <div class="relative ml-3">
                            <button type="button" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-cyan-600" id="user-menu-button" aria-expanded="false" aria-haspopup="true" onclick="toggleUserMenu()">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full" src="<?php echo Yii::app()->baseUrl . '/images/user.png'; ?>" alt="">
                                <span class="ml-2 font-medium text-gray-900"><?php echo CHtml::encode($user->name); ?></span>
                                <svg class="w-4 h-4 ml-1 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900"><?php echo CHtml::encode($user->name); ?></p>
                                    <p class="text-sm text-gray-500 truncate"><?php echo CHtml::encode($user->email); ?></p>
                                </div>
                                <ul class="py-2">
                                    <li>
                                        <hr class="my-2 border-t border-gray-200">
                                    </li>
                                    <li><a href="<?php echo Yii::app()->createUrl('site/logout'); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a></li>
                                </ul>
                            </div>
                        </div>

                        <script>
                            function toggleUserMenu() {
                                const dropdown = document.getElementById('userDropdown');
                                dropdown.classList.toggle('hidden');
                            }

                            // Optional: close menu when clicking outside
                            document.addEventListener('click', function(event) {
                                const menuButton = document.getElementById('user-menu-button');
                                const menu = document.getElementById('userDropdown');
                                if (!menu.contains(event.target) && !menuButton.contains(event.target)) {
                                    menu.classList.add('hidden');
                                }
                            });
                        </script>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </nav>

    <div class="flex overflow-hidden bg-white pt-16">

        <aside id="sidebar" class="fixed hidden z-20 h-full top-0 left-0 pt-16 flex lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75" aria-label="Sidebar">
            <div class="relative flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white pt-0">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex-1 px-3 bg-white divide-y space-y-1">
                        <ul class="space-y-2 pb-2">
                            <li>
                                <form action="#" method="GET" class="lg:hidden">
                                    <label for="mobile-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" name="email" id="mobile-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:ring-cyan-600 block w-full pl-10 p-2.5" placeholder="Search">
                                    </div>
                                </form>
                            </li>
                            <li>
                                <a href="<?php echo $this->createUrl('admin/dashboard'); ?>" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group">
                                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                    </svg>
                                    <span class="ml-3">Dashboard</span>
                                </a>
                            </li>
                             <li>
                                <a href="<?php echo $this->createUrl('admin/appointments'); ?>" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group {{ if eq $page_slug "inbox" }} bg-gray-100 {{ end }}">
                                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Appointments</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $this->createUrl('category/list'); ?>" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group {{ if eq $page_slug "inbox" }} bg-gray-100 {{ end }}">
                                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Category</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $this->createUrl('servicetype/list'); ?>" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group {{ if eq $page_slug "inbox" }} bg-gray-100 {{ end }}">
                                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Service Type</span>
                                </a>
                            </li>



                            <li>
                                <a href="<?php echo $this->createUrl('user/list'); ?>" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group {{ if eq $page_slug "inbox" }} bg-gray-100 {{ end }}">
                                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Users</span>
                                </a>
                            </li>

                    </div>
                </div>
            </div>
        </aside>

        <div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>


        <div id="main-content" class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-64">
            <main>
                <?php echo $content; ?>

            </main>

            <p class="text-center text-sm text-gray-500 my-10">
                &copy; 2019-2025
                <a href="#" class="hover:underline" target="_blank"></a>. All rights reserved
            </p>

        </div>

    </div>
    <?php
    // Yii::app()->clientScript->registerCoreScript('jquery');
    ?>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://themewagon.github.io/windster/app.bundle.js"></script>

</body>

</html>