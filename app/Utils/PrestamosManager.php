<?php


namespace App\Utils;


use App\PrestamoDevolucion;
use Illuminate\Support\Facades\DB;

class PrestamosManager
{

    public static function getLimiteRestanteCliente($id_cliente)
    {
        $credito = DB::table('credito_cliente')
            ->where('cliente_id', '=',$id_cliente)
            ->where('fecha_hasta', '=', null)
            ->get()->first();

        if (is_null($credito)) {
            return 0;
        }

        $limite = $credito->limite;

        $prestado = DB::table('prestamo_cliente as p')
            ->where('p.anulado', '=', false)
            ->join('op_detalle_no_trazable as opnt', 'opnt.id', 'p.op_detalle_id')
            ->join('orden_de_produccion_detalle as opd', 'opd.id', 'opnt.op_detalle_id')
            ->join('orden_de_produccion as op','op.id','=','opd.op_id')
            ->where('op.anulada','=', false)
            ->join('alimento as a','op.producto_id','=','a.id')
            ->where('a.cliente_id','=',$id_cliente)
            ->sum('opd.cantidad');

        $devuelto = DB::table('prestamo_devoluciones as pd')
            ->join('prestamo_cliente as p', 'pd.prestamo_id', '=', 'p.id')
            ->where('p.anulado', '=', false)
            ->join('op_detalle_no_trazable as opnt', 'opnt.id', 'p.op_detalle_id')
            ->join('orden_de_produccion_detalle as opd', 'opd.id', 'opnt.op_detalle_id')
            ->join('orden_de_produccion as op','op.id','=','opd.op_id')
            ->where('op.anulada','=', false)
            ->join('alimento as a','op.producto_id','=','a.id')
            ->where('a.cliente_id','=',$id_cliente)
            ->sum('pd.cantidad');


        return $limite - $prestado + $devuelto;
    }


    public static function registrarDevolucionInsumo($idCliente, $idInsumo, $idTicketEntrada, $cantidadIngreso) : int {

        $deudas = DB::table('prestamo_cliente as p')
            ->join('op_detalle_no_trazable as opnt', 'opnt.id', '=', 'p.op_detalle_id')
            ->join('orden_de_produccion_detalle as opd', 'opd.id', '=', 'opnt.op_detalle_id')
            ->where('opnt.insumo_id', '=', $idInsumo)
            ->join('orden_de_produccion as op','op.id','=','opd.op_id')
            ->where('op.anulada','=', false)
            ->where('p.anulado', '=', false)                    // Es redundante pq si prestamo anulado -> op anulada
            ->join('alimento as a','op.producto_id','=','a.id')
            ->where('a.cliente_id','=',$idCliente)
            ->select('p.id','p.cancelado', 'opd.cantidad',DB::raw('(opd.cantidad - p.cancelado) as saldoAdeudado'))
            ->get();

        $saldoIngreso = $cantidadIngreso;

        $i = 0;
        while ($saldoIngreso > 0 && $i < sizeof($deudas)) {
            $deuda = $deudas[$i];
            $idPrestamo = $deuda->id;
            $saldoAdeudado = $deuda->saldoAdeudado;

            $devolucion = new PrestamoDevolucion();
            $devolucion->prestamo_id = $idPrestamo;
            $devolucion->ticket_entrada_id = $idTicketEntrada;

            if ($saldoAdeudado <= $saldoIngreso) {
                $devolucion->cantidad = $saldoAdeudado;
                $saldoIngreso -= $saldoAdeudado;
            } else {
                $devolucion->cantidad = $saldoIngreso;
                $saldoIngreso = 0;
            }
            $devolucion->save(); // Dispara un trigger que actualiza el saldo cancelado del prestamo
            $i++;
        }

        return $saldoIngreso;
    }

}
