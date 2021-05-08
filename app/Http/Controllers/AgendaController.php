<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function insert(Request $request)
    {
        $var = AgendaController::detectFiles();
        $agenda = new Agenda();
        $agenda->first_name = $request->first_name;
        $agenda->last_name = $request->last_name;
        $agenda->number = $request->number;
        $agenda->id_user = Auth::id();
        $agenda->save();

        for ($i = 0; $i < sizeof($var['url']); $i++) {
            $photo = new Photo();
            $photo->url_photo = $var['url'][$i];
            $photo->name_photo = $var['name'][$i];
            $photo->id_agenda = $agenda->id;
            $photo->save();
        }
        return redirect()->route('home');
    }

    public function delete($id)
    {
        $person = Agenda::find($id);
        $person->delete();
        $photos = Photo::all()->where('id_agenda', $id);
        foreach ($photos as $photo => $value) {
            cloudinary()->destroy($value->name_photo);
        }
        Photo::where('id_agenda', $id)->delete();
        return redirect()->route('home');
    }

    public function update($id, Request $request)
    {

        $agenda = Agenda::find($id);
        $agenda->first_name = $request->first_name;
        $agenda->last_name = $request->last_name;
        $agenda->number = $request->number;
        $agenda->save();

        for ($i = 0; $i > -1; $i++) {
            if (isset($_POST['imagen' . $i])) {
                Photo::where('name_photo', $_POST['imagen' . $i])->delete();
                cloudinary()->destroy($_POST['imagen' . $i]);
            } elseif ($i > 10) {
                break;
            }
        }

        $vars = AgendaController::detectFiles();

        for ($i = 0; $i < sizeof($vars['url']); $i++) {
            $photos = new Photo();
            $photos->url_photo = $vars['url'][$i];
            $photos->name_photo = $vars['name'][$i];
            $photos->id_agenda = $id;
            $photos->save();
        }

        return redirect()->route('home');
    }

    public function findById($id)
    {
        $persona = Agenda::find($id);
        $photo = Photo::all()->where('id_agenda', $persona->id);
        return view('update')->with(['person' => $persona, 'imagenes' => $photo]);
    }

    public function viewInsert()
    {
        return view('update');
    }

    public static function detectFiles()
    {
        $c = 0;
        $uploadedFileUrl = [];
        $uploadedFileName = [];
        foreach ($_FILES["imgs"]["tmp_name"] as $key => $tmp_name) {
            if ($_FILES["imgs"]["name"][$key]) {
                $source = $_FILES["imgs"]["tmp_name"][$key];
                $result = cloudinary()->upload($source);
                $uploadedFileUrl[$c] = $result->getSecurePath();
                $uploadedFileName[$c] = $result->getFileName();
                $c++;
            }
        }
        return (["url" => $uploadedFileUrl, "name" => $uploadedFileName]);
    }
}
