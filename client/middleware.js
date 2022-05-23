class Middleware {
	constructor() {
		this.url = 'http://127.0.0.1:8080/ospedale/restmiddleware.php';
	}

	create(ospedale, callback) {
		const body = JSON.stringify(ospedale);
		this.connect(this.url, 'POST', body, callback)
	}

	readVisite(callback) {
		let action = (response) => {
			const data = JSON.parse(response);
			callback(data);
		};
		let url=this.url+'?action=visite';
		this.connect(url, 'GET', null, action);
	}

	readAppuntamenti(callback){
		let idVisita=document.querySelector("#visiteSelect").value;

		let action = (response) => {
			const data = JSON.parse(response);
			console.log(data);
			callback(data);
		};
		let url=this.url+'?action=appuntamenti&id_tipo='+idVisita;
		this.connect(url, 'GET', null, action);
	}

	connect(url, method, body, callback) {
		const xhr = new XMLHttpRequest();
		xhr.open(method, url);
		let manageResponse = () => {
			if (xhr.status != 200) {
				alert(`Error ${xhr.status}: ${xhr.statusText}`);
			} else {
				callback(xhr.response);
			}
		}
		xhr.onload = manageResponse;
		xhr.send(body);
	}
}