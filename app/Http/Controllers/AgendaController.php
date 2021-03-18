<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;

class AgendaController extends Controller
{
    public function insert(Request $request){
        $agenda = new Agenda();
        $agenda->first_name = $request->first_name;
        $agenda->last_name = $request->last_name;
        $agenda->number = $request->number;
        $agenda->save();
        return redirect()->route('home');
    }

    public function delete($id){
        $person = Agenda::find($id);
        $person->delete();
        return redirect()->route('home');
    }

    public function update($id,Request $request){
        $person = Agenda::find($id);
        $person->first_name = $request->first_name;
        $person->last_name = $request->last_name;
        $person->number = $request->number;
        $person->save();
        return redirect()->route('home');
    }

    public function findById($id){
        $persona = Agenda::find($id);
        return view('update')->with(['person' => $persona]);
    }

    public function viewInsert(){
        return view('update');
    }
}
