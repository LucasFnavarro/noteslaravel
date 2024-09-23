<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $id = session('user.id');
        // $user = User::find($id)->toArray();
        $notes = User::find($id)->notes()->get()->toArray();

        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        return view('note_frm');
    }

    public function newNoteSubmit(Request $request)
    {
        // validar a request
        $request->validate(
            [
                'text_title' => 'required|min:3|max:100',
                'text_note' => 'required|min:3|max:3000',
            ],
            [
                'text_title.required' => 'É obrigatório dar um título para a nota',
                'text_title.min' => 'O titulo deve ter pelo menos :min caracteres',
                'text_title.max' => 'O titulo deve ter pelo menos :max caracteres',

                'text_note.required' => 'Por favor, insira um texto para poder salvar sua nota!',
                'text_note.min' => 'O texto da nota deve conter pelo menos :min caracteres',
                'text_note.max' => 'O da nota deve conter pelo menos :max caracteres'
            ]
        );

        // Pegar usuário via ID
        $id = session('user.id');

        // Criar nova nota
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        // redireciona pra home
        return redirect()->route('home');
    }

    public function editNote($id)
    {
        $id = Operations::decryptId($id);

        // Carregar a nota a ser editada.
        $note = Note::find($id);

        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request)
    {
        // validação do formulario
        $request->validate(
            [
                'text_title' => 'required|min:3|max:100',
                'text_note' => 'required|min:3|max:3000',
            ],
            [
                'text_title.required' => 'É obrigatório dar um título para a nota',
                'text_title.min' => 'O titulo deve ter pelo menos :min caracteres',
                'text_title.max' => 'O titulo deve ter pelo menos :max caracteres',

                'text_note.required' => 'Por favor, insira um texto para poder salvar sua nota!',
                'text_note.min' => 'O texto da nota deve conter pelo menos :min caracteres',
                'text_note.max' => 'O da nota deve conter pelo menos :max caracteres'
            ]
        );

        // check if note id exists
        if(!$request->note_id == null)
        {
            return redirect()->route('home');
        }

        // decrypt note_id



        // load note


        // update note

        // redirecionar para home

    }

    public function deleteNote($id)
    {
        $id = Operations::decryptId($id);
        echo "Excluindo a nota de id = $id";
    }
}
