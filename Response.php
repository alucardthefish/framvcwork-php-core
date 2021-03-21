<?php
# **************************************************************************** 
# File: Response.php 
# Author: alucardthefish 
# Created: Sat Feb 13 19:49:01 2021 
# Description:  
# **************************************************************************** 

namespace app\core;

class Response {

    public function setStatusCode($code) {
        http_response_code($code);
    }

    public function redirect($url) {
        header('Location: ' . $url);
    }
}

?>

