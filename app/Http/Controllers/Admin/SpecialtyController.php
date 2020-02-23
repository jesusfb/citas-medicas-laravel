<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Specialty;

class SpecialtyController extends Controller
{
    // todas las rutas que resuelva este controlador va exigir al usuario haber iniciado Session

    public function __construct(){

        $this->middleware('auth');
    }
    function index(){
       //$specialities=Speciality::all();
       $specialties=Specialty::all();
       return view('specialties.index',compact('specialties'));
    }
    function create(){
        return view('specialties.create');
    }
    function store(Request $request){
        // el validate usa 2 parametros el request a validar y las reglas que se van a usar
        $this->performValidation($request);
        $specialty= new Specialty();
        $specialty->name=$request->name;
        $specialty->description=$request->description;
        $specialty->save();
      //  dd($request->all());
        $notification = 'La especialidad ha sido registrada Exitosamente!';
        return \redirect()->route('specialties.index')->with(compact('notification'));
    }
    function edit(Specialty $specialty){
        return view('specialties.edit',compact('specialty'));
    }
    private function performValidation(Request $request){
          
        $rules= [
            'name' => 'required|min:3',
        ];
        $messages=[
            'name.required' => 'Es necesario ingresar una especialidad',
            'name.min' => 'Es necesario ingresar un nombre',
        ];
        // EL TERCER PARAMETRO DE LOS MENSAJES ES OPCIONAL
        $this->validate($request,$rules,$messages);
    }
    function update(Request $request,Specialty $specialty){
        $this->performValidation($request);
        $specialty->name=$request->name;
        $specialty->description=$request->description;
        $specialty->update();
        $notification = 'La especialidad ha sido actualizada';
        return \redirect()->route('specialties.index')->with(compact('notification'));
    }
    function destroy(Specialty $specialty){
       
        $notification = 'La especialida '.$specialty->name .' ha sido eliminada';
        $specialty->delete();
        return \redirect()->route('specialties.index')->with(compact('notification'));
    }
    
}
