<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cita;
use App\Dotor;
use App\Paciente;
use Auth;
use \Carbon\Carbon;
use App\Doctor;

class CitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pacientes = Paciente::select('id','nombre','apellidos')->where('doctor_id', Auth::user()->doctor_id)->orderBy('created_at','DESC')->paginate(25);
        return view('citas', compact('pacientes'));
    }

    public function calendarshow()
    {
         $citas=Cita::where('doctor_id', '=', Auth::user()->doctor_id)->get();

        return $citas;
    }   

    public function calendarinsert(Request $request)
    {
        $fechaIni = explode('/', $request->datestart);
        $fechainicio = $fechaIni[2].'-'.$fechaIni[1].'-'.$fechaIni[0].' '.$request->timestart.':00';
        $fechaFin = explode('/', $request->dateend);
        $fechaFinal = $fechaFin[2].'-'.$fechaFin[1].'-'.$fechaFin[0].' '.$request->timeend.':00';

        Cita::create([
            'start'=>$fechainicio,
            'end'=>$fechaFinal,
            'title' => $request->title,
            'tipocita' => $request->tipocita,
            'paciente_id'=> $request->paciente_id,
            'doctor_id'=> $request->doctor_id,
            'descripcion'=>$request->detallevento
           
        ]);
       return back()->with('info', 'La cita se creo con éxito');
    }

    public function calendarupdate(Request $request)
    {
        $fechaIni = explode('/', $request->datestart);
        $fechainicio = $fechaIni[2].'-'.$fechaIni[1].'-'.$fechaIni[0].' '.$request->timestart;
        $fechaFin = explode('/', $request->dateend);
        $fechaFinal = $fechaFin[2].'-'.$fechaFin[1].'-'.$fechaFin[0].' '.$request->timeend;

        $id=$request->id;
        $calendar = Cita::find($id);
        $calendar->update([
            'start' =>  $fechainicio,
            'end' => $fechaFinal,
            'title'=>$request->titles,
            'tipocita' => $request->tipocita,
            'doctor_id'=> $request->doctor_id,
            'descripcion'=>$request->detalleventos,
            'paciente_id' => $request->paciente_id,
        ]);

         return back()->with('info', 'La cita se edito con éxito');
    }

    public function calendarupdateajax(Request $request)
    {
     
        //
        $id=$request->id;
        $calendar = Cita::find($id);
        $calendar->update([
            'start' => $request->start,
            'end' => $request->end,
           
        ]);
      return back();
    }

    public function calendardelete(Request $request)
    {
        $id=$request->id;
        $calendar = Cita::find($id);
        $calendar->delete();
        
        return back()->with('info', 'La cita se eliminó con éxito');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* Cita::create([
            'horaCita'=>$request->horaCita,
            'paciente_id'=>$request->citaId,
            'tipoExamen_id'=>$request->tipoExamen_id,
            'doctor_id'=>$request->doctor_id,

        ]);//envio la respuesta

            return redirect('/pacientes'); */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
       $cita=Cita::find($request->id);

        
        $explorar = explode(' ', $cita->start);
        $explorarDos = explode(' ', $cita->end);

        if($cita->paciente_id != null)
        {
            $paciente =  Paciente::find($cita->paciente_id);
            return response()->json([
                'title'=> $cita->title,
                'descripcion'=>$cita->descripcion,
                'tipocita' => $cita->tipocita,
                'datestart'=> $explorar[0],
                'dateend'=> $explorarDos[0],
                'timestart' => $explorar[1],
                'timeend' => $explorarDos[1],
                'idpaciente' => $paciente->id,
                'nombre' => $paciente->nombre.' '.$paciente->apellidos,
            ]);
        }else{
            return response()->json([
                'title'=> $cita->title,
                'descripcion'=>$cita->descripcion,
                'tipocita' => $cita->tipocita,
                'datestart'=> $explorar[0],
                'dateend'=> $explorarDos[0],
                'timestart' => $explorar[1],
                'timeend' => $explorarDos[1],
                'idpaciente' => '',
                'nombre' => '',
            ]);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     public function citaPaciente($tipo, $id)
    {
        $pacientes = Paciente::select('id','nombre','apellidos')->where('doctor_id', Auth::user()->doctor_id)->orderBy('created_at','DESC')->paginate(25);
        $paciente = Paciente::find($id);
        return view('citas', compact('tipo', 'id','pacientes','paciente'));
    }
    
     public function citasnotifications(){
        $now = Carbon::now();
        $morenow = Carbon::now()->addDay(3);
        $notfications = Cita::select('citas.id','citas.title','citas.start','pacientes.nombre','pacientes.apellidos','citas.estado')
            ->leftJoin('pacientes','citas.paciente_id','pacientes.id')
            ->whereDate('start','>=',$now)
            ->where('estado','false')
            ->where('citas.doctor_id',Auth::user()->doctor_id)
            ->whereDate('start','<=',$morenow)->orderBy('start','ASC')->get();
        return response()->json($notfications);
    }

    public function marcarvisto(Request $request, $id){
        $cita = Cita::find($request->codigo);
        $cita->update([
            'estado' => 'true',
        ]);

        return back();
    }


}
