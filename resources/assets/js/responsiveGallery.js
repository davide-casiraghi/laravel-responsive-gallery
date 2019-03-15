
$(document).ready(function () {
    
    if( $(".responsiveGallery").length ){
    // You have to create a `Bricklayer` instance for every Bricklayer container you have.
           var bricklayer = new window.Bricklayer(document.getElementById('my-bricklayer'));

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

function box() {
    var color = '#' + Math.random().toString(16).substr(-6);
    var heights = [30, 50, 70, 90, 100, 120];
    var randomHeight = heights[Math.floor(Math.random() * heights.length)];
    var box = document.createElement('div');
    
    box.className = 'box';
    box.style.backgroundColor = color;
    box.style.height = randomHeight + "px";
    return box;
}
