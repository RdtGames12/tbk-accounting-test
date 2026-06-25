<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['transaction_date', 'coa_id', 'description', 'debit', 'credit'];

    public function coa() {
        return $this->belongsTo(Coa::class);
    }
}
