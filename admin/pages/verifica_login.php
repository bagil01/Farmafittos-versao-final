<?php
session_start();

// Verifica se está logado
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: ../index.php');
    exit;
}

// Verifica se é admin
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    echo "Acesso negado!";
    exit;
}
?>