<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Specialty;

class DoctorController extends Controller
{
    // todas las rutas que resuelva este controlador va exigir al usuario haber iniciado Session

    public function __construct(){

        $this->middleware('auth');
    }
    function index(){
       //$specialities=Speciality::all();
       $doctors=User::doctors()->paginate(10);
       return view('doctors.index',compact('doctors'));
    }
    function create(){
        $specialties=Specialty::all();
        return view('doctors.create', compact('specialties'));
    }
    function store(Request $request){
        // el validate usa 2 parametros el request a validar y las reglas que se van a usar
        $this->performValidation($request);
       // dd($request->all());
        User::Create(
          // mass assigment = ASIGNACION MASIVA
            //$request->all()
            $request->only('name','email','dni','address','phone') +
            [
                'role' => 'doctor',
                'password'=> bcrypt($request->input('password')),
            ]
            //especificamos al request que ccampo queremos 
            //esto evita que el usuario desde el cliente inserte un input con el role admin por ejemplo
        );
      //  dd($request->all());
        $notification = 'La especialidad ha sido registrada Exitosamente!';
        return \redirect()->route('doctors.index')->with(compact('notification'));
    }
    function edit(User $doctor){
        return view('doctors.edit',compact('doctor'));
    }
    private function performValidation(Request $request){
          
        $rules= [
            'name' => 'required|min:3',
            'email' => 'required|email', // laravel ya verifica el email con la regla email
            // para ver las reglas mriar la documentacion "available ryles"
            'dni' =>    'nullable|digits:8',
            'address' =>   'nullable|min:8',
            'phone' =>    'nullable|min:6', // MINIMO 6 CHARS
        ];
        $messages=[
            'name.required' => 'Es necesario ingresar un nombre',
            'name.min' => 'Es necesario ingresar un nombre',
            'dni.min' => 'Su DNI debe tener 8 digitos',
            'address.min' => 'Su Direccion debe contener al menos 8 caracteres',
        ];
        // EL TERCER PARAMETRO DE LOS MENSAJES ES OPCIONAL
        $this->validate($request,$rules,$messages);
    }
    function update(Request $request,User $doctor){
        $this->performValidation($request);
        $data=  $request->only('name','email','dni','address','phone');
        $password= $request->password;
        if($password) $data['password'] = bcrypt($password);
        $doctor->fill($data);
        $doctor->save(); // para guardar los cambios despues de haber usado el "fill" 
        $notification = 'Los Datos del Médico ha sido actualizado';
        return \redirect()->route('doctors.index')->with(compact('notification'));
    }
    function destroy(User $doctor){
       
        $notification = 'La especialida '.$doctor->name .' ha sido eliminada';
        $doctor->delete();
        return \redirect()->route('doctors.index')->with(compact('notification'));
    }
    
}
