<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Events\ItemPost;
use App\Events\ItemRemove;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('todoList');
    }

    public function fetchItems(){
        // dd(Item::with('user')->get());
        return Item::with('user')->where('user_id',Auth::id())->get();
        // return Item::where('id',$id)->get();
    }

    public function postItem(Request $request){
        
        $user = Auth::user();
        
        $item = $user->items()->create([
            'item'=>$request->item
        ]);

        broadcast(new ItemPost($user,$item))->toOthers();

        return Item::with('user')->where('user_id',Auth::id())->get();
        
    }

    public function deleteItem($id){

        Item::find($id)->delete();

        $user = Auth::user();
        $item = Item::with('user')->where('user_id',Auth::id())->get();

        broadcast(new ItemRemove($user,$item))->toOthers();

        return Item::with('user')->where('user_id',Auth::id())->get();
        
    }
}
