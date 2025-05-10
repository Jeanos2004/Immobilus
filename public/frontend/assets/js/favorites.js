// JavaScript for handling property favorites
$(document).ready(function() {
    // Function to add a property to favorites
    window.addToFavorite = function(propertyId) {
        $.ajax({
            url: "/add-to-wishlist",
            type: "POST",
            data: {
                property_id: propertyId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Show success message
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    
                    // Update favorite icon if needed
                    $(`[data-favorite="${propertyId}"]`).addClass('active');
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
            error: function(xhr) {
                // Handle error
                if (xhr.status === 401) {
                    // User not authenticated, redirect to login
                    window.location.href = '/login';
                } else {
                    // Show error message
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    
                    Toast.fire({
                        icon: 'error',
                        title: 'Une erreur est survenue. Veuillez réessayer.'
                    });
                }
            }
        });
    };
    
    // Highlight favorite icons for properties already in favorites
    function highlightFavorites() {
        if ($('.user-favorites').length) {
            const favoriteIds = $('.user-favorites').data('favorites').split(',');
            
            favoriteIds.forEach(id => {
                if (id) {
                    $(`[data-favorite="${id}"]`).addClass('active');
                }
            });
        }
    }
    
    // Initialize favorites
    highlightFavorites();
});
