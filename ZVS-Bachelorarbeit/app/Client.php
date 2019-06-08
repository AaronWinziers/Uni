<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    // TODO Everything here
    //
    protected $table = 'CLIENTS';

    protected $primaryKey = 'id';

    public $timestamps = true;

    /**
     *  Returns a list of the names of all clients
     * @return array
     */
    public static function clientList(){
        return Client::all()->pluck('name')->toArray();
    }


    /** Getter function for client id
     *
     * @return mixed
     */
    public function getID(){
        return $this->id;
    }

    /** Getter function for client name
     *
     * @return mixed
     */
    public function getName(){
        return $this->name;
    }

}
