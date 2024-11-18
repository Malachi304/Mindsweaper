
// using fetch to dyanmically update

document.getElementById('help-link').addEventListener('click', function(event) {
    event.preventDefault();  // Prevent the default page reload
    console.log('Loading help content dynamically...');  // This will show up in the console

    fetch('help.html')       // Fetch help page content
        .then(response => response.text())  // Get the HTML content as text
        .then(html => {
            // Insert the fetched HTML into a specific part of the page
            document.getElementById('content').innerHTML = html;
        });
});