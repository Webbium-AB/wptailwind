<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-gray-100'); ?>>
    <div id="app" class="site font-body">
        <header id="masthead" class="site-header">
            <!--Nav-->
            <div class="bg-white border-b border-gray-200 py-6">
                <nav x-data="{ mopen: false }" class="flex container mx-auto items-center justify-between flex-wrap px-2">
                    <div class="flex items-center flex-shrink-0 text-black mr-6">
                        <a class="no-underline hover:no-underline" href="<?php bloginfo('url');?>">
                            <span class="text-2xl pl-2 font-title"><i class="em em-grinning"></i> WPTailwind</span>
                        </a>
                    </div>

                    <!-- Mobile -->
                    <div class="lg:hidden">
                        <button id="nav-toggle" @click="mopen = !mopen" class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-black hover:border-black">
                            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                        </button>
                    </div>

                    <!-- Mobile/desktop -->
                    <div :class="{ 'hidden' : mopen === false }" class="w-full flex-grow lg:flex lg:items-center lg:w-auto lg:block pt-6 lg:pt-0" id="nav-content">
                        <?php
                        $args = [
                            'menu' => 'navbar',
                            'menu_class' => 'list-reset lg:flex justify-end flex-1 items-center font-medium text-sm',
                            'container' => null,
                            'depth' => 2,
                            'walker' => new WPTailwind\WPTailwindWalkerNavMenu
                        ];
                        wp_nav_menu($args);
                        ?>
                    </div>

                </nav>
            </div>
        </header>
        <div id="content" class="site-content">
            
            
             