<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Custom_field extends Model
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
        'active' => 'boolean',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
//    public $translatedAttributes = ['name'];



    public function scopeActive($query){
        return $query -> where('active',1) ;
    }
    public function scopeSelection($query)
    {

        return $query->select('id', 'translation_lang', 'name', 'active', 'translation_of');
    }
    public function getActive(){
        return  $this -> active  == 0 ?  'غير مفعل'   : 'مفعل' ;
    }
    public  function values(){
        return $this -> hasMany(Custom_field_value::class,'custom_field_id','id');
    }

}
