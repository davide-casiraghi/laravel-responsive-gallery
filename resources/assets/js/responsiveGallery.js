
$(document).ready(function () {
    
    if( $(".gallery").length ){
    // You have to create a `Bricklayer` instance for every Bricklayer container you have.
           var bricklayer = new Bricklayer(document.getElementById('my-bricklayer'));

           // You can delete these lines, these adds dynamic bricklayers to make you understand how it works.
           for (var i = 0; i < 20; i++) {
             bricklayer.append(box())
           }

           // Did you see a box looks like "/"?
           var anotherBox = box();
           anotherBox.style.transform = "rotate(10deg)";
           bricklayer.append(anotherBox);
    }
    
    
});
