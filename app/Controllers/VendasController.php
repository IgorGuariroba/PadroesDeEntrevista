<?php
namespace App\Controllers;

use App\Models\VendasModel;

class VendasController {
    private $model;

    public function __construct() {
        $this->model = new VendasModel();
    }

    public function index() {
        require __DIR__ . '/../Views/vendas.php';
    }

    public function calcular() {
        $vendasJson = $_POST['vendas'] ?? null;
        $dias = isset($_POST['dias']) ? intval($_POST['dias']) : 0;

        header('Content-Type: application/json');

        if (!$vendasJson || $dias <= 0) {
            echo json_encode(['erro' => 'Dados inválidos']);
            return;
        }

        $vendas = json_decode($vendasJson, true);
        if (!is_array($vendas)) {
            echo json_encode(['erro' => 'Formato inválido para vendas']);
            return;
        }

        $resultado = $this->model->calcularMaiorVolumeDeVendasPorPeriodo($vendas, $dias);
        echo json_encode(['resultado' => $resultado]);
    }
}
