<?php

return [
    // Component prefix used when registering components
    'prefix' => 'b',
    
    // Default CSS framework (tailwind or bootstrap)
    'css_framework' => 'tailwind',
    
    // Default classes for components
    'default_classes' => [
        'button' => 'inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150',
        'input' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
        'alert' => 'p-4 mb-4 rounded-md',
        'card' => 'bg-white overflow-hidden shadow-md rounded-lg',
        'dropdown' => 'relative inline-block text-left',
        'modal' => 'fixed inset-0 overflow-y-auto',
        'table' => 'min-w-full divide-y divide-gray-200',
        'tabs' => 'border-b border-gray-200',
        'date-picker' => 'w-full',
        'checkbox' => 'rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500',
        'radio' => 'border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500',
        'toggle' => 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2',
    ],
    
    // Livewire configuration
    'livewire' => [
        'enable' => true,
        'prefix' => 'livewire',
        'lazy_loading' => true,
        'polling' => false,
        'polling_interval' => 2000, // in milliseconds
    ],
    
    // Alpine.js configuration
    'alpine' => [
        'enable' => true,
        'defer' => true,
        'focus_trap' => true,
    ],
    
    // Component customization
    'components' => [
        // Allow users to override component views
        'override_path' => null,
        
        // Header component specific configuration
        'header' => [
            // Base classes applied to all headers
            'base_classes' => 'w-full',
            
            // Position classes
            'positions' => [
                'static' => 'relative',
                'fixed' => 'fixed top-0 left-0 right-0',
                'sticky' => 'sticky top-0',
                'absolute' => 'absolute top-0 left-0 right-0',
                'relative' => 'relative',
            ],
            
            // Logo positions
            'logo_positions' => [
                'left' => '',
                'center' => 'mx-auto',
                'right' => 'ml-auto',
            ],
            
            // Container widths
            'container_widths' => [
                'full' => '',
                'container' => 'container mx-auto',
                'screen' => 'max-w-screen-xl mx-auto',
            ],
            
            // Background colors
            'bg_colors' => [
                'white' => 'bg-white',
                'transparent' => 'bg-transparent',
                'gray-50' => 'bg-gray-50',
                'gray-100' => 'bg-gray-100',
                'gray-200' => 'bg-gray-200',
                'gray-800' => 'bg-gray-800',
                'gray-900' => 'bg-gray-900',
                'blue-600' => 'bg-blue-600',
                'blue-700' => 'bg-blue-700',
                'green-600' => 'bg-green-600',
                'red-600' => 'bg-red-600',
            ],
            
            // Text colors
            'text_colors' => [
                'white' => 'text-white',
                'gray-800' => 'text-gray-800',
                'gray-900' => 'text-gray-900',
                'gray-600' => 'text-gray-600',
                'gray-500' => 'text-gray-500',
                'gray-400' => 'text-gray-400',
                'blue-600' => 'text-blue-600',
            ],
            
            // Padding options
            'padding_options' => [
                'sm' => 'py-2 px-4',
                'md' => 'py-4 px-6',
                'lg' => 'py-6 px-8',
            ],
        ],
        
        // Footer component specific configuration
        'footer' => [
            // Base classes applied to all footers
            'base_classes' => 'w-full',
            
            // Position classes
            'positions' => [
                'static' => 'relative',
                'fixed' => 'fixed bottom-0 left-0 right-0',
                'sticky' => 'sticky bottom-0',
                'absolute' => 'absolute bottom-0 left-0 right-0',
                'relative' => 'relative',
            ],
            
            // Logo positions
            'logo_positions' => [
                'left' => '',
                'center' => 'mx-auto text-center',
                'right' => 'ml-auto text-right',
            ],
            
            // Container widths
            'container_widths' => [
                'full' => '',
                'container' => 'container mx-auto',
                'screen' => 'max-w-screen-xl mx-auto',
            ],
            
            // Background colors
            'bg_colors' => [
                'white' => 'bg-white',
                'transparent' => 'bg-transparent',
                'gray-50' => 'bg-gray-50',
                'gray-100' => 'bg-gray-100',
                'gray-200' => 'bg-gray-200',
                'gray-800' => 'bg-gray-800',
                'gray-900' => 'bg-gray-900',
                'blue-600' => 'bg-blue-600',
                'blue-700' => 'bg-blue-700',
                'green-600' => 'bg-green-600',
                'red-600' => 'bg-red-600',
            ],
            
            // Text colors
            'text_colors' => [
                'white' => 'text-white',
                'gray-800' => 'text-gray-800',
                'gray-900' => 'text-gray-900',
                'gray-600' => 'text-gray-600',
                'gray-500' => 'text-gray-500',
                'gray-400' => 'text-gray-400',
                'blue-600' => 'text-blue-600',
            ],
            
            // Padding options
            'padding_options' => [
                'sm' => 'py-4 px-4',
                'md' => 'py-8 px-6',
                'lg' => 'py-12 px-8',
            ],
            
            // Column grid settings
            'columns' => [
                1 => 'grid-cols-1',
                2 => 'grid-cols-1 md:grid-cols-2',
                3 => 'grid-cols-1 md:grid-cols-3',
                4 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
                5 => 'grid-cols-1 md:grid-cols-3 lg:grid-cols-5',
                6 => 'grid-cols-1 md:grid-cols-3 lg:grid-cols-6',
            ],
        ],
        
        // Accordion component specific configuration
        'accordion' => [
            // Base classes applied to all accordions
            'base_classes' => 'w-full my-2 py-5 px-2 rounded-lg group border-solid border-t border-r border-l border-b-2 border-gray-100 shadow-sm',
            
            // Accordion sizes
            'sizes' => [
                'sm' => 'text-sm',
                'md' => 'text-base',
                'lg' => 'text-lg',
            ],
            
            // Accordion animations
            'animations' => [
                'fade' => 'transition-opacity duration-300',
                'slide-up' => 'transition-transform duration-300 transform-gpu -translate-y-2',
                'slide-down' => 'transition-transform duration-300 transform-gpu translate-y-2',
                'slide-left' => 'transition-transform duration-300 transform-gpu -translate-x-2',
                'slide-right' => 'transition-transform duration-300 transform-gpu translate-x-2',
            ],
            
            // Header classes
            'header_classes' => 'flex justify-between items-center text-center py-3 px-2 cursor-pointer',
            
            // Title classes
            'title_classes' => 'text-lg font-bold',
            
            // Icon classes
            'icon_classes' => 'w-4 h-4 transition-transform duration-300',
            
            // Content classes
            'content_classes' => 'py-3 mt-2 overflow-hidden transition-all duration-300',
        ],
        
        // Button component specific configuration
        'button' => [
            // Base classes applied to all buttons
            'base_classes' => 'inline-flex items-center justify-center font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-150 ease-in-out relative overflow-hidden select-none',
            
            // Button variants
            'variants' => [
                'solid' => [
                    'primary' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white',
                    'secondary' => 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white',
                    'success' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500 text-white',
                    'danger' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500 text-white',
                    'warning' => 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500 text-white',
                    'info' => 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 text-white',
                    'light' => 'bg-gray-200 hover:bg-gray-300 focus:ring-gray-200 text-gray-700',
                    'dark' => 'bg-gray-800 hover:bg-gray-900 focus:ring-gray-700 text-white',
                ],
                'outline' => [
                    'primary' => 'bg-transparent border border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
                    'secondary' => 'bg-transparent border border-gray-600 text-gray-600 hover:bg-gray-50 focus:ring-gray-500',
                    'success' => 'bg-transparent border border-green-600 text-green-600 hover:bg-green-50 focus:ring-green-500',
                    'danger' => 'bg-transparent border border-red-600 text-red-600 hover:bg-red-50 focus:ring-red-500',
                    'warning' => 'bg-transparent border border-yellow-600 text-yellow-600 hover:bg-yellow-50 focus:ring-yellow-500',
                    'info' => 'bg-transparent border border-indigo-600 text-indigo-600 hover:bg-indigo-50 focus:ring-indigo-500',
                    'light' => 'bg-transparent border border-gray-200 text-gray-700 hover:bg-gray-50 focus:ring-gray-200',
                    'dark' => 'bg-transparent border border-gray-800 text-gray-800 hover:bg-gray-50 focus:ring-gray-700',
                ],
                'soft' => [
                    'primary' => 'bg-blue-100 hover:bg-blue-200 text-blue-700 focus:ring-blue-500',
                    'secondary' => 'bg-gray-100 hover:bg-gray-200 text-gray-700 focus:ring-gray-500',
                    'success' => 'bg-green-100 hover:bg-green-200 text-green-700 focus:ring-green-500',
                    'danger' => 'bg-red-100 hover:bg-red-200 text-red-700 focus:ring-red-500',
                    'warning' => 'bg-yellow-100 hover:bg-yellow-200 text-yellow-700 focus:ring-yellow-500',
                    'info' => 'bg-indigo-100 hover:bg-indigo-200 text-indigo-700 focus:ring-indigo-500',
                    'light' => 'bg-gray-50 hover:bg-gray-100 text-gray-700 focus:ring-gray-200',
                    'dark' => 'bg-gray-200 hover:bg-gray-300 text-gray-800 focus:ring-gray-700',
                ],
                'ghost' => [
                    'primary' => 'bg-transparent hover:bg-blue-100 text-blue-600 focus:ring-blue-500',
                    'secondary' => 'bg-transparent hover:bg-gray-100 text-gray-600 focus:ring-gray-500',
                    'success' => 'bg-transparent hover:bg-green-100 text-green-600 focus:ring-green-500',
                    'danger' => 'bg-transparent hover:bg-red-100 text-red-600 focus:ring-red-500', 
                    'warning' => 'bg-transparent hover:bg-yellow-100 text-yellow-600 focus:ring-yellow-500',
                    'info' => 'bg-transparent hover:bg-indigo-100 text-indigo-600 focus:ring-indigo-500',
                    'light' => 'bg-transparent hover:bg-gray-100 text-gray-600 focus:ring-gray-200',
                    'dark' => 'bg-transparent hover:bg-gray-100 text-gray-800 focus:ring-gray-700',
                ],
                'link' => [
                    'primary' => 'bg-transparent text-blue-600 hover:underline focus:ring-0',
                    'secondary' => 'bg-transparent text-gray-600 hover:underline focus:ring-0',
                    'success' => 'bg-transparent text-green-600 hover:underline focus:ring-0',
                    'danger' => 'bg-transparent text-red-600 hover:underline focus:ring-0',
                    'warning' => 'bg-transparent text-yellow-600 hover:underline focus:ring-0',
                    'info' => 'bg-transparent text-indigo-600 hover:underline focus:ring-0',
                    'light' => 'bg-transparent text-gray-400 hover:underline focus:ring-0',
                    'dark' => 'bg-transparent text-gray-800 hover:underline focus:ring-0',
                ],
            ],
            
            // Button sizes
            'sizes' => [
                'xs' => 'px-2.5 py-1.5 text-xs',
                'sm' => 'px-3 py-2 text-sm leading-4',
                'md' => 'px-4 py-2 text-sm',
                'lg' => 'px-4 py-2 text-base',
                'xl' => 'px-6 py-3 text-base',
            ],
        ],
        
        // Alert component specific configuration
        'alert' => [
            // Base classes applied to all alerts
            'base_classes' => 'rounded-md p-4',
            
            // Alert colors
            'colors' => [
                'info' => 'bg-blue-50 border-l-4 border-blue-400',
                'success' => 'bg-green-50 border-l-4 border-green-400',
                'warning' => 'bg-yellow-50 border-l-4 border-yellow-400',
                'danger' => 'bg-red-50 border-l-4 border-red-400',
                'error' => 'bg-red-50 border-l-4 border-red-400',
            ],
            
            // Alert text colors
            'text_colors' => [
                'info' => 'text-blue-700',
                'success' => 'text-green-700',
                'warning' => 'text-yellow-700',
                'danger' => 'text-red-700',
                'error' => 'text-red-700',
            ],
            
            // Alert icon colors
            'icon_colors' => [
                'info' => 'text-blue-400',
                'success' => 'text-green-400',
                'warning' => 'text-yellow-400',
                'danger' => 'text-red-400',
                'error' => 'text-red-400',
            ],
            
            // Default icons for each alert type
            'icons' => [
                'info' => 'heroicon-o-information-circle',
                'success' => 'heroicon-o-check-circle',
                'warning' => 'heroicon-o-exclamation',
                'danger' => 'heroicon-o-x-circle',
                'error' => 'heroicon-o-x-circle',
            ],
            
            // Alert sizes
            'sizes' => [
                'sm' => 'text-xs p-2',
                'md' => 'text-sm p-4',
                'lg' => 'text-base p-6',
            ],
            
            // Alert positions
            'positions' => [
                'top-left' => 'top-0 left-0',
                'top-center' => 'top-0 left-1/2 transform -translate-x-1/2',
                'top-right' => 'top-0 right-0',
                'bottom-left' => 'bottom-0 left-0',
                'bottom-center' => 'bottom-0 left-1/2 transform -translate-x-1/2',
                'bottom-right' => 'bottom-0 right-0',
            ],
            
            // Alert animations
            'animations' => [
                'fade' => 'transition-opacity duration-300 ease-in-out opacity-100 enter:opacity-0 leave:opacity-0',
                'slide-up' => 'transition transform duration-300 ease-in-out transform-gpu translate-y-0 opacity-100 enter:translate-y-full enter:opacity-0 leave:translate-y-full leave:opacity-0',
                'slide-down' => 'transition transform duration-300 ease-in-out transform-gpu -translate-y-0 opacity-100 enter:-translate-y-full enter:opacity-0 leave:-translate-y-full leave:opacity-0',
                'slide-left' => 'transition transform duration-300 ease-in-out transform-gpu translate-x-0 opacity-100 enter:translate-x-full enter:opacity-0 leave:translate-x-full leave:opacity-0',
                'slide-right' => 'transition transform duration-300 ease-in-out transform-gpu -translate-x-0 opacity-100 enter:-translate-x-full enter:opacity-0 leave:-translate-x-full leave:opacity-0',
            ],
        ],
        
        // Enable or disable specific components
        'enabled' => [
            'alert' => true,
            'button' => true,
            'card' => true,
            'dropdown' => true,
            'input' => true,
            'modal' => true,
            'table' => true,
            'tabs' => true,
            'date-picker' => true,
            'accordion' => true,
            'badge' => true,
            'breadcrumb' => true,
            'carousel' => true,
            'checkbox' => true,
            'datepicker' => true,
            'dialog' => true,
            'icon' => true,
            'label' => true,
            'loading' => true,
            'radio-button' => true,
            'select-list' => true,
            'spinner' => true,
            'textarea' => true,
            'toggle' => true,
            'phone-int' => true,
            'image-cropper' => true,
            'flat-picker' => true,
            'floating-button' => true,
            'social-icons' => true,
            'dropzone' => true,
            'trix' => true,
            'header' => true,
            'footer' => true,
            'button-bar' => true,
            'chips' => true,
            'input-currency' => true,
            'sort-field' => true,
            'header-bar' => true,
            'swiper' => true,
            'swiper-carousel' => true,
            'card-variant' => true,
            'grid' => true,
            'select2' => true,
            'table-responsive' => true,
            'filepond' => true,
            'apex-charts' => true,
            'phone-select' => true,
            'country-select' => true,
            'copyright' => true,
        ],
    ],
    
    // Performance optimization
    'performance' => [
        'defer_loading' => true,
        'minimize_rerenders' => true,
        'use_computed_properties' => true,
    ],
];