/* Aggiunge un attributo "selected" all'elemento span cliccato,
  l'aggiunta e' consentita solo se non e' presente un elemento
  span con quest'attributo impostato
 */

let stars = document.querySelectorAll('.star');

stars.forEach(star => {
  star.addEventListener('click', function() {

    let children = star.parentElement.children;
    for(let child of children) {
      if(child.getAttribute("selected")) {
        return false;
      }
    }
    this.setAttribute('selected', 'true');
  });
});