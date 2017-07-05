<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
  	protected $table = 'fotos';

        public function parada() {
                return $this->belongsTo('App\Parada', 'parada_id');
        }

        /**
         * Guarda un nuevo audio en la base de datos
         * @param  array $args
         * @return Audio
         */
        public static function store($args) {

                $aud = new Photo;
                $aud->parada_id  = $args['spot'];
                $aud->path       = $args['path'];
                $aud->save();

                return $aud;
        }
 
}
