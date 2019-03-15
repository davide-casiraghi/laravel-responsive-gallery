
$(document).ready(function () {
    
    if( $(".gallery").length ){    
        $(".gallery").gridalicious({
                        width: 250,
                        gutter: 10,
                        animate: true,
                        animationOptions: {
                            speed: 150,
                            duration: 500
                        }
        });
    }
});
