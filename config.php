<?php
// config.php
// Apenas a definição do usuário e hash da senha
// Nada de banco de dados

define('ADMIN_USER', 'admin');
// Hash da senha 'arcevo2026' (gerado com password_hash)
define('ADMIN_PASS_HASH', 'marciogatao');

// Opcional: caminho do arquivo JSON
define('LIVROS_JSON', __DIR__ . '/livros.json');
?>
