<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\User;

class PatientController extends Controller
{
    // todas las rutas que resuelva este controlador va exigir al usuario haber iniciado Session

    public function __construct(){

        $this->middleware('auth');
    }
    function index(){
       //$specialities=Speciality::all();
       $patients=User::patients()->orderBy('id','DESC')->paginate(10);
       return view('patients.index',compact('patients'));
    }
    function create(){
        return view('patients.create');
    }
    function store(Request $request){
        // el validate usa 2 parametros el request a validar y las reglas que se van a usar
      //  $this->performValidation($request);
        $rules= [
        'name' => 'required|min:3',
        ];
         $messages=[
        'name.required' => 'Es necesario ingresar un nombre',
        'name.min' => 'Es necesario ingresar un nombre',
         ];
        User::create(
            $request->only( 'name' , 'email', 'dni', 'address' , 'phone') + 
            [
                'role' => 'patient',
                'password' => bcrypt($request->password)
            ]
        );
      //  dd($request->all());
        $notification = 'El paciente ha sido registrado exitosamente!';
        return \redirect()->route('patients.index')->with(compact('notification'));
    }
    function edit(User $patient){
        return view('patients.edit',compact('patient'));
    }
    private function performValidation(Request $request){
          
        $rules= [
            'name' => 'required|min:3',
        ];
        $messages=[
            'name.required' => 'Es necesario ingresar un nombre',  
            'name.min' => 'Es necesario ingresar un nombre',
        ];
        // EL TERCER PARAMETRO DE LOS MENSAJES ES OPCIONAL
        $this->validate($request,$rules,$messages);
    }
    function update(Request $request,User $patient){
        $this->performValidation($request); //validation rules
        /* if($request->password){
            $patient->password= bcrypt($request->password);
            }
         
            $patient->name=$request->name;
            $patient->email=$request->email;
            $patient->dni=$request->dni;
            $patient->address=$request->address; 
            $patient->phone=$request->phone;
            $patient->update();
        */
        $data=  $request->only('name','email','dni','address','phone');
        $password= $request->password;
        if($password) $data['password'] = bcrypt($password);
        $patient->fill($data);
        $patient->save(); // para guardar los cambios despues de haber usado el "fill" 
        $notification = 'Los datos del pacient han sido actualizados';
        return \redirect()->route('patients.index')->with(compact('notification'));
    }
    function destroy(User $patient){
       
        $notification = 'La paciente '.$patient->name .' ha sido eliminado';
        $patient->delete();
        return \redirect()->route('patients.index')->with(compact('notification'));
    }
    
}
