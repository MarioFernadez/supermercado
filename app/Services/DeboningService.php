<?php

namespace App\Services;

use App\Models\Product;
use App\Models\DeboningSession;
use App\Models\DeboningItem;
use Illuminate\Support\Facades\DB;
use Exception;

class DeboningService
{
    /**
     * Create and record a complete meat deboning session.
     *
     * @param array $data
     * @return DeboningSession
     * @throws Exception
     */
    public function createSession(array $data): DeboningSession
    {
        return DB::transaction(function () use ($data) {
            $rawMaterialId = $data['raw_material_product_id'];
            $totalStart = (float) $data['total_weight_start'];
            $items = $data['items'];
            $notes = $data['notes'] ?? '';
            $userId = $data['user_id'];

            $rawMaterial = Product::lockForUpdate()->findOrFail($rawMaterialId);

            if ($rawMaterial->stock < $totalStart) {
                throw new Exception("El stock de la materia prima es insuficiente. Stock actual: {$rawMaterial->stock} Kg");
            }

            // Calculate total yield and waste
            $totalYield = (float) collect($items)->sum(fn($item) => floatval($item['weight'] ?? 0));
            $wasteWeight = max(0, $totalStart - $totalYield);

            if ($totalYield > $totalStart) {
                throw new Exception("El peso total de los cortes ({$totalYield} Kg) no puede superar el peso inicial ({$totalStart} Kg).");
            }

            // 1. Create Session
            $session = DeboningSession::create([
                'raw_material_product_id' => $rawMaterialId,
                'user_id'                 => $userId,
                'total_weight_start'      => $totalStart,
                'total_weight_yield'      => $totalYield,
                'waste_weight'            => $wasteWeight,
                'status'                  => 'completed',
                'notes'                   => $notes,
            ]);

            // 2. Deduct Raw Material Stock
            $rawMaterial->decrement('stock', $totalStart);

            // 3. Create items and increment cut stock
            foreach ($items as $item) {
                $weight = (float) $item['weight'];
                if ($weight <= 0) continue;

                DeboningItem::create([
                    'deboning_session_id' => $session->id,
                    'product_id'          => $item['product_id'],
                    'weight'              => $weight,
                ]);

                Product::where('id', $item['product_id'])->increment('stock', $weight);
            }

            return $session;
        });
    }
}
