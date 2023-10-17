<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceConfirmMail;
use App\Models\User;
use App\Models\Paper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\UserProduct;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;

class PaperController extends Controller
{
	public function index(Request $request)
	{
        return view('paper/invoice');
	}

	public function invoicePdf(Request $request, string $id) {
		$editInvoice = Paper::where('id', $id)->first();

		$answers=[];
        $listModel = null;
        $user_id = Auth::user()->id;
        $listModel = null;
		$models = null;
        if (Auth::user()->isAdmin()) {
            $listModel = UserProduct::orderby('id', 'desc')->get();
        } else {
            $listModel = UserProduct::where('user_id', $user_id)->orderby('id', 'desc')->get();
        }

		$user_model = User::find(Auth::user()->id);
		$user_like_products = $user_model->productes;

		$models = null;
        if (Auth::user()->isAdmin()) {
            $models = UserProduct::orderby('id', 'desc')->simplePaginate(15);
        } else {
            $models = UserProduct::where('user_id', $user_id)->orderby('id', 'desc')->simplePaginate(15);
        }

		$listDataTmp = array();
		foreach($listModel as $i => $model) {
			$listDataTmp[$i]['product'] = $model->name;
			//add selections...
			$listDataTmp[$i]['brand'] = $model->brandName;
			$listDataTmp[$i]['file_url'] = $model->getImageUrlFirstFullPath('blank');
			$listDataTmp[$i]['value'] = $model->price;
			$listDataTmp[$i]['id'] = $model->id;
			$listDataTmp[$i]['options'] = $model->getOptions2();
			$listDataTmp[$i]['productID'] = $model->getProductID();
			$tp_collection = $user_like_products->find($model->id);
			if($tp_collection != null) $listDataTmp[$i]['productLike'] = 'LIKE';
			else $listDataTmp[$i]['productLike'] = 'NOLIKE';
		}
		$answers[0]=$listDataTmp;

		$productFormat = new UserProduct;
		$productOptions = $productFormat->getAllOptionNames();

		$contacts = [];
		$contacts[0] = " "; 
		$t_contacts = [];
		$papers = Paper::where('user_id', Auth::user()->id)->get();
		if(count($papers) > 0){
			foreach($papers as $paper){
				if ($paper->send_name == '') continue;
				if (array_search($paper->send_name, $contacts) !== false) continue;
				array_push($contacts, $paper->send_name);		
			}
		}
		
    return view('paper/invoicePdf', [
			'editData' => $editInvoice,
			'productOptions' => $productOptions,
			'models' => $models,
			'dis_data' => json_encode($answers),
		]);
	}

	public function invoiceNew(Request $request)
	{
		$answers=[];
        $listModel = null;
        $user_id = Auth::user()->id;
        $listModel = null;
		$models = null;
        if (Auth::user()->isAdmin()) {
            $listModel = UserProduct::orderby('id', 'desc')->get();
        } else {
            $listModel = UserProduct::where('user_id', $user_id)->orderby('id', 'desc')->get();
        }

		$user_model = User::find(Auth::user()->id);
		$user_like_products = $user_model->productes;

		$models = null;
        if (Auth::user()->isAdmin()) {
            $models = UserProduct::orderby('id', 'desc')->simplePaginate(15);
        } else {
            $models = UserProduct::where('user_id', $user_id)->orderby('id', 'desc')->simplePaginate(15);
        }

		$listDataTmp = array();
		foreach($listModel as $i => $model) {
			$listDataTmp[$i]['product'] = $model->name;
			//add selections...
			$listDataTmp[$i]['brand'] = $model->brandName;
			$listDataTmp[$i]['file_url'] = $model->getImageUrlFirstFullPath('blank');
			$listDataTmp[$i]['value'] = $model->price;
			$listDataTmp[$i]['id'] = $model->id;
			$listDataTmp[$i]['options'] = $model->getOptions2();
			$listDataTmp[$i]['productID'] = $model->getProductID();
			$tp_collection = $user_like_products->find($model->id);
			if($tp_collection != null) $listDataTmp[$i]['productLike'] = 'LIKE';
			else $listDataTmp[$i]['productLike'] = 'NOLIKE';
		}
		
		$answers[0] = $listDataTmp;

        $date = strval(date('Y-m-d'));
        $expire = strval(date('Y-m-d',strtotime('+1 day')));

		$productFormat = new UserProduct;
		$productOptions = $productFormat->getAllOptionNames();

		$contacts = [];
		$contacts[0] = " "; 
		$t_contacts = [];
		$papers = Paper::where('user_id', Auth::user()->id)->get();
		if(count($papers) > 0){
			foreach($papers as $paper){
				if ($paper->send_name == '') continue;
				if (array_search($paper->send_name, $contacts) !== false) continue;
				array_push($contacts, $paper->send_name);		
			}
		}

        return view('paper/invoiceNew', [
			'edit_id'=>0,
			'cDate'=>$date,
			'eDate'=>$expire,
			'answers'=>$answers,
			'productOptions' => $productOptions,
			'models' => $models,
			'contacts' => $contacts,
        ]);
	}


