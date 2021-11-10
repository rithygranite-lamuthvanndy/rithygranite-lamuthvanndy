<?php 
    if(isset($_GET['p_status'])){
        setcookie(
            "is_monthly_spare_part",
            !$_GET['p_status'],
            time() + (10 * 365 * 24 * 60 * 60)
        );
    }
?>