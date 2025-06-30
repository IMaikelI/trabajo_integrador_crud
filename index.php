<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "base");

function redirect() {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $apellido = $_POST['apellido'];
    $pais = $_POST['pais'];
    $num = $_POST['num'];

    $sql_insert = "INSERT INTO clientes (nombre, apellido, pais, numero) VALUES ('$name', '$apellido', '$pais', '$num')";
    mysqli_query($con, $sql_insert);

    $_SESSION['mensaje'] = "Cliente añadido correctamente.";
    redirect();
}

if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    mysqli_query($con, "DELETE FROM clientes WHERE id = $id");
    $_SESSION['mensaje'] = "Cliente eliminado correctamente.";
    redirect();
}

if (isset($_POST['update_id'])) {
    $id = $_POST['update_id'];
    $name = $_POST['name'];
    $apellido = $_POST['apellido'];
    $pais = $_POST['pais'];
    $num = $_POST['num'];

    $sql_update = "UPDATE clientes SET nombre='$name', apellido='$apellido', pais='$pais', numero='$num' WHERE id=$id";
    mysqli_query($con, $sql_update);

    $_SESSION['mensaje'] = "Cliente actualizado correctamente.";
    redirect();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Nuevo Cliente</h2>

<?php

if (isset($_SESSION['mensaje'])) {
    echo "<p><strong>" . $_SESSION['mensaje'] . "</strong></p>";
    unset($_SESSION['mensaje']);
}
?>

<form method="post" action="">
    <label>Nombre</label>
    <input type="text" name="name" required>

    <label>Apellido</label>
    <input type="text" name="apellido" required>

    <label>País</label>
    <select name="pais" required>
        <?php
        $res_paises = mysqli_query($con, "SELECT * FROM paises");
        while ($row = mysqli_fetch_assoc($res_paises)) {
            echo "<option value='" . $row['nombre'] . "'>" . $row["nombre"] . "</option>";
        }
        ?>
    </select>

    <label>Número</label>
    <input type="number" name="num" required>

    <input type="submit" name="add" value="Añadir">
</form>

<hr>

<h2>Lista de Clientes</h2>

<?php
$res_clientes = mysqli_query($con, "SELECT * FROM clientes");

while ($row = mysqli_fetch_assoc($res_clientes)) {
    echo "<div class='cliente'>";
    echo "<p><strong>Cliente ID:</strong> " . $row['id'] . "</p>";
    echo "<p>Nombre: " . $row['nombre'] . "</p>";
    echo "<p>Apellido: " . $row['apellido'] . "</p>";
    echo "<p>País: " . $row['pais'] . "</p>";
    echo "<p>Número: " . $row['numero'] . "</p>";

    echo "<form method='post' style='display:inline;'>";
    echo "<input type='hidden' name='delete_id' value='" . $row['id'] . "'>";
    echo "<input type='submit' value='Eliminar'>";
    echo "</form> ";

    echo "<form method='post' style='display:inline;'>";
    echo "<input type='hidden' name='edit_id' value='" . $row['id'] . "'>";
    echo "<input type='submit' value='Editar'>";
    echo "</form>";
    echo "</div>";
}

if (isset($_POST['edit_id'])) {
    $id = $_POST['edit_id'];
    $res_edit = mysqli_query($con, "SELECT * FROM clientes WHERE id = $id");
    $cliente = mysqli_fetch_assoc($res_edit);
    ?>

    <hr>
    <h2>Editar Cliente ID: <?php echo $id; ?></h2>
    <form method="post" action="">
        <input type="hidden" name="update_id" value="<?php echo $id; ?>">

        <label>Nombre</label>
        <input type="text" name="name" value="<?php echo $cliente['nombre']; ?>" required>

        <label>Apellido</label>
        <input type="text" name="apellido" value="<?php echo $cliente['apellido']; ?>" required>

        <label>País</label>
        <input type="text" name="pais" value="<?php echo $cliente['pais']; ?>" required>

        <label>Número</label>
        <input type="number" name="num" value="<?php echo $cliente['numero']; ?>" required>

        <input type="submit" value="Guardar Cambios">
    </form>
<?php } ?>

</body>
</html>
