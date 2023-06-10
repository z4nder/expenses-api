<?php

namespace App\Http\Controllers;

use App\Http\Requests\Expense\ExpenseStoreRequest;
use App\Http\Requests\Expense\ExpenseUpdateRequest;
use App\Http\Resources\ExpenseResource;
use App\Mail\ExpenseCreated;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ExpenseResource::collection(
            auth()->user()->expenses()->get()
        );
    }

    public function store(ExpenseStoreRequest $request): JsonResponse
    {
        $inputs = $request->validated();

        $expense = auth()->user()->expenses()->create($inputs);

        Mail::to(auth()->user())->send(
            (new ExpenseCreated($expense))
        );

        return response()->json(new ExpenseResource($expense), Response::HTTP_CREATED);
    }

    public function show(Expense $expense): ExpenseResource
    {
        $this->authorize('view', $expense);

        return new ExpenseResource($expense);
    }

    public function update(ExpenseUpdateRequest $request, Expense $expense): ExpenseResource
    {
        $this->authorize('view', $expense);

        $inputs = $request->validated();

        $expense->update($inputs);

        return new ExpenseResource($expense);
    }

    public function destroy(Expense $expense)
    {
        $this->authorize('view', $expense);

        $expense->delete();

        return response()->json(['message' => 'Expense deleted successfully']);
    }
}
