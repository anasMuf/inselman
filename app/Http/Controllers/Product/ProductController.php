<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function main(Request $req)
    {
        if($req->ajax()){
            $data = Product::query();
            // return $req->all();
            if ($req->filled('from_date') && $req->filled('to_date')) {
                $data = $data->whereBetween('created_at', [$req->from_date.' 00:00:00', $req->to_date.' 23:59:59']);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('selling_price', function ($row) {
                    return 'Rp '. number_format($row->selling_price, 0, ',','.');
                })
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
        return view('product.main');
    }

    function formContent(Request $req)
    {
        $data['categories'] = ProductCategory::all();//where('category_name', 'like', "'%".$req->q."%'")->get();
        $data['content'] = view('product.form',$data)->render();
        return response()->json($data);
    }

    function getData(Request $req) {
        if($req->ajax()){
            $data = Product::find($req->id);
            $content = view('product.form',$data)->render();

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
                'product_name'          => 'required|max:125',
                'description'           => 'required|max:125',
                'selling_price'         => 'required|max:125',
                'stock'                 => 'required|max:125',
                'sku'                   => 'required|max:125',
                'product_category_id'   => 'required|max:125',
            ];
            $messages = [
                'required' => ':attribute harus diisi',
                'max' => 'Maksimal :attribute melebihi batas'
            ];
            $attributes = [
                'product_name' => 'Nama Barang',
                'description' => 'Deskripsi',
                'selling_price' => 'Harga Jual',
                'stock' => 'Stok',
                'sku' => 'SKU',
                'product_category_id' => 'Kategori',
            ];
            $validator = Validator::make($req->all(), $rules, $messages, $attributes);

            if (!$validator->fails()) {

                if($req->id){
                    $product = Product::find($req->id);
                }else{
                    $product = new Product;
                }

                $product->product_name = $req->product_name;
                $product->description = $req->description;
                $product->selling_price = $req->selling_price;
                $product->stock = $req->stock;
                $product->sku = $req->sku;
                $product->product_category_id = $req->product_category_id;
                $product->save();

                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menyimpan data','data' => $product];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menyimpan data', 'message_validation' => $validator->getMessageBag()];
            }
        }
    }

    function delete(Request $req){
        if($req->ajax()){
            $product = Product::find($req->id);
            if($product){
                $product->delete();
                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menghapus data'];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menghapus data','data' => $product];
            }
        }
    }
}
