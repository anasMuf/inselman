<?php

namespace App\Http\Controllers;

use App\Models\MenuA;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
// use DataTables;

class MenuAController extends Controller
{
    public function main(Request $req)
    {
        if($req->ajax()){
            $data = MenuA::query();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('menu', function($row){
                    // $btn = '
                    //     <a href="javascript:void(0)" class="btn btn-secondary btn-sm"><i class="mdi mdi-menu"></i></a>
                    // ';
                    $btn = '
                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="dropdown"><i class="mdi mdi-menu"></i></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item">Lihat</a>
                            <a class="dropdown-item">Edit</a>
                            <a class="dropdown-item">Delete</a>
                        </div>
                    ';
                    return $btn;
                })
                ->rawColumns(['menu'])
                ->make(true);
        }
        return view('menu.main');
    }
}
