var slide = new Array("foret-peuplier.jpg", "paysage-montagne.jpg", "chemin-automne.jpg", "prairie-alpes.jpg");
var number = 0;

function ChangeSlide(sens) {
    numero = numero + sens;
    if (number < 0)
        number = slide.length - 1;
    if (number > slide.length - 1)
        number = 0;
    document.getElementById("carousel").src = slide[number];
}