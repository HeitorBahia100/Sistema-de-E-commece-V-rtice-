<?php
declare(strict_types=1);

function db(): mysqli {
    static $connection = null;
    if ($connection instanceof mysqli) {
        return $connection;
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $connection = new mysqli('127.0.0.1', 'root', '', 'vertice_store');
        $connection->set_charset('utf8mb4');
        return $connection;
    } catch (mysqli_sql_exception $exception) {
        http_response_code(500);
        exit('Não foi possível conectar ao banco de dados. Verifique se o MySQL está iniciado.');
    }
}
