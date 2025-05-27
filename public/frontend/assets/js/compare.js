/**
 * Gestion de la comparaison des propriétés
 */
$(document).ready(function() {
    // Ajouter une propriété à la liste de comparaison
    $('.add-to-compare').on('click', function(e) {
        e.preventDefault();
        
        const propertyId = $(this).data('id');
        
        $.ajax({
            url: "/add-to-compare",
            type: "POST",
            data: {
                property_id: propertyId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    updateCompareCount(response.count);
                } else if (response.status === 'info') {
                    toastr.info(response.message);
                } else if (response.status === 'warning') {
                    toastr.warning(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error("Une erreur est survenue. Veuillez réessayer.");
            }
        });
    });
    
    // Mettre à jour le compteur de propriétés à comparer
    function updateCompareCount(count) {
        const compareCount = $('.compare-count');
        if (compareCount.length) {
            compareCount.text(count);
            
            if (count > 0) {
                compareCount.removeClass('d-none');
            } else {
                compareCount.addClass('d-none');
            }
        }
    }
    
    // Initialiser le compteur au chargement de la page
    function initCompareCount() {
        $.ajax({
            url: "/compare",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.count) {
                    updateCompareCount(response.count);
                }
            }
        });
    }
    
    // Afficher le bouton de comparaison dans le header si des propriétés sont dans la liste
    function initCompareButton() {
        const compareList = JSON.parse(localStorage.getItem('compare_list')) || [];
        
        if (compareList.length > 0) {
            $('.compare-btn').removeClass('d-none');
        } else {
            $('.compare-btn').addClass('d-none');
        }
    }
});
