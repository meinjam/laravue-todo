<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TodoController extends Controller {

    public function index() {
        return Todo::latest()->get();
    }

    public function store( Request $request ) {
        $this->validate( $request, [
            'todo' => 'required|unique:todos',
        ], [
            'todo.required' => 'Please type some todo name and then add.',
        ] );

        return Todo::create( [
            'todo' => $request->todo,
            'slug' => Str::slug( $request->todo ),
        ] );
    }

    public function show( $id ) {
        //
    }

    public function edit( $id ) {
        //
    }

    public function update( Request $request, $id ) {
        //
    }

    public function destroy( Request $request ) {
        $this->validate( $request, [
            'id' => 'required',
        ] );
        return Todo::where( 'id', $request->id )->delete();
    }
}
