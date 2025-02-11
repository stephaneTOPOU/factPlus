document.querySelector('form').addEventListener('submit', function (event) {
    event.preventDefault();
    const formData = new FormData(this);

    fetch(this.action, {
        method: this.method,
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        Swal.fire({
            title: data.success ? 'Succès !' : 'Erreur',
            text: data.success ? 'Client ajouté avec succès.' : data.message || 'Une erreur est survenue.',
            icon: data.success ? 'success' : 'error',
            confirmButtonText: 'OK'
        });
    })
    .catch(error => {
        Swal.fire({
            title: 'Erreur',
            text: 'Erreur serveur.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
});
