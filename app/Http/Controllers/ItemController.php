<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Item;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ItemsExport;
use App\Imports\ItemsImport;

class ItemController extends AppBaseController
{
    /**
     * Display a listing of the Item.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user_role = Auth::user()->user_role;
        $inv_permission = Auth::user()->inv_permission;

        /** @var Item $items */
        $items = Item::select('items.*', 'itemcategorys.name_bn as cat_name_bn', 'itemcategorys.name_en as cat_name_en')
            ->join('itemcategorys', 'items.cat_id', '=', 'itemcategorys.id');

        if ($user_role != 1) {
            $items = $items->where('items.dept_id', $inv_permission);
        }
        $items = $items->orderBy('itemcategorys.id', 'asc')->get();

        return view('items.index')
            ->with('items', $items);
    }

    /**
     * Show the form for creating a new Item.
     *
     * @return Response
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created Item in storage.
     *
     * @param CreateItemRequest $request
     *
     * @return Response
     */
    public function store(CreateItemRequest $request, \App\Services\BfdcAccountingService $accountingService)
    {
        $input = $request->all();

        /** @var Item $item */
        $item = Item::create($input);

        // Auto push rate card to Accounting on create
        try {
            $accountingService->pushRateCardToAccounting($item);
        } catch (\Throwable $e) {
            \Log::error('Auto push rate card failed on item create: ' . $e->getMessage());
        }

        Flash::success('Item saved and pushed to Rate Card successfully.');

        return redirect(route('items.index'));
    }

    /**
     * Manual push a single Item Rate Card to BFDC Accounting.
     */
    public function pushRateCardWeb($id, \App\Services\BfdcAccountingService $service)
    {
        if (Auth::guard('producer')->check()) {
            abort(403, 'অননুমোদিত অ্যাক্সেস। প্রযোজক এই কাজ করতে পারবেন না।');
        }

        $realId = decode_secure_hash_id($id) ?: $id;
        $item = Item::with('category')->find($realId);

        if (!$item) {
            Flash::error('Item not found.');
            return redirect()->back();
        }

        $result = $service->pushRateCardToAccounting($item);

        if (!empty($result['success'])) {
            Flash::success("Rate Card accounting-এ সফলভাবে পুশ করা হয়েছে (Section ID: " . ($result['data']['sectionDetailsId'] ?? 'N/A') . ")");
        } else {
            $msg = $result['error'] ?? ($result['data']['message'] ?? 'পুশ সম্পন্ন হতে সমস্যা হয়েছে।');
            Flash::error("Rate Card পুশ ব্যর্থ: {$msg}");
        }

        return redirect()->back();
    }

    /**
     * Batch push all existing items to Rate Card Accounting.
     */
    public function pushAllRateCardsWeb(\App\Services\BfdcAccountingService $service)
    {
        if (Auth::guard('producer')->check()) {
            abort(403, 'অননুমোদিত অ্যাক্সেস। প্রযোজক এই কাজ করতে পারবেন না।');
        }

        $items = Item::with('category')->get();
        $successCount = 0;
        $failCount = 0;

        foreach ($items as $item) {
            $res = $service->pushRateCardToAccounting($item);
            if (!empty($res['success'])) {
                $successCount++;
            } else {
                $failCount++;
            }
        }

        Flash::success("মোট {$successCount} টি আইটেম সফলভাবে Rate Card-এ পুশ করা হয়েছে।" . ($failCount > 0 ? " ({$failCount} টি ব্যর্থ)" : ""));
        return redirect()->back();
    }

    /**
     * Display the specified Item.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Item $item */
        $item = Item::find($id);

        if (empty($item)) {
            Flash::error('Item not found');

            return redirect(route('items.index'));
        }

        return view('items.show')->with('item', $item);
    }

    /**
     * Show the form for editing the specified Item.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Item $item */
        $item = Item::find($id);

        if (empty($item)) {
            Flash::error('Item not found');

            return redirect(route('items.index'));
        }

        return view('items.edit')->with('item', $item);
    }

    /**
     * Update the specified Item in storage.
     *
     * @param int $id
     * @param UpdateItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemRequest $request)
    {
        /** @var Item $item */
        $item = Item::find($id);

        if (empty($item)) {
            Flash::error('Item not found');

            return redirect(route('items.index'));
        }

        $item->fill($request->all());
        $item->save();

        Flash::success('Item updated successfully.');

        return redirect(route('items.index'));
    }

    /**
     * Remove the specified Item from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Item $item */
        $item = Item::find($id);

        if (empty($item)) {
            Flash::error('Item not found');

            return redirect(route('items.index'));
        }

        $item->delete();

        Flash::success('Item deleted successfully.');

        return redirect(route('items.index'));
    }

    public function export()
    {
        return Excel::download(new ItemsExport, 'items.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new ItemsImport, $request->file('file'));

        Flash::success('Items imported successfully.');

        return redirect(route('items.index'));
    }
}
