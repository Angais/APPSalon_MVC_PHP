<h1 class="nombre-pagina">Iniciar Sesión</h1>
<p class="descripcion-pagina">Ingrese sus datos para iniciar sesión</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form action="/" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Dirección de Correo Electrónico" name="email" value="<?php echo s($auth->email) ?>">
    </div>

    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" placeholder="Contraseña" name="password">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Sin cuenta? Crea una</a>
    <a href="/olvide">Olvidé mi Contraseña</a>
</div>