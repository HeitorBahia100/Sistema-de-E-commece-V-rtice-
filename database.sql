CREATE DATABASE IF NOT EXISTS vertice_store
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE vertice_store;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE users ADD COLUMN IF NOT EXISTS role ENUM('customer', 'owner') NOT NULL DEFAULT 'customer' AFTER password_hash;

CREATE TABLE IF NOT EXISTS products (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  category VARCHAR(80) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  old_price DECIMAL(10,2) NULL,
  image VARCHAR(500) NOT NULL,
  description TEXT NOT NULL,
  stock INT UNSIGNED NOT NULL DEFAULT 0,
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO products (name, category, price, old_price, image, description, stock)
SELECT 'Bolsa Soho', 'Acessórios', 189.90, 239.90, 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=900&q=85', 'Bolsa em couro sintético, elegante e espaçosa.', 12
WHERE NOT EXISTS (SELECT 1 FROM products LIMIT 1);

INSERT INTO products (name, category, price, old_price, image, description, stock)
SELECT 'Casaco Willow', 'Feminino', 229.90, 289.90, 'https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=900&q=85', 'Casaco leve de corte moderno para os dias frios.', 8 WHERE NOT EXISTS (SELECT 1 FROM products WHERE name = 'Casaco Willow');
INSERT INTO products (name, category, price, old_price, image, description, stock)
SELECT 'Tênis Aurora', 'Calçados', 159.90, 199.90, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=85', 'Tênis casual com design urbano e muito conforto.', 15 WHERE NOT EXISTS (SELECT 1 FROM products WHERE name = 'Tênis Aurora');
INSERT INTO products (name, category, price, old_price, image, description, stock)
SELECT 'Camisa Essencial', 'Masculino', 99.90, 129.90, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=85', 'Camisa básica premium para compor qualquer look.', 20 WHERE NOT EXISTS (SELECT 1 FROM products WHERE name = 'Camisa Essencial');
INSERT INTO products (name, category, price, old_price, image, description, stock)
SELECT 'Vestido Siena', 'Feminino', 179.90, 219.90, 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?auto=format&fit=crop&w=900&q=85', 'Vestido fluido e delicado para momentos especiais.', 10 WHERE NOT EXISTS (SELECT 1 FROM products WHERE name = 'Vestido Siena');
INSERT INTO products (name, category, price, old_price, image, description, stock)
SELECT 'Mochila City', 'Acessórios', 139.90, 169.90, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=900&q=85', 'Mochila versátil, perfeita para a rotina.', 9 WHERE NOT EXISTS (SELECT 1 FROM products WHERE name = 'Mochila City');
INSERT INTO products (name, category, price, old_price, image, description, stock)
SELECT 'Sandália Lume', 'Calçados', 119.90, 149.90, 'https://images.unsplash.com/photo-1562273138-f46be4ebdf33?auto=format&fit=crop&w=900&q=85', 'Sandália minimalista com acabamento sofisticado.', 14 WHERE NOT EXISTS (SELECT 1 FROM products WHERE name = 'Sandália Lume');
INSERT INTO products (name, category, price, old_price, image, description, stock)
SELECT 'Óculos Eclipse', 'Acessórios', 89.90, 119.90, 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=900&q=85', 'Óculos com lentes escuras e presença marcante.', 17 WHERE NOT EXISTS (SELECT 1 FROM products WHERE name = 'Óculos Eclipse');
