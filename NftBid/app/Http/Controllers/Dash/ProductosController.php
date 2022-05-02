<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Nft;
use Hash;
use PDF;

class ProductosController extends Controller
{
    public function __construct()
    {
        $this->middlewere('auth');
    }
    public function miFuncion(){
        $categorias = \DB::table('categories')->get();
        $productos = \DB::table('Nfts')->orderBy('id','DESC')->get();
        //dd($categorias);
        return view('dash.productos')
            ->with('Nfts',$productos)
            ->with('categorias',$categorias);
    }
    public function insertar(Request $req){
        //dd($req);
        $validacion = Validator::make( $req->all(),[
            'name'=>'required|min:4|max:100',
            'description'=>'required|min:5',
            'price'=>'required',
            'img'=>'required|mimes:jpg,png,jpeg,webp|max:2000',
            'btype'=>'required',
            'cate'=>'required'
        ] );
        if ($validacion->fails()){
            return back()
                ->withInput()
                ->with('ErrorInsert', 'Favor de llenar todos los campos')
                ->withErrors($validacion);
        }else{
            $ti = hash::make(rand(0,999999999));
            $ts = hash::make(rand(0,999999999));
            $img = $req->file('img');
            $name = time(). '.' .$img->getClientOriginalExtension();
            $destination_path=public_path('Nfts');
            $req->img->move($destination_path, $name);

            $nuevo = Nft::create([
                'name' => $req->name,
                'description' =>$req->description,
                'base_price' =>$req->price,
                'img' => $name,
                'blockchain_type' =>$req->btype,
                'id_category' =>$req->cate,
                'token_id' =>$ti,
                'token_standar'=>$ts,
                'metadata'=>'',
                'id_user'=>1,
                'likes'=>0
            ]);
            return back()->with('Listo', 'Se ha insertado correctamente');
        }
        //Llave funcion
        
            
        
    }
        public function reporte(){
            $productos=\DB::table('NftBid')->get()
            ->select('nfts.*','categorias.category',
                'users.name as username')
            ->join('categories','nft.id_category','=','categories.id')
            ->join('users','nft.id_users','=','users.id')
            ->get();
            $datos=[
                'fecha'=>date('Y-m-d H:i:s'),
                'productos'=>$productos
            ];
            return PDF::loadView('reporte.productos',$datos)->stream('reporte.pdf');
        }

}
