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
   protected $fillable = array('party_type', 'full_name', 'phone_no', 'address', 'account_holder_name', 'account_no', 'bank_name', 'ifsc_code', 'branch_address');


}
