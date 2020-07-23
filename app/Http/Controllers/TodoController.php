<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

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
            'todo'      => $request->todo,
            'completed' => 0,
        ] );
    }

    public function update( Request $request ) {
        $this->validate( $request, [
            'todo' => 'required',
        ] );

        return Todo::where( 'id', $request->id )->update( [
            'todo' => $request->todo,
        ] );
    }

    public function destroy( Request $request ) {
        $this->validate( $request, [
            'id' => 'required',
        ] );
        return Todo::where( 'id', $request->id )->delete();
    }

    public function markcomplete( Request $request ) {
        $this->validate( $request, [
            'id' => 'required',
        ] );

        return Todo::where( 'id', $request->id )->update( [
            'completed' => 1,
        ] );
    }

    public function markincomplete( Request $request ) {
        $this->validate( $request, [
            'id' => 'required',
        ] );

        return Todo::where( 'id', $request->id )->update( [
            'completed' => 0,
        ] );
    }
}
