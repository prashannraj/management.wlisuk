<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IsoCountry;
use App\Models\IsoCurrency;
use Illuminate\Support\Str;

class BaseController extends Controller
{
	public function getTitle(){
		return [ 'Mr', 'Mrs', 'Ms', 'Miss', 'Dr', 'Prof', 'Sir'];
	}

	public function getCounrtyCode(){
		return IsoCountry::select('id','title','calling_code')->orderBy('order','desc')->get();
	}

	public function getCountryCode(){
		return IsoCountry::select('id','title','calling_code')->orderBy('order','desc')->get();
	}	

	public function getCurrencyCode(){
		return IsoCurrency::select('id','title','currency_name')->orderBy('currency_name','desc')->get();
	}

	/*
	 * Assume Image parameters to defined then save the files
	 */
	public function saveUpdateImage($file, $fileName, $path, $extra = null) {
		$fileName = '';
		if($file){
			$file_name = preg_replace('/\..+$/', '', $file->getClientOriginalName());
			$file_extension = $file->getClientOriginalExtension();
			if ($extra) {
				$fileName = $extra . '/' . strtotime(now()) . '_' . strtolower(Str::slug($file_name, '_')) . '.' . $file_extension;
			}else{
				$fileName = strtotime(now()) . '_' . strtolower(str_slug($file_name, '_')) . '.' . $file_extension;
			}
			$path = 
			$file->move($path, $fileName);
		}

		return $fileName;

	}

	/*
	 * Assume Image parameters to defined then save the files
	 */
	public function saveUpdateFile($file, $fileName, $path, $extra = null) {
		$fileName = '';
		if($file){
			$file_name = preg_replace('/\..+$/', '', $file->getClientOriginalName());
			$file_extension = $file->getClientOriginalExtension();
			if ($extra) {
				$fileName = $extra . '/' . strtotime(now()) . '_' . strtolower(Str::slug($file_name, '_')) . '.' . $file_extension;
			}else{
				$fileName = strtotime(now()) . '_' . strtolower(str_slug($file_name, '_')) . '.' . $file_extension;
			}
			$path = 
			$file->move($path, $fileName);
		}

		return $fileName;

	}

}