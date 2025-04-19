<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;
use App\Models\FlightClass;
use App\Models\Transaction;
use App\Models\TransactionPassenger;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function getTransactionDataFromSession()
    {
        return session()->get('transaction');
    }

    public function saveTransactionDataToSession($data)
    {
        $transaction = session()->get('transaction', []);

        foreach ($data as $key => $value) {
            $transaction[$key] = $value;
        }

        session()->get('transaction', $transaction);
    }

    public function saveTransaction($data)
    {
        $data['code'] = $this->generateTransactionCode();
        $data['number_of_passengers'] = $this->countPassengers($data['passengers']);

        $data['subtotal'] = $this->calculateSubtotal($data['flight_class_id'], $data['number_of_passengers']);
        $data['grandTotal'] = $data['subtotal'];

        if (!empty($data['promo_code'])) {
            $data = $this->applyPromoCode($data);
        }

        $data['grandTotal'] = $this->addPPN($data['grandTotal']);

        $transaction = $this->createTransaction($data);
        $this->savePassengers($data['passengers'], $transaction->id);

        session()->forget('transaction');
        return $transaction;
    }

    private function generateTransactionCode()
    {
        return 'TICKET' . rand(1000, 9999);
    }

    private function countPassengers($passengers)
    {
        return count($passengers);
    }

    private function calculateSubtotal($flightClassId, $numberOfPassengers)
    {
        $price = FlightClass::findOrFail($flightClassId)->price;
        return $price * $numberOfPassengers;
    }

    private function applyPromoCode($data)
    {
        $promo = PromoCode::where('code', $data['promo_code'])
            ->where('valid_until', '>=', now())
            ->where('is_used', false)
            ->first();

        if (!$promo) {
            return $data;
        }

        $discountAmount = $promo->discount_type === 'percentage'
            ? $data['grandtotal'] * ($promo->discount / 100)
            : $promo->discount;

        $data['discount'] = $discountAmount;
        $data['grandtotal'] = max(0, $data['grandtotal'] - $data['discount']);
        $data['promo_code_id'] = $promo->id;

        $promo->update(['is_used' => true]);

        return $data;
    }

    private function addPPN($grandtotal)
    {
        $ppn = $grandtotal * 0.11;
        return $grandtotal + $ppn;
    }

    private function createTransaction($data)
    {
        return Transaction::create($data);
    }

    private function savePassengers($passengers, $transactionId)
    {
        foreach ($passengers as $passenger) {
            $passenger['transaction_id'] = $transactionId;
            TransactionPassenger::create($passenger);
        }
    }

    public function getTransactionByCode($code)
    {
        return Transaction::where('code', $code)->first();
    }

    public function getTransactionByCodeEmailPhone($code, $email, $phone)
    {
        return Transaction::where('code', $code)->where('email', $email)->where('phone', $phone)->first();
    }
}
