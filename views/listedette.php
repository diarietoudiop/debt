

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Client</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <h1>La date est : <span id="date-display"></span></h1>

    <script src="script.js"></script>
</body>
<script>
    // Function to get query parameters from the URL
function getQueryParams() {
    let params = {};
    window.location.search.substr(1).split("&").forEach(function (item) {
        let [key, value] = item.split("=");
        params[key] = decodeURIComponent(value);
    });
    return params;
}

// Get the query parameters
let params = getQueryParams();

// Check if the 'date' parameter exists
if (params.date) {
    // Display the date in the HTML element
    document.getElementById('date-display').textContent = params.date;
} else {
    // If no date parameter, display a default message
    document.getElementById('date-display').textContent = 'Aucune date fournie';
}

</script>

</html>