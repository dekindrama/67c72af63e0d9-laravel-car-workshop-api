<?php

namespace App\Http\Controllers\Admin\Repair;

use App\Entities\OwnerEntity;
use App\Entities\ServiceEntity;
use App\Entities\SummaryInvoiceEntity;
use App\Enums\RepairStatusEnum;
use App\Helpers\RepairInvoiceHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Repair\RepairInvoiceDetailResource;
use App\Mail\Admin\Repair\InvoiceMail;
use App\Models\Repair;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class RepairInvoiceController extends Controller
{
    function store(int $id) : JsonResponse {
        $repair = Repair::query()
            ->with('owner', 'car', 'jobs', 'jobs.service')
            ->where('id', $id)
            ->where('status', RepairStatusEnum::COMPLETED)
            ->first();
        abort_if($repair == null, Response::HTTP_NOT_FOUND, 'repair not found');

        $invoice = $repair->invoice;
        abort_if($invoice, Response::HTTP_BAD_REQUEST, 'invoice already exist');

        $summary = RepairInvoiceHelper::setSummary($repair);
        $storedInvoice = $repair->invoice()->create([
            'summary' => $summary->toJsonString(),
            'paid_at' => now(),
        ]);

        return response()->json([
            'message' => 'success to store repair invoice',
            'data' => [
                'invoice' => RepairInvoiceDetailResource::make($storedInvoice),
            ],
        ], Response::HTTP_CREATED);
    }

    function show(int $id) : JsonResponse {
        $repair = Repair::query()
            ->with('invoice')
            ->where('id', $id)
            ->where('status', RepairStatusEnum::COMPLETED)
            ->first();
        abort_if($repair == null, Response::HTTP_NOT_FOUND, 'repair not found');

        $invoice = $repair->invoice;
        abort_if($invoice == null, Response::HTTP_NOT_FOUND, 'invoice not found');

        return response()->json([
            'message' => 'success to get repair invoice',
            'data' => [
                'invoice' => RepairInvoiceDetailResource::make($invoice),
            ],
        ], Response::HTTP_OK);
    }

    function send(int $id) : JsonResponse {
        $repair = Repair::query()
            ->with('invoice')
            ->where('id', $id)
            ->where('status', RepairStatusEnum::COMPLETED)
            ->first();
        abort_if($repair == null, Response::HTTP_NOT_FOUND, 'repair not found');

        $invoice = $repair->invoice;
        abort_if($invoice == null, Response::HTTP_NOT_FOUND, 'invoice not found');

        $summaryInvoice = SummaryInvoiceEntity::make()->fromJsonString($invoice->summary);

        Mail::queue(new InvoiceMail($summaryInvoice));

        return response()->json([
            'message' => 'success to send repair invoice',
        ], Response::HTTP_OK);
    }
}
