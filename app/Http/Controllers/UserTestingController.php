<?php

namespace App\Http\Controllers;

use App\Models\UserTesting;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreUserTestingRequest;
use App\Http\Requests\UpdateUserTestingRequest;
use App\Models\Xls_OceanShipment;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserTestingController extends Controller
{ 
   /**
    * Display a listing of the resource.
    */
   public function index()
   {
       return view('excel-import');
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
       //
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(HttpRequest $request)
   {
       $request->validate([
           'file' => 'required|file|mimes:xls,xlsx,csv|max:10240'
       ], [
           'file.required' => "File harus dipilih",
           'file.mimes' => 'File harus berformat Excel (.xls, .xlsx) atau CSV.',
           'file.max' => 'Ukuran file maksimal 10MB.'
       ]);

       try {
           $file = $request->file('file');
           DB::beginTransaction();

           Excel::import(new UsersImport, $file);

           DB::commit();

           return back()->with('success' ,'Data Excel berhasil di Import kedalam Database!');
           
       } catch (ValidationException $e) {
           DB::rollBack();
           return back()->withErrors($e->errors())->withInput();
           
       } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
           DB::rollBack();
           return back()->withErrors(['file' => 'File Excel tidak dapat dibaca. Pastikan file tidak corrupt.']);
           
       } catch (\Exception $e) {
           DB::rollBack();
           return back()->withErrors(['file' => 'Error: ' . $e->getMessage()]);
       }
   }

   /**
    * Display the specified resource.
    */
   public function show(Xls_OceanShipment $userTesting)
   {
       //
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit(Xls_OceanShipment $userTesting)
   {
       //
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(UpdateUserTestingRequest $request, Xls_OceanShipment $userTesting)
   {
       //
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(Xls_OceanShipment $userTesting)
   {
       //
   }

   public function import(){
       try {
           DB::beginTransaction();
           Excel::import(new UsersImport, storage_path('app/123.xlsx'));
           DB::commit();
           return redirect('/dashboard-db')->with('success', 'All good!');
       } catch (\Exception $e) {
           DB::rollback();
           return redirect('/dashboard-db')->withErrors(['error' => $e->getMessage()]);
       }
   }

   public function downloadTemplate()
{
    $filePath = storage_path('app/123.xlsx');
    
    if (!file_exists($filePath)) {
        return back()->withErrors(['error' => 'Template file not found.']);
    }
    
    return response()->download($filePath, 'Shipment_Import_Template.xlsx', [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ]);
}
}
