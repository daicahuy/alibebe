<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository extends BaseRepository {
    
    public function getModel()
    {
        return Payment::class;
    }
    
}