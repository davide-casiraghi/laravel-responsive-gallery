
$(document).ready(function () {
    
    $(".responsiveGallery").each(function(){
        // You have to create a `Bricklayer` instance for every Bricklayer container you have.
        
        var columnWidth = $(this).attr('data-column-width');
        var gutter = $(this).attr('data-gutter');
        
        $(this).addClass("column-width-"+columnWidth);
        
        
        
        var bricklayer = new window.Bricklayer(this);
        
    });
    
    

});
