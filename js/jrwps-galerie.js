(function(){
    jQuery(document).ready(function($) {
        var $carousel = $('.carousel--multiple');

        $carousel.each(function() {
            var $carouselId = '#' + $(this).attr('id'),
                $itemsContainer = $($carouselId +' .items'),
                $items = $($carouselId +' .item'),
                $next = $($carouselId +' .carousel__control.next'),
                $prev = $($carouselId +' .carousel__control.prev'),
                itemsWidth = 0,
                winWidth = $(window).width();






            /***********************
                    CONTROLS
            ***********************/

            $next.on('click', function(e) {
                e.preventDefault();
                var $currentItem = $($carouselId + ' .item.active'),
                    siblingsWidth = 0,
                    $containerMargin = $($carouselId + ' .items').position().left;

                $currentItem.nextAll('.item').each(function() {
                    siblingsWidth += $(this).outerWidth();
                });

                //console.log(siblingsWidth, winWidth);
                // si la largeur de l'item active et ses frères suivants est > taille de l'écran
                if(siblingsWidth && (siblingsWidth + $currentItem.outerWidth()) > winWidth) {
                    $itemsContainer.animate({
                        left: $containerMargin - $currentItem.outerWidth() +'px'
                    });
                    $currentItem.removeClass('active').next().addClass('active');
                }
                return false;
            });

            $prev.on('click', function(e) {
                e.preventDefault();
                var $currentItem = $($carouselId + '  .item.active'),
                    $containerMargin = $($carouselId + '  .items').position().left;
                if($containerMargin < 0) {
                    $itemsContainer.animate({
                        left: $containerMargin + $currentItem.prev().outerWidth() +'px'
                    });
                    $currentItem.removeClass('active').prev().addClass('active');
                }
                return false;
            });
        });

 
    });

    $(window).load(function() {

        var $carousel = $('.carousel--multiple');

        $carousel.each(function() {
            var $carouselId = '#' + $(this).attr('id'),
                $itemsContainer = $($carouselId +' .items'),
                $items = $($carouselId +' .item'),
                itemsWidth = 0,
                winWidth = $(window).width();

            $items.each(function() {
                itemsWidth += $(this).outerWidth();
            });
            $items.remove();
            $itemsContainer.width(itemsWidth).append($items);
        });
    });
})();