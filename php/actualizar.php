<?php
  /* Actualizar THOR desde GitHub */
  error_reporting(E_ALL); 
  try {
    echo shell_exec('C:\Users\operador\Desktop\PortableGit\cmd\git.exe pull origin master');
  } catch (Exception $e) {
    echo $e->getMessage();
  }
?>