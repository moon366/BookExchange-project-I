<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
include '../includes/header.php';
?>

<section class="form-page">
    <h1 class="page-heading">Register</h1>
    <form id="register-form" class="auth-form">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" required>
    </div>
    <button type="submit">Register</button>
    <p class="form-link">Already have an account? <a href="login.php">Login</a></p>
    </form>
    <div id="register-msg"></div>
</section>

<script>
document.getElementById('register-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const msg = document.getElementById('register-msg');
    try {
        const result = await apiPost('register.php', {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value
        });
        msg.innerHTML = '<p class="success">Registration successful! <a href="login.php">Login here</a></p>';
    } catch (err) {
        msg.innerHTML = `<p class="error">${err.message}</p>`;
    }
});
</script>
<?php include '../includes/footer.php'; ?>
