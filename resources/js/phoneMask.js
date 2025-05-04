import IMask from 'imask';

var element = document.querySelectorAll('.phone-mask-js');
var maskOptions = {
    mask: '+7(000)000-00-00',
    lazy: false
} 
for(let i = 0; i < element.length; i++){
    var mask = new IMask(element[i], maskOptions);
}
