<?php
// lee el archivo Readme al principio del repositorio
    header('Content-Type: application/json');

    require ('conexion.php');


    switch ($_GET['accion']){
        case 'listar':
            $consulta = "SELECT id, titulo as title, descripcion,inicio as start, fin as end,colorText,colorBackground, participante from eventos";
            $datos = mysqli_query($CRM, $consulta);
            $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
            echo json_encode($resultado);
            break;

            //funcion Agregar
        case 'agregar':
            $consulta2 = "INSERT INTO eventos (titulo, descripcion, inicio, fin, colorText,colorBackground) VALUES ('$_POST[titulo]','$_POST[descripcion]', '$_POST[inicio]', '$_POST[fin]', '$_POST[colorText]', '$_POST[colorBackground]')";
            $respuesta = mysqli_query($CRM,$consulta2);
            echo json_encode($respuesta);
            break;
        case 'modificar':
            $consulta3 = "UPDATE eventos set titulo='$_POST[titulo]', descripcion = '$_POST[descripcion]', inicio = '$_POST[inicio]', fin = '$_POST[fin]', colorText = '$_POST[colorText]', colorBackground='$_POST[colorBackground]' WHERE id = '$_POST[id]'";
            $respuesta2 = mysqli_query($CRM,$consulta3);
            echo json_encode($respuesta2);
            break;
        case 'borrar':
            $consulta4 = "DELETE from eventos where id = $_POST[id]";
            $respuesta3 = mysqli_query($CRM, $consulta4);
            echo json_encode($respuesta3);
            break;
    }
?>
