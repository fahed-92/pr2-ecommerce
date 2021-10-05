<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Custom_field_value extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['translation_lang', 'translation_of', 'name','active'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['name'];



    public function scopeActive($query){
        return $query -> where('is_active',1) ;
    }
    public function getActive(){
        return  $this -> is_active  == 0 ?  'غير مفعل'   : 'مفعل' ;
    }

    public  function custom_fields(){
        return $this -> belongsTo(Custom_field::class,'custom_field_id','id');
    }
}
