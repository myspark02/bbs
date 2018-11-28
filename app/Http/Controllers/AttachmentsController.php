<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Attachment;
use App\Board;
class AttachmentsController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }

    public function store(Request $request) {
    	$attachment = null;
    	\Log::debug('AttachmentsController store', ['stpe'=>1]);
    	if($request->hasFile('file')) {
    		$file = $request->file('file');
 			
 			/*
 			$cnt = 0;	
    		foreach($files as $file) {
    				\Log::debug('AttachmentsController store', ['stpe'=>4]);
    			$filename = str_random().filter_var($file->getClientOriginalName(), FILTER_SANITIZE_URL);
    			$file->move(public_path('files'), $filename);
    			$payload = [
    				'filename'=>$filename,
    				'bytes'=>$file->getClientSize(),
    				'mime'=>$file->getClientMimeType()
    			];
    			
    			if($request->has('id')) {
    				$attachments[$cnt++] = Board::find($request->id)->attachments()->create($payload);
    			} else {
    				$attachments[$cnt++] =  Attachment::create($payload);
    			}
    				\Log::debug('AttachmentsController store', ['stpe'=>5]);
    		}
    		*/
    		$filename = /*str_random().*/filter_var($file->getClientOriginalName(), FILTER_SANITIZE_URL);
    		$bytes = $file->getSize();
            $user = \Auth::user();

            $path = public_path('files') . DIRECTORY_SEPARATOR .  $user->id;
            if (!File::isDirectory($path)) {
                \Log::debug('AttachmentsController store', ['stpe'=>2]);
                File::makeDirectory($path, 0777, true, true);
            }
            \Log::debug('AttachmentsController store', ['stpe'=>3]);
    		$file->move($path, $filename);
            \Log::debug('AttachmentsController store', ['stpe'=>4]);
    		$payload = [
    				'filename'=>$filename,
    				'bytes'=> $bytes,
    				'mime'=>$file->getClientMimeType()
    			];
    			
    		if($request->has('id')) {
    				$attachment = Board::find($request->id)->attachments()->create($payload);
    		} else {
    				$attachment =  Attachment::create($payload);
    		}
    	}
    	\Log::debug('AttachmentsController store', ['stpe'=>7]);

    	return response()->json($attachment, 200);
    }

    public function destroy() {

    }
}
