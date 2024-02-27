document.getElementById("convertBtn").addEventListener("click", function() {

    var videoLink = prompt("Please enter the YouTube video link:");


    fetch('https://api.openai.com/v1/engines/davinci-codex/completions', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer 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'
        },
        body: JSON.stringify({
            prompt: "Convert the YouTube video to text: " + videoLink,
            max_tokens: 100
        })
    })
    .then(response => response.json())
    .then(data => {
        // Check if the API response contains the converted text
        if (data.choices && data.choices.length > 0) {
            // Extract the text from the API response
            var text = data.choices[0].text.trim();

            // Display the extracted text from the video to the user
            alert("Video converted to text:\n\n" + text);
        } else {
            // Handle the case when no text is returned
            alert("Unable to convert the video to text. Please try again.");
        }
    })
    .catch(error => {
        // Handle any errors that occur during the API request
        console.error(error);
        alert("An error occurred while converting the video to text. Please try again.");
    });
});