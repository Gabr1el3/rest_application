
class Presenter {

	constructor() {
		this.init();
		this.middleware = new Middleware();
		this.middleware.readVisite(this.refreshVisite);
	}

	init() {
		document.querySelector("#date").value = new Date().toISOString().split('T')[0];
		document.querySelector("#send")
			.addEventListener('click', () => {
				this.add();
			});
		document.querySelector("#visiteSelect")
			.addEventListener('change', () => {
				this.middleware.readAppuntamenti(this.refreshAppuntamenti);
			});
	}

	add() {
		const ospedale = {
			cognome: document.querySelector("#cognome").value,
			nome: document.querySelector("#nome").value,
			eta: document.querySelector("#eta").value,
			sesso: document.querySelector("#sesso").value,
			tipologia: document.querySelector("#tipologia").value,
			cognome_medico: document.querySelector("#cognome_medico").value,
			nome_medico: document.querySelector("#nome_medico").value,
			date: document.querySelector("#date").value
		}
		document.querySelector("#cognome").value = "";
		document.querySelector("#nome").value = "";
		document.querySelector("#eta").value = "";
		document.querySelector("#sesso").value = "";
		document.querySelector("#tipologia").value = "";
		document.querySelector("#cognome_medico").value = "";
		document.querySelector("#nome_medico").value = "";
		document.querySelector('#resultInsert').innerText = "";

		this.middleware.create(ospedale, () => {
			document.querySelector('#resultInsert').innerText = "Inserito";
		});
	}

	refreshVisite(list) {
		let template = `
         <option value="%ID">%TITLE</option>
      `;
		let html = "";
		list.forEach(element => {
			let option = template.replace("%ID", element.id_tipo);
			let titolo = 'Visita: ' + element.cognome_medico + ', ' + element.nome_medico + ', ' + element.tipologia;
			option = option.replace('%TITLE', titolo);
			html += option;
		});
		document.querySelector('#visiteSelect').innerHTML = html;
	}

	refreshAppuntamenti(list) {
		let template = `
         <li class="element">
            <div class="title %COMPLETE">%TITLE</div>
         </li>
      `;
		let html = "";
		list.forEach(element => {
			let row = element.cognome_medico + ', ' + element.nome_medico + ', ' + element.tipologia + ', ' + element.date + ', ' +  element.cognome + ', ' + element.nome;
			row = template.replace("%TITLE", row);			
			html += row;
		});
		document.querySelector('ul').innerHTML = html;
	}
}	

let presenter;
window.addEventListener('load', () => {
	presenter = new Presenter();
})

