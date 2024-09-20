document.getElementById('apply-filters').addEventListener('click', function() {
    const prix = document.getElementById('prix').value;
    const kilometrage = document.getElementById('kilometrage').value;
    const annee = document.getElementById('annee').value;

    // AJAX call to filter cars
    fetch(`/petites-annonces?prix=${prix}&kilometrage=${kilometrage}&annee=${annee}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('.car-list').innerHTML = data;
        });
});
