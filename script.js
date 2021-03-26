const button_search = document.getElementById("search-button");
const domain = 'http://localhost/';


function tableCreate(table, response) {
	

	const tbl = table;

	let tr = document.createElement('tr');
	
	let td1 = document.createElement('td');
	let td2 = document.createElement('td');
	let td3 = document.createElement('td');

	td1.innerHTML = "Shorten link";
	td2.innerHTML = "Initial link";
	td3.innerHTML = "Used";

	tr.appendChild(td1);
	tr.appendChild(td2);
	tr.appendChild(td3);

	tbl.appendChild(tr);


	response.forEach((element) => {
		tr = document.createElement('tr');

		td1 = document.createElement('td');
		td2 = document.createElement('td');
		td3 = document.createElement('td');

		td1.innerHTML = domain + element["shorten_hash"];
		td2.innerHTML = element["link"];
		td3.innerHTML = element["used"];

		tr.appendChild(td1);
		tr.appendChild(td2);
		tr.appendChild(td3);

		tbl.appendChild(tr);
	});

	
}

function createAlert(div, msg) {
	const p = document.createElement('p');
	p.innerHTML = msg;
	div.appendChild(p);
}

function removeAllChildNodes(parent) {
    while (parent.firstChild) 
        parent.removeChild(parent.firstChild);
}

button_search.addEventListener("click", () => {
	const link_to_shorten = document.getElementById("search-bar");
	
	const link = link_to_shorten.value;

	const data = new FormData();

	data.append('link', link);
	
	const xhr = new XMLHttpRequest();
	
    xhr.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	const table = document.getElementById("links-table");
        	const div = document.getElementById("alert");

        	removeAllChildNodes(table);
        	removeAllChildNodes(div);

        	// console.log(this.response);

        	
        	response = JSON.parse(this.response);



        	if ("error" in response)
        		createAlert(div, response["error"]);
        	else
        		tableCreate(table, response);
	    }
  	};


    xhr.open('POST', "process.php", true);
	xhr.send(data);
});