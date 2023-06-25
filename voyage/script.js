function ajouter(element) {
    var input = document.getElementById(element);
    var liste = document.getElementById( element + "s");
  
    if (input.value !== "") {
      var option = document.createElement("option");
      option.text = input.value;
      liste.add(option);
      input.value = "";
      
     
    }
  }
  
  let i = 0;
  function ajouter(event, parent, child) {
    event.preventDefault();
  
    const list = document.getElementById(parent);
    var input = document.getElementById(child);
    var text = input.value;
  
    var p = document.createElement("option");
  
    p.textContent = text;
    p.selected = true;
    p.addEventListener("dblclick", function () {
      list.removeChild(p);
    });
    list.appendChild(p);
    //list.insertBefore(p,list.firstElementChild);
  }
//################################################################################################
function ajouter(event, parent, child) {
    event.preventDefault();

    const list = document.getElementById(parent);
    var input = document.getElementById(child);
    var text = input.value;

    if (text !== "") {
        var option = document.createElement("option");
        option.text = text;
        list.add(option);
        input.value = "";
    }
}  
//################################################################################################

document.addEventListener('DOMContentLoaded', function () {
  var slider = tns({
   container: '.liste-pagination',
   items: 3,
   slideBy: 'page',
   controls: {
     prevButton: '.prev',
     nextButton: '.next',
   },
 });
});