// holds an instance of XMLHttpRequest
var xmlHttp = createXmlHttpRequestObject();

// create an XMLHttpRequest instance
function createXmlHttpRequestObject() {
	// will store the reference to the XMLHttpRequest object
	var xmlHttp;
	// create the XMLHttpRequest object
	try{
		// assume IE7 or newer or other modern browsers
		xmlHttp = new XMLHttpRequest();
	}catch(e){

	}

	// return the created object or display an error message
	if(!xmlHttp){
		alert("Error creating the XMLHttpRequest object.");
	}else{
		return xmlHttp;
	}
}

// performs a server request and assigns a callback function
function process() {
	// only continue if xmlHttp isn't void
	if(xmlHttp){
		// try to connect to the server
		try {
			// get the two values entered by the user
			var firstNumber = document.getElementById("firstNumber").value;
			var secondNumber = document.getElementById("secondNumber").value;

			// create the params string
			var params = "firstNumber=" + firstNumber +
					"&secondNumber=" + secondNumber;

			// initiate the asynchronous HTTP request
			xmlHttp.open("GET", "divide.php?" + params, true);
			xmlHttp.onreadystatechange = handleRequestStateChange;
			xmlHttp.send(null);
		}
		// display the error in case of failure
		catch (e){
			alert("Can't connect to server:\n" + e.toString());
		}
	}
}

// function tha thandles the HTTP response
function handleRequestStateChange() {
	// obtain a reference to the <div> element on the page
	myDiv = document.getElementById("myDivElement");

	// display the status of the request
	if(xmlHttp.readyState == 1){
		myDiv.innerHTML += "Request status: 1 (loading) <br>";
	}else if(xmlHttp.readyState == 2){
		myDiv.innerHTML += "Request status: 2 (loaded) <br>";
	}else if(xmlHttp.readyState == 3){
		myDiv.innerHTML += "Request status: 3 (interactive) <br>";
	}
	// when readyState is 4, we also read the server response
	else if(xmlHttp.readyState == 4){
		// revert "busy" hourglass icon to normal cursor
		document.body.style.cursor = "default";

		// read response only if HTTP status is "OK"
		if(xmlHttp.status == 200){
			try{
				// read the message from the server
				response = xmlHttp.responseText;

				// display the message
				myDiv.innerHTML += "Request status: 4 (complete). Server said: <br>";
				myDiv.innerHTML += response;
			}catch(e){
				// display error message
				alert("Error reading the response: " + e.toString());
			}
		}else{
			// display status message
			alert("There was a problem retrieving the data:\n" + xmlHttp.statusText);

			// revert "busy" hourglass icon to normal cursor
			document.body.style.cursor = "default";
		}
	}
}

// handles the response received from the server
function handleServerResponse() {
	// retrieve the server's response packaged as an XML DOM object
	var xmlResponse = xmlHttp.responseXML;

	// catching server-side errors
	if (!xmlResponse || !xmlResponse.documentElement) {
		throw("Invalid XML structure:\n" + xmlHttp.responseText);
	}

	// catching server-side errors (Firefox version)
	var rootNodeName = xmlResponse.documentElement.nodeName;
	if (rootNodeName == "parsererror") {
		throw("Invalid XML structure:\n" + xmlHttp.responseText);
	}

	// getting the root element (the document element)
	xmlRoot = xmlResponse.documentElement;

	// testing that we recived the XML document we expect
	if (rootNodeName != "response" || !xmlHttp.responseText){
		throw("Invalid XML structure:\n" + xmlHttp.responseText);
	}

	// the value we need to display is the child of the root <response> element
	responseText = xmlRoot.firstChild.data;

	// display the user message
	myDiv = document.getElementById("myDivElement");
	myDiv.innerHTML = "Server says the answer is: " + responseText;
}