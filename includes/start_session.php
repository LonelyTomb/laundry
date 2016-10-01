<?php
ini_set('session.cookie_httponly', 1);
ini_set("session.hash_function","sha512");
ini_set("session.hash_bits_per_character", 5);
ini_set("session.use_strict_mode",1);
// ini_set("session.cookie_domain","localhost/webClass/wk");
#ini_set("session.cookie_secure",1);
ini_set("session.entropy_file","/dev/urandom");
ini_set("session.entropy_length", "512");
session_name('pd');
session_start();
session_regenerate_id();
