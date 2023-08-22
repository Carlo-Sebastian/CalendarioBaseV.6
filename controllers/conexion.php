<?php
    $CRM = new mysqli('localhost','root','','tablas');
    $error = $CRM->connect_errno;
    if ($error!=0) {
        print("Error de conexión");
    }
?>
