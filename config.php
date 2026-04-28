<?php
// config.php
// Apenas a definição do usuário e hash da senha
// Nada de banco de dados

define('ADMIN_USER', 'admin');
// Hash da senha 'arcevo2026' (gerado com password_hash)
define('ADMIN_PASS_HASH', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

// Opcional: caminho do arquivo JSON
define('LIVROS_JSON', __DIR__ . '/livros.json');
?>
