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
    <h1 class="page-heading">Login</h1>
    <form id="login-form" class="auth-form">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" required>
    </div>
    <button type="submit">Login</button>
    <p class="form-link">Don't have an account? <a href="register.php">Register</a></p>
    </form>
    <div id="login-msg"></div>
</section>

<script>
document.getElementById('login-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const msg = document.getElementById('login-msg');
    try {
        await apiPost('login.php', {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value
        });
        window.location.href = 'index.php';
    } catch (err) {
        msg.innerHTML = `<p class="error">${err.message}</p>`;
    }
});
</script>
<?php include '../includes/footer.php'; ?>
