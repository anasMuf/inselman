<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Models\PurchaseDetail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function main(Request $req)
    {
        if($req->ajax()){
            $data = Purchase::join('warehouses as w','purchases.warehouse_id','w.id')->join('suppliers as s','purchases.supplier_id','s.id')->orderBy('purchases.id','desc')->get();
            // return $req->all();
            if ($req->filled('from_date') && $req->filled('to_date')) {
                $data = $data->whereBetween('created_at', [$req->from_date.' 00:00:00', $req->to_date.' 23:59:59']);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('total_payment', function ($row) {
                    return 'Rp '. number_format($row->total_payment, 0, ',','.');
                })
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
        return view('purchase.main');
    }

    function generatePurchaseReff()
    {
        $cek_kode_terakhir = Purchase::selectRaw('RIGHT(purchase_reff,5) AS no_reff')->orderBy('id','desc')->first();
        if($cek_kode_terakhir){
            $no_reff = $cek_kode_terakhir->purchase_reff+1;
        }else{
            $no_reff = 1;
        }
        $current_date = date('Ymd');
        $create_no_reff = str_pad($no_reff, 5, "0", STR_PAD_LEFT);
        $purchase_reff = 'PCH-'.$current_date.'-'.$create_no_reff;

        return $purchase_reff;
    }

    function formContent(Request $req)
    {
        $data['warehouse'] = Warehouse::all();
        $data['supplier'] = Supplier::all();
        $data['product'] = Product::where('product_name', 'like', '%' . $req->q . '%')->get();
        $data['content'] = view('purchase.form',$data)->render();
        return response()->json($data);
    }

    function hitungSubTotal(Request $req)
    {
        $purchase_quantity = $req->purchase_quantity;
        $purchase_price_per_unit = $req->purchase_price_per_unit ? str_replace('.','',$req->purchase_price_per_unit) : 0;
        $subtotal = $purchase_price_per_unit*$purchase_quantity;

        return number_format($subtotal,0,',','.');
    }

    public function hitungTotal(Request $request)
    {
        $subtotals = $request->input('subtotals');

        $total = array_sum($subtotals);

        return response()->json(['total' => number_format($total,0,',','.')]);
    }

    function getData(Request $req)
    {
        if($req->ajax()){
            $data = Purchase::find($req->id);
            $content = view('purchase.form',$data)->render();

            if($data){
                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menampilkan data', 'content' => $content,'data' => $data];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menampilkan data'];
            }
        }
    }

    function save(Request $req)
    {
        if($req->ajax()){
            $rules = [
                'purchase_date'         => 'required|max:125',
                'warehouse_id'          => 'required|max:125',
                'supplier_id'           => 'required|max:125',
                'payment'               => 'required|max:125',
            ];
            $messages = [
                'required' => 'Kolom :attribute harus diisi',
                'max' => 'Maksimal :attribute melebihi batas'
            ];
            $validator = Validator::make($req->all(), $rules, $messages);

            if (!$validator->fails()) {
                $purchase = new Purchase;

                $date = date_format(date_create($req->purchase_date),'Y-m-d H:i:s');

                $purchase->purchase_reff = $this->generatePurchaseReff();
                $purchase->purchase_date = $date;
                $purchase->warehouse_id = $req->warehouse_id;
                $purchase->supplier_id = $req->supplier_id;
                $purchase->note = $req->description;
                $purchase->save();//simpan sebagian tabel purchase

                $ambil_id = Purchase::select('id')->orderBy('id','desc')->first();//ambil id yg baru disimpan
                $id_purchase = $ambil_id->id;

                $total = 0;
                $purchase_detail = new PurchaseDetail;
                for($i=0; $i < count($req->product_id); $i++){
                    $subtotal = $req->subtotal[$i] ? $req->subtotal[$i] : $req->purchase_price_per_unit[$i]*$req->purchase_quantity[$i];//menentukan subtotal
                    // $total = $total+$subtotal;//menghitung total dari semua subtotal
                    $total+=$subtotal;//menghitung total dari semua subtotal

                    $purchase_detail->purchase_id = $id_purchase;
                    $purchase_detail->product_id = $req->product_id[$i];
                    $purchase_detail->purchase_quantity = $req->purchase_quantity[$i];
                    $purchase_detail->purchase_price_per_unit = $req->purchase_price_per_unit[$i];
                    $purchase_detail->subtotal = $subtotal;
                    $purchase_detail->save();//simpan data purchase detail
                }
                $total_payment = $total;//menyimpan hasil hitung total pada perulangan

                $ambil_id->total_payment = $total_payment;
                $ambil_id->payment = $req->payment;
                $ambil_id->status = $req->status;
                $ambil_id->save();//mengubah/melengkapi data purchase

                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menyimpan data'];//,'data' => ];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menyimpan data', 'message_validation' => $validator->getMessageBag()];
            }
        }
    }

    function delete(Request $req){
        if($req->ajax()){
            $product = Purchase::find($req->id);
            if($product){
                $product->delete();
                return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil menghapus data'];
            }else{
                return ['status' => 'failed', 'code' => 400, 'message' => 'Gagal menghapus data','data' => $product];
            }
        }
    }
}
