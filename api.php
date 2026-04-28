<?php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

// Função para carregar livros do JSON
function carregarLivros() {
    if (!file_exists(LIVROS_JSON)) {
        file_put_contents(LIVROS_JSON, json_encode([]));
        return [];
    }
    $json = file_get_contents(LIVROS_JSON);
    return json_decode($json, true) ?? [];
}

// Função para salvar livros no JSON
function salvarLivros($livros) {
    file_put_contents(LIVROS_JSON, json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Verifica se usuário é admin (para POST, PUT, DELETE)
function isAdmin() {
    return isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true;
}

$method = $_SERVER['REQUEST_METHOD'];

// GET: listar livros (público)
if ($method === 'GET') {
    $livros = carregarLivros();
    echo json_encode($livros);
    exit;
}

// As demais operações exigem login -----------------
if (!isAdmin()) {
    http_response_code(401);
    echo json_encode(['error' => 'Não autorizado']);
    exit;
}

// POST: criar novo livro
if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $livros = carregarLivros();
    $id = 'l' . time() . rand(100, 999);
    $novo = [
        'id' => $id,
        'titulo' => $data['titulo'],
        'autor' => $data['autor'],
        'genero' => $data['genero'],
        'editora' => $data['editora'] ?? '',
        'ano' => $data['ano'] ?? '',
        'paginas' => $data['paginas'] ?? null,
        'preco' => $data['preco'],
        'precoAnt' => $data['precoAnt'] ?? '',
        'tag' => $data['tag'] ?? '',
        'isbn' => $data['isbn'] ?? '',
        'sinopse' => $data['sinopse'] ?? '',
        'cor' => $data['cor']
    ];
    $livros[] = $novo;
    salvarLivros($livros);
    echo json_encode(['success' => true, 'id' => $id]);
    exit;
}

// PUT: editar livro
if ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    $livros = carregarLivros();
    $index = array_search($data['id'], array_column($livros, 'id'));
    if ($index !== false) {
        $livros[$index] = array_merge($livros[$index], [
            'titulo' => $data['titulo'],
            'autor' => $data['autor'],
            'genero' => $data['genero'],
            'editora' => $data['editora'] ?? '',
            'ano' => $data['ano'] ?? '',
            'paginas' => $data['paginas'] ?? null,
            'preco' => $data['preco'],
            'precoAnt' => $data['precoAnt'] ?? '',
            'tag' => $data['tag'] ?? '',
            'isbn' => $data['isbn'] ?? '',
            'sinopse' => $data['sinopse'] ?? '',
            'cor' => $data['cor']
        ]);
        salvarLivros($livros);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Livro não encontrado']);
    }
    exit;
}

// DELETE: excluir livro
if ($method === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $livros = carregarLivros();
    $livros = array_filter($livros, function($l) use ($data) {
        return $l['id'] !== $data['id'];
    });
    salvarLivros(array_values($livros));
    echo json_encode(['success' => true]);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Método não permitido']);
?>
