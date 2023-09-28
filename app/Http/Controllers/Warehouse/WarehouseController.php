<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends Controller
{

    public function main(Request $req)
    {
        if($req->ajax()){
            $data = Warehouse::query();
            // return $req->all();
            if ($req->filled('from_date') && $req->filled('to_date')) {
                $data = $data->whereBetween('created_at', [$req->from_date.' 00:00:00', $req->to_date.' 23:59:59']);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('opsi', function($row) {
                    $btn = '
                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="dropdown"><i class="fas fa-bars"></i></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" onclick="form_data('.$row->id.',`lihat`)"><i class="fas fa-eye"></i> Lihat</a>
                            <a class="dropdown-item" onclick="form_data('.$row->id.')"><i class="fas fa-edit"></i> Edit</a>
                            <a class="dropdown-item" onclick="hapus('.$row->id.')"><i class="fas fa-trash-alt"></i> Delete</a>
                        </div>
                    ';
                    return $btn;
                })
                ->rawColumns(['opsi'])
                ->make(true);
        }
        return view('warehouse.main');
    }

    function formContent(Request $req)
    {
        $data['warehouse_code'] = $this->genarateWarehouseCode();
        $data['content'] = view('warehouse.form')->render();
        return $data;
    }

    function getData(Request $req)
    {
        if($req->ajax()){
            $data = Warehouse::find($req->id);
            $content = view('warehouse.form',$data)->render();

            if($data){
                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menampilkan data', 'content' => $content,'data' => $data];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menampilkan data'];
            }
        }
    }

    function genarateWarehouseCode()
    {
        $cek_kode_terakhir = Warehouse::selectRaw('RIGHT(warehouse_code,5) AS warehouse_code')->orderBy('id','desc')->first();
        if($cek_kode_terakhir){
            $warehouse_code = $cek_kode_terakhir->warehouse_code+1;
        }else{
            $warehouse_code = 1;
        }
        $current_date = date('Ymd');
        $create_warehouse_code = str_pad($warehouse_code, 5, "0", STR_PAD_LEFT);
        $warehouse_code = 'WHS-'.$create_warehouse_code;

        return $warehouse_code;
    }

    function save(Request $req)
    {
        if($req->ajax()){

            $rules = [
                'warehouse_code'    => 'required|max:125',
                'warehouse_name'    => 'required|max:125',
                'description'       => 'required|max:125',
                'address'           => 'required|max:125',
                'contact'           => 'required|max:125',
            ];
            $messages = [
                'required' => 'Kolom :attribute harus diisi',
                'max' => 'Maksimal :attribute melebihi batas'
            ];
            $validator = Validator::make($req->all(), $rules, $messages);

            if (!$validator->fails()) {

                if($req->id){
                    $warehouse = Warehouse::find($req->id);
                }else{
                    $warehouse = new Warehouse;
                }

                $warehouse->warehouse_code = $req->warehouse_code;
                $warehouse->warehouse_name = $req->warehouse_name;
                $warehouse->address = $req->address;
                $warehouse->description = $req->description;
                $warehouse->contact = $req->contact;
                $warehouse->save();

                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menyimpan data','data' => $warehouse];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menyimpan data', 'message_validation' => $validator->getMessageBag()];
            }
        }
    }

    function delete(Request $req)
    {
        if($req->ajax()){
            $warehouse = Warehouse::find($req->id);
            if($warehouse){
                $warehouse->delete();
                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menghapus data'];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menghapus data','data' => $warehouse];
            }
        }
    }
}
