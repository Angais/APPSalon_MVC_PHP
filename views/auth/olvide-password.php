<h1 class="nombre-pagina">Olvidé mi Contraseña</h1>
<p class="descripcion-pagina">Necesito recuperar mi Contraseña</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form action="/olvide" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" name="email" placeholder="Dirección de Correo Electrónico">
    </div>
    <input type="submit" class="boton" value="Solicitar Recuperación">
</form>

<div class="acciones">
    <a href="/">Iniciar Sesión</a>
    <a href="/crear-cuenta">Crea una nueva Cuenta</a>
</div>