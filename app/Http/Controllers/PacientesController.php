<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Carbon\Carbon;
use App\AdjuntoPaciente;
use App\HistorialClinico;
use App\Paciente;
use App\Reporte;
use App\Anexos;
use Auth;
use App\Doctor_asistente;
use App\User;
use PDF;
use App\Mix;
use App\Examen;
use App\Consulta;
use Image;
use App\Receta;
use App\Historico;
use App\Doctor;
use App\Procedimiento;
use App\Http\Requests\CreatePacienteRequest;
use App\Notifications\invoicePaid;
use Notification;

class PacientesController extends Controller
{
    public $codigo;
    /* public function __construct()
    {
        $this->middleware('can:pacientes.index')->only('index');
        $this->middleware('can:pacientes.create')->only(['create','store']);
        $this->middleware('can:pacientes.edit')->only(['edit','update']);
        $this->middleware('can:pacientes.show')->only('show');
        $this->middleware('can:pacientes.destroy')->only('destroy');
    } */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posee = Doctor::find(Auth::user()->doctor_id);
       $pacientes = Paciente::where('doctor_id',Auth::user()->doctor_id)->orderBy('created_at','DESC');
        return view('pacientes/lista', compact('posee'));
    }

    public function listadoPacientes()
    {
        if(Auth::user()->hasPermission('list_pacients'))
            {
                return datatables()
                ->eloquent(Paciente::where('doctor_id',Auth::user()->doctor_id)->orderBy('created_at','DESC'))
                ->addColumn('nacimiento', function($row){
                    return "{$row->age}";
                })
                ->addColumn('created_at', function($row){
                    return \Carbon\Carbon::parse($row->created_at)->format('d/m/Y - h:i a');
                })
                ->addColumn('btn', 'pacientes.actions')
                ->addColumn('grab', 'pacientes.grab')
                ->rawColumns(['btn','grab'])
                ->toJson();
            }
            elseif(Auth::user()->hasPermission('list_pacients_asistent')){
                return datatables()
                ->eloquent(Paciente::where('doctor_id',Auth::user()->doctor_id)->orderBy('created_at','DESC'))
                ->addColumn('nacimiento', function($row){
                    return "{$row->age}";
                })
                ->addColumn('created_at', function($row){
                    return \Carbon\Carbon::parse($row->created_at)->format('d/m/Y - h:i a');
                })
                 ->addColumn('btn', 'pacientes.actionsSecretaria')
                 ->rawColumns(['btn'])
                 ->toJson();
            }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $examen=Examen::orderBy('nombreExamen','ASC')->get();
        return view('pacientes.nuevoPaciente', compact('examen'));
    }

  /*   public function crearCodigo($doctor){
       $anio = \Carbon\Carbon::now()->format('Y');
       $mes = \Carbon\Carbon::now()->format('m');
       $this->codigo = Paciente::select('codigo')
       ->where('doctor_id', $doctor)->orderBy('created_at','DESC')->first();

       
    } */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        if(Auth::user()->hasPermission('store_pacients')){
            if($request->codigo == null)
            {
                $codigo = Paciente::where('codigo',\Carbon\Carbon::now()->format('Y').'/'.\Carbon\Carbon::now()->format('m').'/'.'1')
                            ->where('doctor_id', $request->doctor_id)->exists();
                if($codigo==false)
                {
                    $codigopaciente = \Carbon\Carbon::now()->format('Y').'/'.\Carbon\Carbon::now()->format('m').'/'.'1';

                    $paciente = Paciente::create([
                        'nombre' => $request->nombre,
                        'apellidos' => $request->apellidos,
                        'nacimiento' => $request->nacimiento,
                        'telefono' => $request->telefono,
                        'email' => $request->email,
                        'sexo' => $request->sexo,
                        'civil' => $request->civil,
                        'codigo' => $codigopaciente,
                        'dui' => $request->dui,
                        'doctor_id' => $request->doctor_id,
                        'teltrabajo' => $request->teltrabajo,
                        'celtrabajo' => $request->celtrabajo,
                        'asegurado' => $request->asegurado,
                        'companiaseguro' => $request->companiaseguro,
                        'nopoliza' => $request->nopoliza,
                        'nocarnet' => $request->nocarnet,
                        'direccion' => $request->direccion,
                    ]);

                    if($request->peso != null || $request->presion != null || $request->estatura != null || $request->temperatura != null || $request->glucosa != null){
                        $otrosdatos = Historico::create([
                            'temperatura' => $request->temperatura,
                            'peso' => $request->peso,
                            'presion' => $request->presion,
                            'glucosa' => $request->glucosa,
                            'estatura' => $request->estatura,
                            'paciente_id' => $paciente->id,
                        ]);
                    }

                    return redirect()->route('pacientes.show', $paciente->id);
                }
                else
                {
                    $endpaciente = Paciente::where('doctor_id', $request->doctor_id)->max('created_at');
                    $endpacienteUno = Paciente::where('created_at', $endpaciente)->first();
                    $increment = explode("/", $endpacienteUno->codigo);
                    $id = $increment[2]+0001;
                    $paciente = Paciente::create([
                        'nombre' => $request->nombre,
                        'apellidos' => $request->apellidos,
                        'nacimiento' => $request->nacimiento,
                        'telefono' => $request->telefono,
                        'email' => $request->email,
                        'sexo' => $request->sexo,
                        'civil' => $request->civil,
                        'codigo' => \Carbon\Carbon::now()->format('Y').'/'.\Carbon\Carbon::now()->format('m').'/'.$id,
                        'dui' => $request->dui,
                        'doctor_id' => $request->doctor_id,
                        'teltrabajo' => $request->teltrabajo,
                        'celtrabajo' => $request->celtrabajo,
                        'asegurado' => $request->asegurado,
                        'companiaseguro' => $request->companiaseguro,
                        'nopoliza' => $request->nopoliza,
                        'nocarnet' => $request->nocarnet,
                        'direccion' => $request->direccion,
                    ]);

                    if($request->peso != null || $request->presion != null || $request->estatura != null || $request->temperatura != null || $request->glucosa != null){
                        $otrosdatos = Historico::create([
                            'temperatura' => $request->temperatura,
                            'peso' => $request->peso,
                            'presion' => $request->presion,
                            'glucosa' => $request->glucosa,
                            'estatura' => $request->estatura,
                            'paciente_id' => $paciente->id,
                        ]);
                    }

                    return redirect()->route('pacientes.show', $paciente->id);
                }
            }
            else{
                $paciente=Paciente::create($request->all());
                return redirect()->route('pacientes.show', $paciente->id);
            }
       }else{
           abort(401);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->hasPermission('show_pacient')){
            $doctor=Doctor::find(Auth::user()->doctor_id);
            $paciente=Paciente::find($id);
            if($paciente){
                if ($paciente->doctor_id == $doctor->id) {
                    $historial=HistorialClinico::leftJoin('consultas','historial_clinicos.consulta_id','consultas.id')
                    ->leftJoin('procedimientos','historial_clinicos.procedimiento_id','procedimientos.id')
                    ->leftJoin('recetas','recetas.consulta_id','consultas.id')
                    ->leftJoin('procedimiento_tipos As t', 'procedimientos.procedimiento_tipo_id', 't.id')
                    ->leftJoin('anexos', 'anexos.id','historial_clinicos.anexo_id')
                    ->where('historial_clinicos.paciente_id',$id)
                    ->select('historial_clinicos.*','anexos.diagnostico As diagnosticoanexo','anexos.tipo','consultas.tituloConsulta','consultas.detalleConsulta','consultas.diagnostico','prescripcion', 't.procedimiento_nombre','recetas.id As receta')
                    ->orderBy('historial_clinicos.created_at','DESC')->get();

                    $cantidad=$historial->count();
                    $recetas=Receta::where('paciente_id',$paciente->id)->orderBy('created_at','DESC')->get();
                    $cantidadRecetas=$recetas->count();

                    $adjuntos=AdjuntoPaciente::where('paciente_id',$id)->orderBy('created_at', 'DESC')->get();
                    $cantidadAdjuntos=$adjuntos->count();

                    $historico = Historico::where('paciente_id',$paciente->id)->orderBy('created_at','DESC')->take(1)->first();
                    
                    return view('pacientes.perfilPaciente', compact('paciente','historico','historial','cantidad','cantidadAdjuntos','adjuntos','doctor','recetas','cantidadRecetas'));

                }
                else{
                    return redirect()->route('pacientes.index');
                }
            }else{
                return redirect()->route('pacientes.index');
            }
        }else{
            abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        if(Auth::user()->hasPermission('update_pacient')){
            $paciente = Paciente::find($id);
            $paciente->update($request->all());
            $historico = Historico::where('paciente_id',$id)->orderBy('created_at','DESC')->take(1)->first();

            if($historico !=null){
                if($request->peso != $historico->peso || $request->estatura != $historico->estatura || $request->temperatura != $historico->temperatura || $request->presion != $historico->presion || $request->glucosa != $historico->glucosa ){
                    if($request->peso != null && $historico->peso != null){
                        $valor = abs($request->peso - $historico->peso);
                        if($request->peso > $historico->peso){
                            $mejora = 'ha incrementado '.$valor.' Libras.';
                        }else if($request->peso < $historico->peso){
                            $mejora = 'ha disminuido '.$valor.' Libras.';
                        }else{
                            $mejora = '';
                        }
                        $newhistorico = Historico::create([
                            'peso' => $request->peso,
                            'presion' => $request->presion,
                            'estatura' => $request->estatura,
                            'glucosa' => $request->glucosa,
                            'temperatura' => $request->temperatura,
                            'mejora' => $mejora,
                            'paciente_id' => $paciente->id,
                        ]);
                    }else{
                        $newhistorico = Historico::create([
                            'peso' => $request->peso,
                            'presion' => $request->presion,
                            'estatura' => $request->estatura,
                            'glucosa' => $request->glucosa,
                            'temperatura' => $request->temperatura,
                            'paciente_id' => $paciente->id,
                        ]);
                    }
                    return back()->with('exito', 'Los datos del paciente se actualizaron con éxito');
                }else{
                    return back()->with('exito', 'Los datos del paciente se actualizaron con éxito');
                }
            }else{
                $newhistorico = Historico::create([
                    'peso' => $request->peso,
                    'presion' => $request->presion,
                    'estatura' => $request->estatura,
                    'glucosa' => $request->glucosa,
                    'temperatura' => $request->temperatura,
                    'paciente_id' => $paciente->id,
                ]);
                return back()->with('exito', 'Los datos del paciente se actualizaron con éxito');
            }
        }else{
            abort(401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->hasPermission('delete_pacient'))
        {
            $paciente=Paciente::find($id);
            $historias=HistorialClinico::where('paciente_id',$paciente->id)->get();
            $consultas = array();
            $procedimientos = array();
            foreach ($historias as $key => $historia) {
                $consultas[]=$historia->consulta_id;
                $procedimientos[]=$historia->procedimiento_id;
            }
            
            if(count($historias))
            {
                $eliminados=HistorialClinico::destroy($historias);
            }
            if (count($consultas)>0) {
                $deleteConsulta=Consulta::destroy($consultas);
            }

            $url = public_path('adjuntospaciente/'.'paciente'.$paciente->id);

            if (file_exists($url))
            {
                $files=glob($url.'/*');
                foreach ($files as $key => $file)
                {
                    if(is_file($file))
                    {
                        unlink($file);
                    }
                }
                if(file_exists($url))
                {
                    rmdir($url);
                }
                $paciente->delete();
                return redirect()->route('pacientes.index');
            } else {
                $paciente->delete();

                return redirect()->route('pacientes.index');
            }
        }else{
           abort(401);
        }
    }

    public function historico($id){
        if(Auth::user()->hasPermission('historic_pacient'))
        {
            $doctor=Doctor::find(Auth::user()->doctor_id);
            $paciente=Paciente::find($id);
            if($paciente){
                if ($paciente->doctor_id == $doctor->id) {
                    $historicos = Historico::select('*')->where('paciente_id',$id)->orderBy('created_at','DESC')->get();
                    if(count($historicos)>0){
                        return view('pacientes.historico', compact('paciente','doctor','historicos'));
                    }else{
                        return 'El paciente no tiene registros para el historico de peso y presión.......';
                    }
                }
                else{
                    return redirect()->route('pacientes.index');
                }
            }else{
                return redirect()->route('pacientes.index');
            }
        }
        if(Auth::user()->hasPermission('historic_pacient_asistent'))
        {
            $paciente = Paciente::find($id);
            $id_doctor = Auth::user()->doctor_id;
            if($id_doctor!=null)
            {
                $doctor = Doctor::find($id_doctor);

                if($paciente){
                    $paciente=Paciente::find($id);
                    if ($paciente->doctor_id == $doctor->id) {
                        $historicos = Historico::select('*')->where('paciente_id',$id)->orderBy('created_at','DESC')->get();
                        if(count($historicos)>0){
                            return view('pacientes.historico', compact('paciente','doctor','historicos'));
                        }else{
                            return 'El paciente no tiene registros para el historico de peso y presión.......';
                        }
                    }
                    else{
                        return redirect()->route('pacientes.index');
                    }
                }else{
                    return redirect()->route('pacientes.index');
                }
            }else{
                return redirect()->route('pacientes.index');
            }
        }
    }

    public function addmovil(Request $request){
        if($request->dato == 1){
            return response()->json('ok');
        }
    }

    public function cumpleanieros(){
        $mes = Carbon::now()->month;
        $cumples = Paciente::select('pacientes.nombre','pacientes.apellidos','pacientes.nacimiento','pacientes.id','pacientes.photo_extension')
                ->whereMonth('nacimiento',$mes)->where('doctor_id',Auth::user()->doctor_id)
                ->orderBy('nacimiento','DESC')->get();
        return $cumples;
    }
}
