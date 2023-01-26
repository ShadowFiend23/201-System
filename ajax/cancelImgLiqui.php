<?php 

    if(isset($_POST["paths"])){

        for($i=0; $i<count($_POST["paths"]); $i++){
            unlink($_POST["paths"][$i]);
        }

    }

?>