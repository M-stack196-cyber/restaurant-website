<?php
require 'includes/header.php';
?>

<div class="row mt-5">
    <div class="col-md-6">
        <h2>About Us</h2>
        <p>Welcome to E-Shop, your number one source for all things. We're dedicated to giving you the very best of products, with a focus on dependability, customer service and uniqueness.</p>
        <p>Founded in 2026, E-Shop has come a long way from its beginnings. When we first started out, our passion for providing the best equipment drove us to do intense research, and gave us the impetus to turn hard work and inspiration into a booming online store.</p>
    </div>
    <div class="col-md-6">
        <h2>Contact Us</h2>
        <form>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
