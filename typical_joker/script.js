async function getJoke() {
	const setupElem = document.getElementById("setup");
	const punchlineElem = document.getElementById("punchline");

	try {
		const response = await fetch("https://official-joke-api.appspot.com/random_joke");
		if (response.ok) {
			const joke = await response.json();
			setupElem.textContent = joke.setup;
			punchlineElem.textContent = joke.punchline;
		} else {
			setupElem.textContent = "Oops! Failed to fetch a joke.";
			punchlineElem.textContent = `Error: ${response.status} ${response.statusText}`;
		}
	} catch (error) {
		setupElem.textContent = "Oops! Failed to fetch a joke.";
		punchlineElem.textContent = error.message;
	}
}
