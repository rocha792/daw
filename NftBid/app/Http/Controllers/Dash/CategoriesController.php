<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Validator;
use File;


class CategoriesController extends Controller
{
    public function index(){
        $cates = \DB::table('categories')->get();
        return view('dash.Categories')->with('cates',$cates);
    }
    public function Store (Request $req)
    {
        $validacion = Validator::make( $req->all(),[
            'name'=>'required|min:4|max:100',
            'img'=>'required|mimes:jpg,png,jpeg,webp|max:2000',
        ] );
        if ($validacion->fails()){
            return back()
                ->withInput()
                ->with('ErrorInsert', 'Favor de llenar todos los campos')
                ->withErrors($validacion);
        }else{
            $img = $req->file('img');
            $name = time(). '.' .$img->getClientOriginalExtension();
            $destination_path=public_path('Categories');
            $req->img->move($destination_path, $name);
            Category::create([
                'category'=>$req->name,
                'img'=>$name
            ]);
            return back()->with('Listo', 'Se ha insertado correctamente');
        }
    }
    public function destroy($id)
    {
        $categoria = Category::find($id);
        if($categoria->img != 'default.jpg'){
            if (File::exists(public_path('categories/'.$categoria->img))){
                unlink(public_path('categories/'.$categoria->img));
            }
        }
        $categoria->delete();
        
        return back()->witch('Listo','El reguistro se elimino');
    }
}