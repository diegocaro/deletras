<?php
    function facebook_hashemail($email) {
      if ($email != null) {
        $email = trim(strtolower($email));
        return sprintf("%u", crc32($email)) . '_' . md5($email);
      } else {
        return '';
      }
    }
?>
