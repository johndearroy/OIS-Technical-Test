<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bank_accounts';

    protected $fillable = [
        'financial_organization_id',
        'store_id',
        'account_name',
        'account_no',
        'branch',
        'account_type',
        'swift_code',
        'route_no'
    ];

    public function bank()
    {
        return $this->belongsTo(FinancialOrganization::class, 'financial_organization_id', 'id');
    }
}
