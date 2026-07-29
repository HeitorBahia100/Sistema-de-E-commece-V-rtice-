<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}

function is_owner(): bool {
    return (current_user()['role'] ?? '') === 'owner';
}

function has_owner(): bool {
    return (int) db()->query("SELECT COUNT(*) AS total FROM users WHERE role = 'owner'")->fetch_assoc()['total'] > 0;
}

function make_current_user_owner(): void {
    $user = current_user();
    if (!$user || has_owner()) return;
    $statement = db()->prepare("UPDATE users SET role = 'owner' WHERE id = ?");
    $statement->bind_param('i', $user['id']);
    $statement->execute();
    $_SESSION['user']['role'] = 'owner';
}

function create_user(string $name, string $email, string $password): string|bool {
    $email = strtolower(trim($email));
    $connection = db();
    $check = $connection->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
    $check->bind_param('s', $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        return 'Já existe uma conta com este e-mail.';
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $insert = $connection->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
    $insert->bind_param('sss', $name, $email, $hash);
    $insert->execute();

    $_SESSION['user'] = ['id' => $connection->insert_id, 'name' => $name, 'email' => $email, 'role' => 'customer'];
    return true;
}

function login_user(string $email, string $password): bool {
    $email = strtolower(trim($email));
    $statement = db()->prepare('SELECT id, name, email, password_hash, role FROM users WHERE email = ? LIMIT 1');
    $statement->bind_param('s', $email);
    $statement->execute();
    $user = $statement->get_result()->fetch_assoc();
    if (!$user || !password_verify($password, $user['password_hash'])) {
        return false;
    }

    $_SESSION['user'] = ['id' => (int) $user['id'], 'name' => $user['name'], 'email' => $user['email'], 'role' => $user['role']];
    return true;
}
