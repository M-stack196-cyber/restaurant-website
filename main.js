document.addEventListener('DOMContentLoaded', function() {
    const addButtons = document.querySelectorAll('.add-to-cart');
    addButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const formData = new FormData();
            formData.append('action', 'add');
            formData.append('id', id);

            fetch('cart_action.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Product added to cart!');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
