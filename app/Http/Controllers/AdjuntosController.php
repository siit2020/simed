<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\AdjuntoPaciente;
use PDF;
use Auth;
use App\Doctor;
use App\Paciente;
use App\Asistente;
use Image;

class AdjuntosController extends Controller
{
    public function notasupdate(Request $request){
        $paciente = Paciente::find($request->id);
        $paciente->update($request->all());
        return back();
    }
    
    public function adjuntarPaciente(Request $request)
    {
        if ($request->file('file'))
        {
            $paciente=$request->paciente_id;
            $carpeta=public_path().'/adjuntospaciente/'.'paciente'.$paciente.'/';
            $file=$request->file('file');
            
            $name=time().'.'.$file->getClientOriginalExtension();
            $extension = $file->getClientOriginalExtension();
            $file->move($carpeta, $name);
            $adjuntoPaciente = AdjuntoPaciente::create([
            'paciente_id' => $request->paciente_id,
            'adjunto' => $name,
            'descripcion' => $request->descripcion,
            ]);

            return response()->json([
                'resultado' => '1',
                'paciente' => $request->paciente_id,
            ]);
        }
        else{
            return response()->json([
                'resultado' => 'algo salio mal',
            ]);
        }
        
        //return $name;
        

    }
//metodo para obtener ruta archivos adjuntos del paciente
    public function obtenerRuta($paciente, $solicitud, $archivo)
    {
        $pacientes   = Paciente::find($paciente);
        $adjunto     = AdjuntoPaciente::where('adjunto',$archivo)->first();
        $url         = public_path().'/adjuntospaciente/'.'paciente'.$paciente.'/'.$archivo;

        if($solicitud=='download')
        {
            if (file_exists($url)) {
                return response()->download($url);
            }else{
                abort(404);
            }
        }elseif($solicitud=='print')
        {
            if (file_exists($url)) {
                list($name,$extension)=explode('.',$archivo);

                if (strtolower($extension)=='jpg' or strtolower($extension)=='png' or strtolower($extension)=='jpeg') {
                    $pdf= PDF::loadView('pacientes.Consultas.mostrarArchivo', [
                        'url' => $url,
                        'paciente' => $pacientes,
                        'adjunto' => $adjunto,
                    ])->setPaper('letter', 'portrait');
                    $fileName=$pacientes->apellidos;
                    return $pdf->stream($fileName.'.pdf');

                }
                else{
                    return response()->file($url);
                }
            }else{
                abort(404);
            }
        }elseif($solicitud=='delete')
        {
            if(file_exists($url))
            {

                unlink($url);
                $adjunto->delete();
                return back()->with('info', 'El archivo ha sido eliminado correctamente!');
            }else{
                abort(404);
            }
        }elseif($solicitud=='watch')
        {
            if(file_exists($url))
            {
                return response()->file($url);
            }else{
                abort(404);
            }
        }
    }

    public function verFotoPerfil($id){
        $paciente=Paciente::find($id);
        $url = public_path().'/adjuntospaciente/'.'paciente'.$paciente->id.'/'.$paciente->photo_extension;
        if(file_exists($url))
            {
                return response()->file($url);
            }else{
                abort(404);
            }
    }

    public function mensajes($user)
    {  
        return redirect()->route('pacientes.show', $user)->with('info', 'El adjunto se subio correctamente');
    }

    public function cambioPerfil($user)
    {
        return redirect()->route('pacientes.show', $user)->with('info', 'ok');
    }
}
