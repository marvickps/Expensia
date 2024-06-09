<?php
session_start();

function ErrorMessage(){
    if(isset($_SESSION["ErrorMessage"])){
        $Output = "<div class=\"bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative\" role=\"alert\">";
        $Output .= htmlentities($_SESSION["ErrorMessage"]);
        $Output .="</div>";
        $_SESSION["ErrorMessage"] = null;
        return $Output;
    }
}

function SuccessMessage(){
    if(isset($_SESSION["SuccessMessage"])){
        $Output = "<div class=\"bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative\" role=\"alert   \">";
        $Output .= htmlentities($_SESSION["SuccessMessage"]);
        $Output .="</div>";
        $_SESSION["SuccessMessage"] = null;
        return $Output;
    }
}


?>