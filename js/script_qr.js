// script.js file

function domReady(fn) {
	if (
		document.readyState === "complete" ||
		document.readyState === "interactive"
	) {
		setTimeout(fn, 1000);
	} else {
		document.addEventListener("DOMContentLoaded", fn);
	}
}

domReady(function () {

	// If found your qr code
	function onScanSuccess(decodeText, decodeResult) {
        // Update the input field with the scanned QR code data
        document.querySelector('input[name="emp_code"]').value = decodeText;
        // Optional: Submit the form automatically after scanning
        document.querySelector('form').submit();
        // You can uncomment the above line if you want the form to be submitted automatically after scanning
	}

	let htmlscanner = new Html5QrcodeScanner(
		"my-qr-reader",
		{ fps: 10, qrbos: 250 }
	);
	htmlscanner.render(onScanSuccess);
});