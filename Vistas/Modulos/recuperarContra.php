

<form id="formRecuperar" method="POST">
    <label for="email">Ingresa tu correo:</label>
    <input type="email" name="email" id="email" required>
    <button type="submit">Enviar Código</button>
</form>

<script>
document.getElementById('formRecuperar').addEventListener('submit', async (e) => {
    e.preventDefault();
    let email = document.getElementById('email').value;

    let response = await fetch('controladores/recuperarC.php', {
        method: 'POST',
        body: new URLSearchParams({ email })
    });

    let data = await response.json();
    alert(data.message);
});
</script>
