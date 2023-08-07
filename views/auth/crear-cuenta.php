<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Crea una cuenta gratis</p>

<?php
include_once __DIR__ . "/../templates/alertas.php";

?>

<form action="/crear-cuenta" class="formulario" method="POST">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo s($usuario->nombre); ?>">
    </div>
    <div class="campo">
        <label for="nombre">Apellido</label>
        <input type="text" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo s($usuario->apellido); ?>">
    </div>
    <div class="campo">
        <label for="nombre">Número de Teléfono</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Nº de Teléfono" value="<?php echo s($usuario->telefono); ?>">
    </div>
    <div class="campo">
        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" name="email" placeholder="Dirección de Correo Electrónico" value="<?php echo s($usuario->email); ?>">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Contraseña">
    </div>

    <input type="submit" class="boton" value="Crear Cuenta">
</form>


<div class="acciones">
    <a href="/">Iniciar Sesión</a>
    <a href="/olvide">Olvidé mi Contraseña</a>
</div>