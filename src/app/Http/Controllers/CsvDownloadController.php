<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CsvDownloadController extends Controller
{
   public function downloadCsv()
    {
        $fileName = 'contacts.csv';

        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');

            // CSVヘッダー行（仕様書に合わせて必要な項目を並べる）
            fputcsv($handle, [
                'ID',
                '姓',
                '名',
                '性別',
                'メールアドレス',
                '電話番号',
                '住所',
                '建物名',
                'お問い合わせの種類',
                'お問い合わせ内容',
                '登録日時'
            ]);

            // データ取得（全件）
            $contacts = Contact::with('category')->get();

            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    $contact->id,
                    $contact->last_name,
                    $contact->first_name,
                    ['','男性','女性','その他'][$contact->gender],
                    $contact->email,
                    $contact->tel,
                    $contact->address,
                    $contact->building,
                    $contact->category->content,
                    $contact->detail,
                    $contact->created_at,
                ]);
            }

            fclose($handle);
        });

        // CSVダウンロードのレスポンス設定
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }
}