// var carousel = new Array("foret-peuplier.jpg", "paysage-montagne.jpg", "chemin-automne.jpg", "prairie-alpes.jpg");
// var number = 0;

// function ChangeSlide(sens) {
//     number = number + sens;
//     if (number < 0)
//         number = carousel.length - 1;
//     if (number > carousel.length - 1)
//         number = 0;

//     // document.querySelector(".carousel").src = slide[number];
//     carousel[number] = document.querySelector(".carousel");
//     console.log(number);
// }



// class Carousel {

//     /**
//      * 
//      * @param {HTMLElement} element 
//      * @param {Object} options 
//      * @param {Object} options.slidesToScroll Nombres d'éléments à faire défiler
//      * @param {Object} options.slidesVisible Nombres d'éléments visibles dans un slide
//      */
    
//     constructor (element, options ={}) {
//         this.element = element
//         this.options = Object.assign({}, {
//             slidesToScroll: 1,
//             slideVisible: 1
//         }, options)
//         this.children = [].slice.call(element.children)
//         let ratio = this.children.length / this.options.slidesVisible
//         let root = this.createDivWithClass('carousel')
//         let container = this.createDivWithClass('carousel__container')
//         container.style.width = (ratio * 100) + "%"
//         root.appendChild(container)
//         this.element.appendChild(root)
//         this.children.forEach((child) => {
//             let item = this.createDivWithClass('carousel__item')
//             item.appendChild(child)
//             container.appendChild(item)
//         // debugger
//     })
// }

// /**
//  * 
//  * @param {string} className 
//  * @returns {HTMLElement}
//  * 
//  */
// createDivWithClass (className) {
//     let div = document.createElement('div')
//     div.setAttribute('class, className')
//     return div
// }


// document.addEventListener('DOMContentLoaded', function () {

//     new Carousel(document.querySelector('#itemReview'), {
//         slidesVisible: 1
//     })

// })

