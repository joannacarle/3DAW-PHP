<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$action = $_GET['action'] ?? 'getCars';
$carsFile = __DIR__ . '/dados/carros.json';
$reservasFile = __DIR__ . '/dados/reservas.json';

$carsData = file_exists($carsFile) ? json_decode(file_get_contents($carsFile), true) : [];
$reservasData = file_exists($reservasFile) ? json_decode(file_get_contents($reservasFile), true) : [];

switch ($action) {
    case 'getCars':
        if (isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] !== 'all') {
            $typeFilter = strtolower($_GET['type']);
            $carsData = array_values(array_filter($carsData, function($car) use ($typeFilter) {
                return strtolower($car['type']) === $typeFilter;
            }));
        }
        echo json_encode($carsData);
        break;

    case 'getCarById':
        $id = intval($_GET['id'] ?? 0);
        $foundCar = null;
        foreach ($carsData as $car) {
            if ($car['id'] === $id) {
                $foundCar = $car;
                break;
            }
        }
        echo json_encode($foundCar);
        break;

    case 'criarReserva':
        $car_id = intval($_POST['car_id'] ?? 0);
        $nome = trim($_POST['nome'] ?? '');
        $documento = preg_replace('/[^0-9]/', '', $_POST['documento'] ?? '');
        $opcionais = $_POST['opcionais'] ?? [];
        $metodo_pagamento = $_POST['metodo_pagamento'] ?? '';
        $total = floatval($_POST['total'] ?? 0);

        if (empty($nome) || empty($documento) || $car_id === 0) {
            echo json_encode(["success" => false, "message" => "Dados obrigatórios ausentes."]);
            exit;
        }

        $veiculoNome = "Veículo Padrão";
        foreach ($carsData as $car) {
            if ($car['id'] === $car_id) {
                $veiculoNome = $car['name'];
                break;
            }
        }

        $codigoReserva = 'EZ-' . rand(10000, 99999);

        $novaReserva = [
            "codigo" => $codigoReserva,
            "nome" => $nome,
            "documento" => $documento,
            "veiculo" => $veiculoNome,
            "opcionais" => $opcionais,
            "pagamento" => $metodo_pagamento,
            "total" => $total,
            "status" => "Confirmada",
            "data_criacao" => date('d/m/Y H:i')
        ];

        $reservasData[] = $novaReserva;
        file_put_contents($reservasFile, json_encode($reservasData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        echo json_encode(["success" => true, "codigo" => $codigoReserva]);
        break;

    case 'procurarReserva':
        $doc = preg_replace('/[^0-9]/', '', $_POST['documento'] ?? '');
        $codigo = strtoupper(trim($_POST['reserva_codigo'] ?? ''));

        $encontrada = null;
        foreach ($reservasData as $res) {
            if ($res['codigo'] === $codigo && $res['documento'] === $doc) {
                $encontrada = $res;
                break;
            }
        }

        if ($encontrada) {
            echo json_encode(["success" => true, "message" => "Reserva localizada!", "data" => $encontrada]);
        } else {
            echo json_encode(["success" => false, "message" => "Nenhuma reserva localizada com os dados informados."]);
        }
        break;

    default:
        echo json_encode(["success" => false, "message" => "Ação inválida."]);
        break;
}
exit;