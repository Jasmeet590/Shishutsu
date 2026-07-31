<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    // table name
   protected $table = "parties";

   // primary key
   protected $primaryKey = "id";

   // fillable fields
   protected $fillable = array('party_type', 'user_id', 'full_name', 'phone_no', 'address', 'account_holder_name', 'account_no', 'bank_name', 'ifsc_code', 'branch_address');

   public function user()
   {
       return $this->belongsTo(User::class);
   }

   public function gstBills()
   {
       return $this->hasMany(GstBill::class);
   }

   public function scopeOwnedBy($query, $userId = null)
   {
       return $query->where('user_id', $userId ?? auth()->id());
   }

}
