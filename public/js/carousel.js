var carousel = new Array("foret-peuplier.jpg", "paysage-montagne.jpg", "chemin-automne.jpg", "prairie-alpes.jpg");
var number = 0;

function ChangeSlide(sens) {
    number = number + sens;
    if (number < 0)
        number = carousel.length - 1;
    if (number > carousel.length - 1)
        number = 0;
        
    // document.querySelector(".carousel").src = slide[number];
    carousel[number] = document.querySelector(".carousel");
    console.log(number);
}