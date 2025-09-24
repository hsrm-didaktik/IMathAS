<?php
global $allowedmacros;
array_push($allowedmacros,"js_setCookie","getCookie", "js_setLocal", "js_getLocal", "js_clearLocal", "js_setSession", "js_getSession");



function js_setCookie($key,$val) {
    $valencoded=rawurlencode($val);
    return "<script>
    document.cookie=\"$key=$valencoded\";
    </script>";
}

function getCookie($cookie_name) {
    if (!isset($_COOKIE[$cookie_name])) {
        return NULL;
    } else {
        return $_COOKIE[$cookie_name];
    }
}

function js_setLocal($key,$val) {
    return "<script>
    localStorage.setItem(\"$key\",\"$val\");
    </script>";
}

function js_getLocal($key) {
    return "<span id=\"$key\"></span>
    <script>
        let val = localStorage.getItem(\"$key\");
        document.getElementById(\"$key\").innerHTML=val;
    </script>";
}

function js_clearLocal($label="Clear my data on this device",$confirm="Data deleted from local storage") {
    return "<input type='button' value='$label' onClick='localStorage.clear();alert(\"$confirm\");'>";
}

function js_setSession($key,$val) {
    return "<script>
    window.sessionStorage.setItem(\"$key\",\"$val\");
    </script>";
}

function js_getSession($key) {
    return "<span id=\"$key\"></span>
    <script>
        let val = window.sessionStorage.getItem(\"$key\");
        console.log('Session:'+val);
        document.getElementById(\"$key\").innerHTML=val;
    </script>";
}
?>