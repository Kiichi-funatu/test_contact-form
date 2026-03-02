<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use Normalizer;

class ContactController extends Controller
{
    public function index()
    {
        // カテゴリー一覧を取得（仕様書 FN002）
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
{
    // 電話番号の結合（仕様書：10〜11桁）
    $entireTel = $request->input('front-tel')
                . $request->input('middle-tel')
                . $request->input('back-tel');

    // 電話番号の合計桁数チェック
    if (strlen($entireTel) < 10 || strlen($entireTel) > 11) {
        return back()
            ->withErrors(['tel' => '電話番号は10桁または11桁で入力してください'])
            ->withInput();
    }

    // 氏名（表示用）
    $fullName = $request->last_name . ' ' . $request->first_name;

    // 性別（表示用）
    $genderText = [
        1 => '男性',
        2 => '女性',
        3 => 'その他'
    ][$request->gender];

    // カテゴリー名（表示用）
    $category = Category::find($request->category_id);

    return view('confirm', [
        'fullName' => $fullName,
        'entireTel' => $entireTel,
        'genderText' => $genderText,
        'categoryName' => $category->content,
        'contact' => $request->validated(), // 必要なら validated を渡す
    ]);
}

    public function store(Request $request)
    {
        // 修正ボタン
        if ($request->get('action') === 'modify') {
            return redirect('/')->withInput();
        }

        // 電話番号を結合（仕様書 FN001）
        $tel = $request->input('front-tel')
             . $request->input('middle-tel')
             . $request->input('back-tel');

        // 保存データ（hidden で送られてきた値）
        $contact = [
            'category_id' => $request->category_id,
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'gender'      => $request->gender,
            'email'       => $request->email,
            'tel'         => $tel,
            'address'     => $request->address,
            'building'    => $request->building,
            'detail'      => $request->detail,
        ];

        Contact::create($contact);

        return view('thanks');
    }

    public function admin()
    {
        $contacts = Contact::paginate(7);
        $categories = Category::all();   

        foreach ($contacts as $contact) {
        $contact->gender = ['','男性','女性','その他'][$contact->gender];
    }

        return view('admin', compact('contacts', 'categories'));

    }

    public function search(Request $request)
{
    $query = Contact::query();

    // 名前（姓・名・フルネーム）
    if ($request->filled('name_email_filter')) {
        $filter = Normalizer::normalize($request->name_email_filter, Normalizer::FORM_C);

        $query->where(function ($q) use ($filter) {
            $q->whereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$filter}%"])
              ->orWhere('email', 'like', "%{$filter}%");
        });
    }

    // 性別
    if ($request->gender_dropdown && $request->gender_dropdown != 0) {
        $query->where('gender', $request->gender_dropdown);
    }

    // カテゴリー（←修正）
    if ($request->category_dropdown && $request->category_dropdown != 0) {
        $query->where('category_id', $request->category_dropdown);
    }

    // 日付
    if ($request->filled('date_calendar')) {
        $query->whereDate('created_at', $request->date_calendar);
    }

    $contacts = $query->paginate(7);
    $categories = Category::all();

    foreach ($contacts as $contact) {
        $contact->gender = ['','男性','女性','その他'][$contact->gender];
    }

    return view('admin', compact('contacts', 'categories'));
}

    public function reset()
    {
        return redirect('/admin');
    }

    public function delete(Request $request)
    {
        $contact = Contact::findOrFail($request->id);
        $contact->delete();
        return redirect('/admin');
    }
}