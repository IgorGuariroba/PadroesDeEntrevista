<?php
namespace App\Models;

class VendasModel {
    public function calcularMaiorVolumeDeVendasPorPeriodo(array $vendasPorDia, int $diasConsecutivos): int {
        $maiorVolume = 0;
        $somaPeriodoAtual = 0;
        $indiceInicioPeriodo = 0;

        for ($indiceDiaAtual = 0; $indiceDiaAtual < count($vendasPorDia); $indiceDiaAtual++) {
            $somaPeriodoAtual += $vendasPorDia[$indiceDiaAtual];

            if ($indiceDiaAtual >= $diasConsecutivos - 1) {
                $maiorVolume = max($maiorVolume, $somaPeriodoAtual);
                $somaPeriodoAtual -= $vendasPorDia[$indiceInicioPeriodo];
                $indiceInicioPeriodo++;
            }
        }

        return $maiorVolume;
    }
}
