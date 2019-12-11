<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $clientes = Cliente::all();
    //var_dump($clientes);
      return view('cliente.index')
      ->with([
          "clientes" => $clientes
      ]);
    }
    public function getAll()
    {
      $clientes = Cliente::all();
    //var_dump($clientes);
    //   return response()->json("teste");
      return response()->json($clientes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        return view('cliente.form')
        ->with([
            "title" => "Novo Cliente"
        ]);
       
    }
    public function create(Request $request)
    {
       // dd($request);
       $request->validate([
           'nome' => 'required',
           'endereco' => 'required',
           'telefone' => 'required',
           'cpf' => 'required',
       ]);

       $cliente = Cliente::Create([
           'nome' =>    $request->nome,
           'cpf' =>    $request->cpf,
           'endereco' =>    $request->endereco,
           'telefone' =>    $request->telefone,
       ]);
       $clientes = Cliente::all();
        if($cliente){
            //dd($cliente);
            return response()->json([
                "errors"    => false,
                "message" => "* Cliente cadastrado com sucesso",
                "clientes"  =>  $clientes
            ]);
        }else{
            return response()->json([
                "errors"    => true,
                "message" => "* Erro ao cadastrar cliente",
                "clientes"  =>  $clientes
            ]);
        }
      
     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $cliente = Cliente::where('id',$id)->get();
       return response()->json($cliente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //return response()->json($request);
        $request->validate([
            'id' => 'required',
            'nome' => 'required',
            'endereco' => 'required',
            'telefone' => 'required',
            'cpf' => 'required',
        ]);
        $cliente = Cliente::where('id',$request->id)->first();
       // return response()->json($cliente);
        $cliente->update([
            'nome' =>    $request->nome,
            'cpf' =>    $request->cpf,
            'endereco' =>    $request->endereco,
            'telefone' =>    $request->telefone,
        ]);
        if($cliente){
            //dd($cliente);
            return response()->json([
                "errors"    => false,
                "message" => "* Cliente cadastrado com sucesso",
            ]);
        }else{
            return response()->json([
                "errors"    => true,
                "message" => "* Erro ao cadastrar cliente",
            ]);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::where('id',$id)->first();
        $cliente->delete();
        return response()->json([
            "errors"    => true,
            "message" => "* Cliente excluido com sucesso",
        ]);
    }
}