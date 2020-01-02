<?php

namespace App\Http\Controllers;

use App\inventario;
use Illuminate\Http\Request;
use Auth;
use App\entrada_inventario;
use App\salida_inventario;
use App\Paciente;
use App\venta;
use App\Clinica_doctor;
use App\Doctor;
use PDF;
use App\Clinica;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventario = inventario::where('doctor_id',Auth::user()->doctor_id)->get();      
        $pacientes = Paciente::where ('doctor_id',Auth::user()->doctor_id)->get();        
        return view ('Inventario/listadoInventario',compact('inventario','pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /* public function create()
    {
       return 
    } */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     
       $medicamento =  inventario::create([
            'codigo' => $request->codigomedicamento,
            'nombre' => $request->nombremedicamento,
            'Consentracion' => $request->concentracion,
            'fabricante' => $request->fabricantemedicamento,
            'stock' => $request->stock,
            'precio' => $request->precio,
            'precioiva' => $request->precioiva,
            'costo' => $request->costo,
            'fecha_exp' => $request->fechaexp,
            'doctor_id' => $request->doctor_id,
       ]);
       return redirect()->route('inventarios.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function show(inventario $inventario)
    {      
      $entradas = entrada_inventario::where('medicamento_id',$inventario->id)->orderBy('fecha_ingreso','ASC')
      ->paginate(5,['*'],'entradas');
      
      $salidas = salida_inventario::select('nombre','apellidos','salida_inventarios.*')
      ->Join('pacientes','pacientes.id','=','salida_inventarios.paciente_id')
      ->where('medicamento_id',$inventario->id)
      ->orderBY('created_at', 'DESC')
      ->paginate(5,['*'],'salidas');
      
      

      $medicamento = inventario::where('id',$inventario->id)->first();   
      $id = $medicamento->id;
    
     /*  $salidas = salida_inventario::where('medicamento_id',$inventario->id)->get(); */
      return view('inventario.showmedicamento',compact('entradas','medicamento','salidas','id'));  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, inventario $inventario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function destroy(inventario $inventario)
    {
        //
    }
    public function listatable()
    {
        
                return datatables()
                ->eloquent(inventario::where('doctor_id',Auth::user()->doctor_id)->orderBy('created_at','DESC'))                            
                ->addColumn('btn', 'Inventario.buttonslista')  
                ->rawColumns(['btn'])  
                ->addColumn('fecha_exp', function($row){
                  return \Carbon\Carbon::parse($row->fecha_exp)->format('d/m/Y');
              })            
                ->toJson();
           
    }
    public function ventamenu()
    {
       $pacientes = Paciente::where('doctor_id',Auth::user()->doctor_id)->get();
       $medicamentos = inventario::where('doctor_id',Auth::user()->doctor_id)->orderBy('nombre','ASC')->get(); 
       
       $number = 1;    
      return view('Inventario.ventamenu', compact('pacientes','medicamentos','number'));

    }
    public function addventajax(Request $request){   
      /* return $request; */
        $suma = 0;
        $doctor = Doctor::where('id',Auth::user()->doctor_id)->first();           
        $clinica = Clinica_doctor::where('doctor_id',Auth::user()->doctor_id)->first(); 
        $clinicaenvio = Clinica::where('id',$clinica->clinica_id)->first();  
      foreach($request->b as $nombre){
        $division = explode('!',$nombre);       

        $maybe = inventario::where('id',$division[0])->first();
        $precio = $maybe->precio;
        $multi = $precio * $division[1];        
        $suma = $suma + $multi;
        
        $stock = $maybe->stock;
        $newstock = $stock-$division[1];
       
        $maybe->update([
          'stock' => $newstock,         
      ]);
       /*  return $maybe; */
       
        if(is_numeric($request->paciente_id)){
          $paciente_id = $request->paciente_id;
          $cliente = null;
        }
        else{
          $paciente_id = null;           
          $cliente = $request->paciente_id;
        }      
      }
        $varventa =  venta::create([
              'paciente_id' => $paciente_id,
              'total_venta' => $suma,
              'clinica_id' => $clinica->clinica_id,
              'cliente' => $cliente   
          ]);
         
          
          foreach($request->b as $nombre){
            $division = explode('!',$nombre);       
    
            $maybe = inventario::where('id',$division[0])->first();
            $medic_id = $maybe->id;
            $cantidad = $division[1];  
            $id_venta = $varventa->id;            
                    
            
            $salida = salida_inventario::create([
                'medicamento_id' => $medic_id,
                'cantidad' => $cantidad,
                'paciente_id' => $paciente_id,
                'venta_id' => $varventa->id
            ]);
          }
     $medicamentos = Inventario::Join('salida_inventarios','inventarios.id','salida_inventarios.medicamento_id')
     ->select('salida_inventarios.cantidad','inventarios.*')
     ->where('salida_inventarios.venta_id',$varventa->id)->get();

    if($paciente_id != null){
      $paciente = Paciente::where('id',$request->paciente_id)->first();     
    }  
    else{
      $paciente = $cliente;     
    }      

     $totalventa = $varventa->total_venta;
     
   /*   $fecha = $varventa->created_at;
     $fecha->format('yy');
     return $fecha;     
     */
    if($request->nber == 2){
      $pdf = PDF::loadView('Inventario.reciboVenta', [
        'medicamentos' =>$medicamentos,
        'paciente' => $paciente,
        'total' => $totalventa,
        'doc' => $doctor,
        'clinica' => $clinicaenvio
        ])->setPaper('a4','portrait');
        $nombre = 'VENTA DE MEDICAMENTOS';
        return $pdf->stream($nombre.'.pdf');
    }else{
      return redirect()->route('pacientes.show', $paciente->id);
    }

    }
    function ventapaciente($id){
      $paciente = Paciente::find($id);
      $medicamentos = Inventario::where('doctor_id',Auth::user()->doctor_id)->orderBy('nombre','ASC')->get();
      $number = 2;
      return view ('inventario.ventamenu',compact('paciente','medicamentos','number'));
    }
    
    function verventapaciente($id){
       
      $venta = venta::find($id);
      
      $medicamentos = Inventario::Join('salida_inventarios','inventarios.id','salida_inventarios.medicamento_id')
      ->select('salida_inventarios.cantidad','inventarios.*')
      ->where('salida_inventarios.venta_id',$venta->id)->get();
      
     

      $paciente = Paciente::where('id',$venta->paciente_id)->first();
  
      $totalventa = $venta->total_venta;
      

      $doctor = Doctor::where('id',Auth::user()->doctor_id)->first();  
      
      $clinica = Clinica_doctor::where('doctor_id',Auth::user()->doctor_id)->first(); 
      $clinicaenvio = Clinica::where('id',$clinica->clinica_id)->first();  

      $pdf = PDF::loadView('Inventario.reciboVenta', [
      'medicamentos' =>$medicamentos,
      'paciente' => $paciente,
      'total' => $totalventa,
      'doc' => $doctor,
      'clinica' => $clinicaenvio
      ])->setPaper('a4','portrait');
      $nombre = 'VENTA DE MEDICAMENTOS';
      return $pdf->stream($nombre.'.pdf');
    }

    function listaventas(Request $request){
        $ventas = venta::
        select('ventas.*')
        ->where('ventas.paciente_id',$request->idlista)->orderBy('ventas.created_at','DESC')
        ->get();     
        
        $medicamentos = venta::Join('salida_inventarios','ventas.id','salida_inventarios.venta_id')
        ->join('inventarios','salida_inventarios.medicamento_id','inventarios.id')
        ->select('salida_inventarios.*','ventas.id','inventarios.nombre','inventarios.Consentracion')       
        ->get();
       
        /* $contador = 0;
        foreach ($medicamentos as $medicamento){
            $contador = $contador + $medicamento->cantidad;
        } */
        /* return $ventas; */
        $totales = DB::table('salida_inventarios')
                ->select('salida_inventarios.venta_id', DB::raw('SUM(salida_inventarios.cantidad) as total'))
                ->groupBy('venta_id')
                ->get();
       /*  return $totales;    */   
       /* $datos = salida_inventario::select('sum(salida_inventarios.cantidad)')->get()->groupBy('venta_id'); */
       
     
     
        $paciente = Paciente::find($request->idlista);
        return view('Inventario.listaventas',compact('ventas','paciente','totales','medicamentos'));
    }

    function cuantoshay(Request $request){
        $medicamento = Inventario::find($request->idd);
        $stock = $medicamento->stock;
        return response()->json([
            'stock' => $stock,
        ]);
    }
}