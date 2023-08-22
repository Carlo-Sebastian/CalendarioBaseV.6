<?php
    $CRM = new mysqli('localhost','root','','crm_lk');
    $error = $CRM->connect_errno;
    if ($error!=0) {
        print("Error de conexión");
    }
?>