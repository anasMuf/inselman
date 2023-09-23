<?php

namespace App\Http\Controllers\ProductCategory;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function main(Request $req)
    {
        if($req->ajax()){
            $data = ProductCategory::query();
            // return $req->all();
            if ($req->filled('from_date') && $req->filled('to_date')) {
                $data = $data->whereBetween('created_at', [$req->from_date.' 00:00:00', $req->to_date.' 23:59:59']);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                // ->editColumn('selling_price', function ($row) {
                //     return 'Rp '. number_format($row->selling_price, 0, ',','.');
                // })
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
        return view('product_category.main');
    }

    function formContent(Request $req)
    {
        $data['content'] = view('product_category.form')->render();
        return response()->json($data);
    }

    function getData(Request $req) {
        if($req->ajax()){
            $data = ProductCategory::find($req->id);
            $content = view('product_category.form',$data)->render();

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
                'category_name'          => 'required|max:125',
            ];
            $messages = [
                'required' => ':attribute harus diisi',
                'max' => 'Maksimal :attribute melebihi batas'
            ];
            $attributes = [
                'category_name' => 'Nama Kategori Barang',
            ];
            $validator = Validator::make($req->all(), $rules, $messages, $attributes);

            if (!$validator->fails()) {

                if($req->id){
                    $product_category = ProductCategory::find($req->id);
                }else{
                    $product_category = new ProductCategory;
                }

                $product_category->category_name = $req->category_name;
                $product_category->save();

                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menyimpan data','data' => $product_category];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menyimpan data', 'message_validation' => $validator->getMessageBag()];
            }
        }
    }

    function delete(Request $req){
        if($req->ajax()){
            $product_category = ProductCategory::find($req->id);
            if($product_category){
                $product_category->delete();
                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menghapus data'];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menghapus data','data' => $product_category];
            }
        }
    }
}
