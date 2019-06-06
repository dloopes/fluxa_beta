<?php
$daoUsuario = new Projeto\persistence\DAOUsuario;
$usuarios = $daoUsuario->buscarUsuarios(null);

print_r($usuarios);