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
        $contact = $request->all();

        // 氏名（表示用）
        $fullName = $request->last_name . ' ' . $request->first_name;

        // 電話番号（表示用）
        $entireTel = $request->input('front-tel')
                    . $request->input('middle-tel')
                    . $request->input('back-tel');

        // 性別（表示用）
        $genderText = [
            1 => '男性',
            2 => '女性',
            3 => 'その他'
        ][$request->gender];

        // カテゴリー名（表示用）
        $category = Category::find($request->category_id);

        return view('confirm', [
            'contact' => $contact,
            'fullName' => $fullName,
            'entireTel' => $entireTel,
            'genderText' => $genderText,
            'categoryName' => $category->content
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

        foreach ($contacts as $contact) {
            $contact->gender = ['','男性','女性','その他'][$contact->gender];
        }

        return view('admin', compact('contacts'));
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
        if ($request->filled('gender_dropdown')) {
            $query->where('gender', $request->gender_dropdown);
        }

        // カテゴリー
        if ($request->filled('category_dropdown')) {
            $query->where('category_id', $request->category_dropdown);
        }

        // 日付
        if ($request->filled('date_calendar')) {
            $query->whereDate('created_at', $request->date_calendar);
        }

        $contacts = $query->paginate(7);

        foreach ($contacts as $contact) {
            $contact->gender = ['','男性','女性','その他'][$contact->gender];
        }

        return view('admin', compact('contacts'));
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