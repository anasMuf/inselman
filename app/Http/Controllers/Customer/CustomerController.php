<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function main(Request $req)
    {
        if($req->ajax()){
            $data = Customer::query();
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
        return view('customer.main');
    }

    function formContent(Request $req)
    {
        $data['content'] = view('customer.form')->render();
        return response()->json($data);
    }

    function getData(Request $req) {
        if($req->ajax()){
            $data = Customer::find($req->id);
            $content = view('customer.form',$data)->render();

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
                'name'    => 'required|max:125',
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
                    $customer = Customer::find($req->id);
                }else{
                    $customer = new Customer;
                }

                $customer->name = $req->name;
                $customer->address = $req->address;
                $customer->contact = $req->contact;
                $customer->save();

                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menyimpan data','data' => $customer];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menyimpan data', 'message_validation' => $validator->getMessageBag()];
            }
        }
    }

    function delete(Request $req){
        if($req->ajax()){
            $customer = Customer::find($req->id);
            if($customer){
                $customer->delete();
                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menghapus data'];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menghapus data','data' => $customer];
            }
        }
    }
}
