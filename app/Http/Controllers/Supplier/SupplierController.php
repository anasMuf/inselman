<?php

namespace App\Http\Controllers\Supplier;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function main(Request $req)
    {
        if($req->ajax()){
            $data = Supplier::query();
            // return $req->all();
            if ($req->filled('from_date') && $req->filled('to_date')) {
                $data = $data->whereBetween('created_at', [$req->from_date.' 00:00:00', $req->to_date.' 23:59:59']);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('opsi', function($row) {
                    $btn = '
                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="dropdown"><i class="mdi mdi-menu"></i></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" onclick="form_data('.$row->id.',`lihat`)"><i class="typcn typcn-eye"></i> Lihat</a>
                            <a class="dropdown-item" onclick="form_data('.$row->id.')"><i class="typcn typcn-pencil"></i> Edit</a>
                            <a class="dropdown-item" onclick="hapus('.$row->id.')"><i class="typcn typcn-trash"></i> Delete</a>
                        </div>
                    ';
                    return $btn;
                })
                ->rawColumns(['opsi'])
                ->make(true);
        }
        return view('supplier.main');
    }

    function formContent(Request $req)
    {
        $data['content'] = view('supplier.form')->render();
        return response()->json($data);
    }

    function getData(Request $req) {
        if($req->ajax()){
            $data = Supplier::find($req->id);
            $content = view('supplier.form',$data)->render();

            if($data){
                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menampilkan data', 'content' => $content,'data' => $data];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menampilkan data'];
            }
        }
    }

    function save(Request $req){
        if($req->ajax()){

            $rules = [
                'supplier_name'    => 'required|max:125',
                'address'          => 'required|max:125',
                'contact'          => 'required|max:125',
            ];
            $messages = [
                'required' => 'Kolom :attribute harus diisi',
                'max' => 'Maksimal :attribute melebihi batas'
            ];
            $validator = Validator::make($req->all(), $rules, $messages);

            if (!$validator->fails()) {

                if($req->id){
                    $supplier = Supplier::find($req->id);
                }else{
                    $supplier = new Supplier;
                }

                $supplier->supplier_name = $req->supplier_name;
                $supplier->address = $req->address;
                $supplier->contact = $req->contact;
                $supplier->save();

                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menyimpan data','data' => $supplier];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menyimpan data', 'message_validation' => $validator->getMessageBag()];
            }
        }
    }

    function delete(Request $req){
        if($req->ajax()){
            $supplier = Supplier::find($req->id);
            if($supplier){
                $supplier->delete();
                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menghapus data'];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menghapus data','data' => $supplier];
            }
        }
    }
}
