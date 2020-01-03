<?php

namespace App\Http\Controllers\Pacientes;

use App\Paciente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;
use Auth;
use App\User;

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

    public function avatar(Request $request, $id){
        $path = $request->file('avatar')->store('users');

        $fileName = collect(explode('/', $path))->last();

        $image = Image::make(Storage::get($path));

        $image->resize(1280, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
          });

        Storage::put($path, (string) $image->encode('jpg', 50));

        $user = User::find($id);
        $user->update([
            'avatar' => 'users/'.$fileName,
        ]);

        return back();
        
        /* $file = $request->file('avatar');
        $name = 'avatar'.$file->getClientOriginalName();
        Storage::disk('pruebas')->put($name, \File::get($file)); */





       /*  $variale = Storage::disk('pruebas')->getDriver()->getAdapter()->getPathPrefix() ;
        return $variale;
        $file = $request->file('avatar');
        $name = $file->getClientOriginalName();
        Storage::disk('pruebas')->put($name, \File::get($file)); */

        

        /* $path = $request->file('avatar')->save('public/img');
        
        $filename = collect(explode('/',$path))->last();
        $image = Image::make(Storage::get($path));
        $image->resize(1280, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
          });

        Storage::put($path, (string) $image->encode('jpg', 30)); */
    }
    

}
