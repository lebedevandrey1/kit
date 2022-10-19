<?php
session_start();
setcookie("login","",time()-50000);
setcookie("password","",time()-50000);
session_destroy();
header('Location: ../');
return;