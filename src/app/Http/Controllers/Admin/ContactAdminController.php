<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactAdminController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'keyword'    => $request->input('keyword'),
            'gender'     => $request->input('gender'),
            'category_id'=> $request->input('category_id'),
            'date_from'  => $request->input('date_from'),
            'date_to'    => $request->input('date_to'),
        ];

        $q = Contact::query()->with('category');

        if (filled($filters['keyword'])) {
            $kw = '%'.$filters['keyword'].'%';
            $q->where(function($q) use ($kw){
                $q->where('last_name','like',$kw)
                  ->orWhere('first_name','like',$kw)
                  ->orWhereRaw("concat(last_name, first_name) like ?", [$kw])
                  ->orWhere('email','like',$kw)
                  ->orWhere('tel','like',$kw)
                  ->orWhere('address','like',$kw)
                  ->orWhere('building','like',$kw)
                  ->orWhere('detail','like',$kw);
            });
        }
        if (in_array($filters['gender'], ['1','2','3'], true)) {
            $q->where('gender', $filters['gender']);
        }
        if (filled($filters['category_id'])) {
            $q->where('category_id', $filters['category_id']);
        }
        if (filled($filters['date_from'])) {
            $q->whereDate('created_at','>=', $filters['date_from']);
        }
        if (filled($filters['date_to'])) {
            $q->whereDate('created_at','<=', $filters['date_to']);
        }

        $contacts   = $q->orderByDesc('created_at')
                        ->paginate(7)
                        ->appends($request->query());

        $categories = Category::pluck('content','id');

        return view('admin.index', compact('contacts','categories','filters'));
    }

    // モーダル詳細用（JSON）
    public function show($id)
    {
        $c = Contact::with('category')->findOrFail($id);
        return response()->json([
            'id'      => $c->id,
            'name'    => $c->last_name.' '.$c->first_name,
            'gender'  => [1=>'男性',2=>'女性',3=>'その他'][$c->gender] ?? '',
            'email'   => $c->email,
            'tel'     => $c->tel,
            'address' => $c->address,
            'building'=> $c->building,
            'category'=> $c->category->content ?? '',
            'detail'  => $c->detail,
            'created' => $c->created_at->format('Y-m-d H:i'),
        ]);
    }

    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return back()->with('status','削除しました');
    }

    // 検索結果をCSVでエクスポート
    public function export(Request $request): StreamedResponse
    {
        // index と同じフィルタを適用
        $request->merge(['page'=>null]); // 念のため
        $q = Contact::query()->with('category');

        if ($kw = $request->input('keyword')) {
            $kw = '%'.$kw.'%';
            $q->where(function($q) use ($kw){
                $q->where('last_name','like',$kw)
                  ->orWhere('first_name','like',$kw)
                  ->orWhereRaw("concat(last_name, first_name) like ?", [$kw])
                  ->orWhere('email','like',$kw)
                  ->orWhere('tel','like',$kw)
                  ->orWhere('address','like',$kw)
                  ->orWhere('building','like',$kw)
                  ->orWhere('detail','like',$kw);
            });
        }
        if (in_array($request->gender, ['1','2','3'], true)) $q->where('gender',$request->gender);
        if ($request->filled('category_id')) $q->where('category_id',$request->category_id);
        if ($request->filled('date_from')) $q->whereDate('created_at','>=',$request->date_from);
        if ($request->filled('date_to'))   $q->whereDate('created_at','<=',$request->date_to);

        $filename = 'contacts_'.now()->format('Ymd_His').'.csv';

        return response()->streamDownload(function() use ($q){
            $out = fopen('php://output','w');
            // ヘッダ
            fputcsv($out, ['作成日','姓','名','性別','メール','電話','住所','建物名','種類','内容']);
            // 1万件くらいまでならchunkで十分
            $q->orderBy('id')->chunk(500, function($rows) use ($out){
                foreach ($rows as $c) {
                    fputcsv($out, [
                        $c->created_at->format('Y-m-d H:i'),
                        $c->last_name,
                        $c->first_name,
                        [1=>'男性',2=>'女性',3=>'その他'][$c->gender] ?? '',
                        $c->email,
                        $c->tel,
                        $c->address,
                        $c->building,
                        optional($c->category)->content,
                        $c->detail,
                    ]);
                }
            });
            fclose($out);
        }, $filename, ['Content-Type'=>'text/csv; charset=UTF-8']);
    }
}
