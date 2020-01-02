<?php

namespace App\Http\Controllers\Pacientes;

use App\Paciente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;
use Auth;

class ImagenController extends Controller
{
    
    public function changeProfile(Request $request)
    {
        $paciente = Paciente::find($request->paciente);
        $carpeta = public_path().'/adjuntospaciente/paciente'.$paciente->id;
        if($request->file('photo'))
        {
            $file = $request->file('photo');
            $name = 'avatar.'.$file->getClientOriginalExtension();
            $file->move($carpeta, $name );

            $paciente->update([
                'photo_extension' => $name
            ]);

            return '200';
        }
    }
    

}
