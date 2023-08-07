<h1 class="nombre-pagina">Reestablecer Contraseña</h1>
<p class="descripcion-pagina">Escriba su nueva Contraseña</p>
<?php
include_once __DIR__ . "/../templates/alertas.php";

?>

<?php
if($error) return;
?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Nueva Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Contraseña Nueva">
    </div>

    <input type="submit" class="boton" value="Actualizar Contraseña">
</form>

<div class="acciones">
    <a href="/">Iniciar Sesión</a>
    <a href="/crear-cuenta">Crear Cuenta</a>
</div>