	public function invoiceSave(Request $request){
		$user_id=Auth::user()->id;
		$subject=$request->invoiceName;
		$category='invoice';
		$content=$request->file;
		$cDate=$request->invoice_cDate;
		$eDate=$request->invoice_eDate;
		$memo_text=$request->memo_text;
		$total_price=$request->total_price;
		$send_name=$request->send_name;
		$is_using_credit_card=$request->is_using_credit_card === 'true' ? 1 : 0;

		if($request->paper_id==0){  
			$paper= new Paper();
			$paper->user_id = $user_id;
			$paper->subject = $subject;
			$paper->category = $category;
			$paper->content = $content;
			$paper->cDate = $cDate;
			$paper->eDate = $eDate;
			$paper->total_price = $total_price;
			$paper->memo_text = $memo_text;
			$paper->send_name = $send_name;
			$paper->is_using_credit_card = $is_using_credit_card;
			$paper->save();
			$edit_id=$paper->id;
			return ['edit_id'=>$edit_id,'inv_state'=>'add'];
		}
		else{
			Paper::where('id',$request->paper_id)->update([
				'content'=>$content,
				'subject'=>$subject,
				'category'=>$category,
				'cDate'=>$cDate,
				'eDate'=>$eDate,
				'total_price'=>$total_price,
				'memo_text'=>$memo_text,
				'send_name'=>$send_name,
				'is_using_credit_card' => $is_using_credit_card,
			]);
			$edit_id=$request->paper_id;
			return ['edit_id'=>$edit_id,'inv_state'=>'edit'];
		}
	}

	public function invoiceEdit(Request $request, $id){
		$editInvoice = Paper::where('id', $id)->first();

		$answers=[];
        $listModel = null;
        $user_id = Auth::user()->id;
        $listModel = null;
		$models = null;
        if (Auth::user()->isAdmin()) {
            $listModel = UserProduct::orderby('id', 'desc')->get();
        } else {
            $listModel = UserProduct::where('user_id', $user_id)->orderby('id', 'desc')->get();
        }

		$user_model = User::find(Auth::user()->id);
		$user_like_products = $user_model->productes;

		$models = null;
        if (Auth::user()->isAdmin()) {
            $models = UserProduct::orderby('id', 'desc')->simplePaginate(15);
        } else {
            $models = UserProduct::where('user_id', $user_id)->orderby('id', 'desc')->simplePaginate(15);
        }

		$listDataTmp = array();
		foreach($listModel as $i => $model) {
			$listDataTmp[$i]['product'] = $model->name;
			//add selections...
			$listDataTmp[$i]['brand'] = $model->brandName;
			$listDataTmp[$i]['file_url'] = $model->getImageUrlFirstFullPath('blank');
			$listDataTmp[$i]['value'] = $model->price;
			$listDataTmp[$i]['id'] = $model->id;
			$listDataTmp[$i]['options'] = $model->getOptions2();
			$listDataTmp[$i]['productID'] = $model->getProductID();
			$tp_collection = $user_like_products->find($model->id);
			if($tp_collection != null) $listDataTmp[$i]['productLike'] = 'LIKE';
			else $listDataTmp[$i]['productLike'] = 'NOLIKE';
		}
		$answers[0]=$listDataTmp;

		$productFormat = new UserProduct;
		$productOptions = $productFormat->getAllOptionNames();

		$contacts = [];
		$contacts[0] = " "; 
		$t_contacts = [];
		$papers = Paper::where('user_id', Auth::user()->id)->get();
		if(count($papers) > 0){
			foreach($papers as $paper){
				if ($paper->send_name == '') continue;
				if (array_search($paper->send_name, $contacts) !== false) continue;
				array_push($contacts, $paper->send_name);		
			}
		}

        return view('paper/invoiceEdit', [
			'editData' => $editInvoice,
			'productOptions' => $productOptions,
			'models' => $models,
			'dis_data' => json_encode($answers),
		]);
	}
	public function duplicate_invoice(Request $request, $id){
		$editInvoice = Paper::where('id', $id)->first();
		$newInvoice = $editInvoice -> replicate();
		$newInvoice -> save();

		return redirect(route('paper.invoice'));

	}

	public function invoiceDelete(Request $request, $id){
		Paper::where('id', $id)->delete();
		return redirect(route('paper.invoice'));
	}

	public function invoice(Request $request){
		$papers = Paper::where('user_id',Auth::user()->id)->orderby('id', 'desc')->get();
		$user=User::where('id',Auth::user()->id)->first();
		$userName=$user->name;
		return view('paper/invoice',['papers' => $papers, 'userName'=>$userName,]);
	}

	public function invoiceMemoEdit(Request $request){
		$memo_text = ($request->memoText == null)? " " : $request->memoText;
		Paper::where('id',$request->paperid)->update([
				'memo_text'=>$memo_text,
			]);
		return redirect(route('paper.invoice'));
	}

	public function invoiceMailSend(Request $request) {
		$pdfFileUrl = asset($request->file->storeAs('public/pdfs', '請求書_' . Str::uuid() .'.pdf'));
		$pdfFileUrl = str_replace('public/pdfs', 'public/storage/pdfs', $pdfFileUrl);

		$filePath = $request->file->storeAs('pdfs', '請求書_' . Str::uuid() .'.pdf');
		$filePath = str_replace('storage/pdfs', 'storage/app/pdfs', storage_path($filePath));
		
		$emails    = explode("#", substr($request->mails_text,1));
		$mail_body = $request->mail_textarea;

		$clientName = $request->client_name;
		$totalPrice = $request->total_price;
		
		$user = Auth::user();
		$senderName = $user->full_name;

		foreach($emails as $to_email){
			$data = [
				'body' => str_replace("\n", '<br>', $mail_body),
			];
		
			$invoice = Invoice::create([
				'id'   => Str::uuid(),
				'from' => $user->email,
				'to'   => $to_email,
				'pdf_file_url' => $pdfFileUrl,
				'total_price' => $totalPrice,
			]);

			if ($request->is_using_credit_card === 'true') {
				$data['paymentLink'] = $request->getUriForPath('') . '/payment_invoice?id=' . $invoice->id;
			}

			Mail::to($to_email)->send(new InvoiceMail($clientName, $senderName, $data, $filePath));
			Mail::to($user->email)->send(new InvoiceConfirmMail($clientName, $senderName, $data, $filePath));
		}
		
		return;
	}
}