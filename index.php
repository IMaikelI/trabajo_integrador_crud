<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <label>Nuevo cliente</label>
        <div>
            <form action="index.php" method="post">
                <label>Nombre</label>
                <input type="text" name="name">
                
                <label>Apellido</label>
                <input type="text" name="sname">

                <label>Pais</label>
                <?php
                    $con = mysqli_connect("localhost","root","","base")
                    
                    $sql = "SELECT * FROM paises"
                    $r = mysqli_query ($con, $sql)

                    echo "<select name = 'pais'>"
                    while ($row = mysqli_fetch_assoc($r)){
                        echo "<option value='$row['iso']'>". $row["nombre"] ."</option>"
                    }
                    echo "</select>"
                ?>

                <label>Numero</label>
                <input type="number" name="num">

                <input type="submit" value="Añadir">
            </form>

            <?php
                $con = mysqli_connect("localhost","root","","base")
                    
                $sql1 = "SELECT * FROM clientes"
                $r = mysqli_query ($con, $sql1)
                
                echo "<div>"
                while ($row = mysqli_fetch_assoc($r)){
                    echo ""
                }
                echo "</div>"
            ?>
        </div>
    </div>
</body>
</html>
