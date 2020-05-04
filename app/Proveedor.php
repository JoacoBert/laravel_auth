<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $gln
 * @property string $created_at
 * @property string $updated_at
 * @property Empresa $empresa
 * @property InsumoEspecifico[] $insumoEspecificos
 * @property TicketEntradaInsumoNoTrazable[] $ticketEntradaInsumoNoTrazables
 */
class Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'proveedor';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['gln', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insumoEspecificos()
    {
        return $this->hasMany('App\InsumoEspecifico');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ticketEntradaInsumoNoTrazables()
    {
        return $this->hasMany('App\TicketEntradaInsumoNoTrazable');
    }
}
