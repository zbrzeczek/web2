var dzisiaj = new Date();
var aktualnyMiesiac = dzisiaj.getMonth();
var aktualnyRok = dzisiaj.getFullYear();
var wybierzMiesiac = document.getElementById("miesiac");
var wybierzRok = document.getElementById("rok");

var miesiace = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];

var miesiacRok = document.getElementById("miesiacRok");

kalendarz(aktualnyRok, aktualnyMiesiac);


function next() {
  if (aktualnyMiesiac == 11) {
    aktualnyRok++;
    aktualnyMiesiac = 0;
  } 
  else {
    aktualnyMiesiac++;
  }
  kalendarz(aktualnyRok, aktualnyMiesiac);
}

function previous() {
  if (aktualnyMiesiac == 0) {
    aktualnyRok--;
    aktualnyMiesiac = 11;
  } 
  else {
    aktualnyMiesiac--;
  }
    kalendarz(aktualnyRok, aktualnyMiesiac);
}

function jump() {
    aktualnyRok = parseInt(wybierzRok.value);
    aktualnyMiesiac = parseInt(wybierzMiesiac.value);
    kalendarz(aktualnyRok, aktualnyMiesiac);
}


function kalendarz(rok, miesiac){

  let dzienPierwszy = (new Date(rok, miesiac)).getDay();

  var tbl = document.getElementById("tbody");

  tbl.innerHTML = "";

  miesiacRok.innerHTML = miesiace[miesiac] + " " + rok;
  wybierzRok.value = rok;
  wybierzMiesiac.value = miesiac;


  let data = 1;

  for (let i = 0; i < 6; i++) {

    let row = document.createElement("tr");

    for (let j = 0; j < 7; j++) {

      if (i === 0 && j < dzienPierwszy-1) {
        cell = document.createElement("td");
        cellText = document.createTextNode("");
        cell.appendChild(cellText);
        row.appendChild(cell);
      }

      else if (data > iloscDni(miesiac, rok)) {
        break;
      }

      else {

        cell = document.createElement("td");
        cellText = document.createTextNode(data);
        if (data === dzisiaj.getDate() && rok === dzisiaj.getFullYear() && miesiac === dzisiaj.getMonth()) {
          cell.classList.add('dzisiaj');
        }
        cell.appendChild(cellText);
        row.appendChild(cell);
        data++;
      }
    }
    tbl.appendChild(row); 
    if (data > iloscDni(miesiac, rok)) {
      break;
    }
  }
}

function iloscDni(iMonth, iYear) {
  return 32 - new Date(iYear, iMonth, 32).getDate();
}
