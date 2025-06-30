<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <label>Nuevo cliente</label>
        <div>
            <form action="index.php" method="post">
                <label>Nombre</label>
                <input type="text" name="name" placeholder="Nombre" required>
                
                <label>Apellido</label>
                <input type="text" name="apellido" placeholder="apellido" required>

                <label>Pais</label>
                <?php
                    $con = mysqli_connect("localhost","root","","base");
                    
                    $sql = "SELECT * FROM paises";
                    $r = mysqli_query ($con, $sql);

                    echo "<select name = 'pais' placeholder='pais' required>";
                    while ($row = mysqli_fetch_assoc($r)){
                        echo "<option value='" . $row['nombre'] . "'>" . $row["nombre"] . "</option>";

                    };
                    echo "</select>";
                ?>

                <label>Numero</label>
                <input type="number" name="num" required>

                <input type="submit" value="Añadir">
            </form> 
        </div>
    </div>
            <?php
            $con = mysqli_connect("localhost","root","","base");

            $name = $_POST['name'];
            $apellido = $_POST['apellido'];
            $pais = $_POST['pais'];
            $num = $_POST['num'];

            $sql0 = "INSERT INTO clientes (nombre, apellido, pais, numero) VALUES ('$name', '$apellido', '$pais', '$num')";

            $r0 = mysqli_query ($con, $sql0);
            ?>

            <?php
                $con = mysqli_connect("localhost","root","","base");
                    
                $sql1 = "SELECT * FROM clientes";
                $r1 = mysqli_query ($con, $sql1);
                
                if ($r1 && mysqli_num_rows($r1) > 0) {
                echo "<div class='clientes'>";
                while ($row = mysqli_fetch_assoc($r1)) {
                    echo "<div class='cliente'>";
                    echo "<label> Cliente ". $row["id"] . "</label>";
                    echo "<label> Nombre: " . $row["nombre"] . "</label> ";
                    echo "<label> Apellido: " . $row["apellido"] . "</label> ";
                    echo "<label> Pais: " . $row["pais"] . "</label> ";
                    echo "<label> Numero: " . $row["numero"] . "</label>";
                    echo "</div>";

                    echo "<form action='' method='post' style='display:inline;'>";
                    echo "<input type='hidden' name='delete_id' value='" . $row["id"] . "'>";
                    echo "<input type='submit' value='Eliminar'>";
                    echo "</form> ";

                    echo "<form action='' method='post' style='display:inline;'>";
                    echo "<input type='hidden' name='edit_id' value='" . $row["id"] . "'>";
                    echo "<input type='submit' value='Editar'>";
                    echo "</form>";

                }
                } else {
                    echo "No se encontraron registros.";
                }

                if (isset($_POST['delete_id'])) {
                    $delete_id = $_POST['delete_id'];
                    $sql_delete = "DELETE FROM clientes WHERE id = $delete_id";
                    mysqli_query($con, $sql_delete);
                }

                if (isset($_POST['edit_id'])) {
                    $edit_id = $_POST['edit_id'];
                    $sql_edit = "SELECT * FROM clientes WHERE id = $edit_id";
                    $result_edit = mysqli_query($con, $sql_edit);
                    $cliente = mysqli_fetch_assoc($result_edit);

                    echo "<h3>Editar Cliente ID: $edit_id</h3>";
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='update_id' value='" . $edit_id . "'>";
                    echo "<label>Nombre</label><input type='text' name='name' value='" . $cliente['nombre'] . "' required>";
                    echo "<label>Apellido</label><input type='text' name='apellido' value='" . $cliente['apellido'] . "' required>";
                    echo "<label>Pais</label><input type='text' name='pais' value='" . $cliente['pais'] . "' required>";
                    echo "<label>Numero</label><input type='number' name='num' value='" . $cliente['numero'] . "' required>";
                    echo "<input type='submit' value='Actualizar'>";
                    echo "</form>";
                }

            ?>


</body>
</html>
