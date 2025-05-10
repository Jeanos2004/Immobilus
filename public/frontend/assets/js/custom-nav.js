// Custom JavaScript for Immobilus Navigation
(function($) {
    "use strict";

    // Function to handle active menu items based on current URL
    function setActiveMenuItem() {
        const currentUrl = window.location.pathname;
        
        // Remove all current classes first
        $('.navigation li').removeClass('current');
        
        // Set current class based on URL
        if (currentUrl === '/' || currentUrl === '/home') {
            $('.navigation li:first-child').addClass('current');
        } else if (currentUrl.includes('/agents')) {
            $('.navigation li').each(function() {
                if ($(this).find('a:first').text().trim().toLowerCase().includes('agent')) {
                    $(this).addClass('current');
                }
            });
        } else if (currentUrl.includes('/property')) {
            $('.navigation li').each(function() {
                if ($(this).find('a:first').text().trim().toLowerCase().includes('property')) {
                    $(this).addClass('current');
                }
            });
        } else if (currentUrl.includes('/contact')) {
            $('.navigation li:contains("Contact")').addClass('current');
        }
    }

    // Function to enhance mobile menu functionality
    function enhanceMobileMenu() {
        $('.mobile-nav-toggler').on('click', function() {
            $('body').addClass('mobile-menu-visible');
        });

        $('.close-btn').on('click', function() {
            $('body').removeClass('mobile-menu-visible');
        });

        $('.navigation li.dropdown > a').on('click', function(e) {
            if ($(window).width() <= 991) {
                e.preventDefault();
                $(this).next('ul').slideToggle(300);
                $(this).parent().siblings().find('ul').slideUp(300);
            }
        });
    }

    // Function to smooth scroll to anchors
    function smoothScrollToAnchors() {
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
            }
        });
    }

    // Initialize all functions when document is ready
    $(document).ready(function() {
        setActiveMenuItem();
        enhanceMobileMenu();
        smoothScrollToAnchors();
        
        // Add hover effects to navigation items
        $('.navigation li').hover(
            function() {
                $(this).find('ul').first().stop(true, true).slideDown(300);
            },
            function() {
                $(this).find('ul').first().stop(true, true).slideUp(300);
            }
        );
    });

    // Reinitialize on window resize
    $(window).on('resize', function() {
        if ($(window).width() > 991) {
            $('body').removeClass('mobile-menu-visible');
        }
    });

})(jQuery);
