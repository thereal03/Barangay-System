<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    // Define the table name (if different from the default 'residents')
    protected $table = 'resident';

    // Define the primary key (if different from the default 'id')
    protected $primaryKey = 'id';

    // Allow mass assignment for these columns
    protected $fillable = [
        'first_name', 
        'last_name', 
        'gender', 
        'address', 
        'contact_number', 
        'email', 
        'dob', 
        'created_at', 
        'updated_at'
    ];

    // Disable timestamps if you are manually handling the created_at and updated_at fields
    public $timestamps = false;

    // Optionally, define any mutators or accessors (like formatting dates, etc.)

    // Example for formatting date of birth:
    // public function getDobAttribute($value)
    // {
    //     return \Carbon\Carbon::parse($value)->format('d-m-Y');
    // }

}
