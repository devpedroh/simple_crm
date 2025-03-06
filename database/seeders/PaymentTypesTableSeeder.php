<?php

namespace Database\Seeders;

use App\Models\Dashboard\Utils\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentTypes = [
            ['name' => 'À Vista', 'short_form' => 'avista'],
            ['name' => 'Parcelado', 'short_form' => 'parcelado'],
            ['name' => 'Entrada + Parcelas', 'short_form' => 'entrada_parcelas'],
            ['name' => 'Recorrente', 'short_form' => 'recorrente'],
            ['name' => 'Assinatura', 'short_form' => 'assinatura'],
            ['name' => 'Pré-pago', 'short_form' => 'pre_pago'],
            ['name' => 'Pós-pago', 'short_form' => 'pos_pago'],
            ['name' => 'Débito Automático', 'short_form' => 'debito_automatico'],
        ];

        foreach ($paymentTypes as $type) {
            PaymentType::updateOrCreate(['short_form' => $type['short_form']], $type);
        }
    }
}
