<?php

namespace Database\Seeders;

use App\Models\Dashboard\Utils\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            ['name' => 'Dinheiro', 'short_form' => 'cash'],
            ['name' => 'Cartão de Crédito', 'short_form' => 'credit_card'],
            ['name' => 'Cartão de Débito', 'short_form' => 'debit_card'],
            ['name' => 'PIX', 'short_form' => 'pix'],
            ['name' => 'Boleto Bancário', 'short_form' => 'boleto'],
            ['name' => 'Transferência Bancária', 'short_form' => 'bank_transfer'],
            ['name' => 'TED', 'short_form' => 'ted'],
            ['name' => 'DOC', 'short_form' => 'doc'],
            ['name' => 'Cheque', 'short_form' => 'cheque'],
            ['name' => 'Carteira Digital', 'short_form' => 'digital_wallet'],
            ['name' => 'PayPal', 'short_form' => 'paypal'],
            ['name' => 'PagSeguro', 'short_form' => 'pagseguro'],
            ['name' => 'Mercado Pago', 'short_form' => 'mercadopago'],
            ['name' => 'PicPay', 'short_form' => 'picpay'],
            ['name' => 'Criptomoeda', 'short_form' => 'crypto'],
            ['name' => 'Vale-Alimentação', 'short_form' => 'meal_voucher'],
            ['name' => 'Vale-Refeição', 'short_form' => 'food_voucher'],
            ['name' => 'Crediário', 'short_form' => 'crediario'],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::updateOrCreate(['short_form' => $method['short_form']], $method);
        }
    }
}
