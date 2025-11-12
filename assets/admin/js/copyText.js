document.addEventListener("DOMContentLoaded", () => {

	var copyText = document.querySelectorAll("[id='fn_copyText']");
	var copyTextValue = document.querySelectorAll("[id='fn_copyTextValue']");

	for( let i = 0; i<= copyText.length-1; i++){

		copyText[i].addEventListener('click', () => {

			var input = document.createElement("textarea");
			input.value = copyTextValue[i].textContent;
			document.body.appendChild(input);
			input.select();
			document.execCommand("Copy");
			input.remove();

		});

	}

});
