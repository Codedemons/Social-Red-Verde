<?php

Session::delete("user_id");
session_destroy();
Core::redir("./");

?>