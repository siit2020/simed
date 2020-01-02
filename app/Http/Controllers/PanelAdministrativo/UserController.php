<?php

namespace App\Http\Controllers\PanelAdministrativo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Doctor;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at','DESC')->paginate(15);
        return view('panel.index', compact('users'));
    }
    public function cambiarusuario()
    {
        $users = User::join('doctors','users.id','doctors.user_id')
            ->select('doctors.nombreDoctor','doctors.apellidosDoctor','users.id','users.username','users.created_at')
            ->orderBy('doctors.apellidosDoctor','ASC')
            ->get();
        return view('panel.Usuarios.changeuser', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.Usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::where('username',$request->username)->exists();
        $useremail = User::where('email',$request->email)->exists();
        if($user == true)
        {
            return back()->with('info',  'El nombre de usuario ya existe');
        }else if($useremail == true)
        {
            return back()->with('info',  'El correo ya existe');
        }
        else{
            $users=User::create([
                'name' => $request->name,
                'username' => $request->username,
                'doctor_id' => $request->doctor_id,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('users.edit', $users->id);
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
        $user = User::find($id);
        return view('panel.Usuarios.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::get();
        $role_user=User::leftJoin('role_user', 'users.id', '=', 'role_user.user_id')->where('users.id', $id)->
        select('role_user.role_id')->get();

        $permisos = Permission::get();
        $permisos_user=$user->leftJoin('permission_user', 'users.id', 'permission_user.user_id')->get();
        //$permisos_user = $user->permissions()->get();

        $doctor = Doctor::where('user_id',$user->id)->exists();

        return view('panel.Usuarios.edit', compact('user', 'roles', 'role_user', 'permisos', 'permisos_user','doctor'));
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
       
        /*$user = User::find($id);
        $user->update([
            'password' =>  bcrypt($request->password), 
        ]);
        return back();*/
       /* $user = User::find($id);
        $username = User::where('username', $request->username)->exists();

        if($username == false)
        {
            $user->update($request->all());
            return back()->with('info', 'usuario actualizado correctamente!');
        }else{
            if($user->username == $request->username)
            {
                $user->update($request->all());
                return back()->with('info', 'usuario actualizado correctamente!');
            }else{
                return back()->with('info', '¡¡El nombre de usuario ya existe!!');
            }
        } */


        //return redirect()->route('panel.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
    }
    
     public function table()
    {        
        if( Auth::user()->hasPermission('change_users'))
            {                
                return datatables()
                ->eloquent(User::select('users.name','username','users.created_at','email','roles.display_name','users.id')
                    ->join('roles','roles.id','users.role_id')
                    ->orderBy('created_at','ASC'))
                    ->addColumn('btn', 'panel.Usuarios.btns')
                    ->rawColumns(['btn'])
                    ->addColumn('created_at', function($row){
                        return \Carbon\Carbon::parse($row->created_at)->format('Y-m-d');
                    })                           
                    ->toJson();                
            } 
        /* if( Auth::user()->hasPermission('change_users'))
            {                
                return datatables()
                ->eloquent(User::select('users.name','username','users.created_at','email','slug','users.id')
                    ->join('role_user','role_user.user_id','=','users.id')->join('roles','roles.id','=','role_user.role_id')
                    ->orderBy('created_at','DESC'))
                    ->addColumn('btn', 'panel.Usuarios.btns')
                    ->rawColumns(['btn'])
                    ->addColumn('created_at', function($row){
                        return \Carbon\Carbon::parse($row->created_at)->format('Y-m-d');
                    })                           
                    ->toJson();                
            }    */  
    }
    
    public function changeUser($id){
        $doctor = Doctor::where('user_id',$id)->first();
        Auth::user()->update([
            'doctor_id' => $doctor->id,
        ]);

        return redirect()->route('pacientes.index')->with('info', 'iniciastes sesion con el usuario '.$doctor->nombreDoctor);
    }
     public function imagenes(){
        $doctor = Doctor::find(Auth::user()->doctor_id);
        $url = asset('/adjuntosdoctor/'.$doctor->id.'-'.$doctor->apellidosDoctor.'/'.$doctor->perfil);
        if($doctor->perfil != null){
            return $url;
        }else{
            return asset('assets/img/avatarMedico.jpg');
        }
    }
}
