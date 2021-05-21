<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * @var BankAccount
     */
    protected $model;

    /**
     * BankAccountController constructor.
     * @param BankAccount $bankAccount
     */
    public function __construct(BankAccount $bankAccount)
    {
        $this->model = $bankAccount;
    }

    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index()
    {
        return response()->json($this->model->with('bank')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $request->validate([
            'financial_organization_id' => 'required|integer',
            'account_name' => 'required|string'
        ]);

        if ($request->has(['financial_organization_id', 'account_name'])) {
            try {
                $this->model->query()->create($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Bank account created'
                ], 201);
            } catch (\Exception $exception) {
                throw new \Exception($exception);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function show($id)
    {
        if (!$id) abort(403);

        try {
            $result = $this->model->query()->findOrFail($id);

            return response()->json([
                'status' => !!$result,
                'message' => 'Showing details of Bank account ID: ' . $id,
                'data' => $result ?? null
            ], 200);
        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        if (!$id) abort(403);

        try {
            $account = $this->model->query()->findOrFail($id);

            $result = $account->update($request->all());

            return response()->json([
                'status' => !!$result,
                'message' => 'Updated Bank account ID: ' . $id
            ], 200);
        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if (!$id) abort(403);

        try {
            $result = $this->model->destroy($id);

            return response()->json([
                'status' => !!$result,
                'message' => 'Deleted Bank account ID: ' . $id
            ], 200);
        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }
    }
}
