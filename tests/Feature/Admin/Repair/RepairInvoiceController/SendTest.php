<?php

namespace Tests\Feature\Admin\Repair\RepairInvoiceController;

use App\Entities\SummaryInvoiceEntity;
use App\Enums\RoleEnum;
use App\Mail\Admin\Repair\InvoiceMail;
use App\Models\Repair;
use App\Models\User;
use Database\Seeders\RepairWithInvoiceSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class SendTest extends TestCase
{
    use RefreshDatabase;

    public function test_show(): void
    {
        $this->seed([
            UserSeeder::class,
            ServiceSeeder::class,
            RepairWithInvoiceSeeder::class,
        ]);
        $repair = Repair::first();
        $admin = User::where('role', RoleEnum::ADMIN)->first();
        $carOwner = User::where('role', RoleEnum::CAR_OWNER)->first();
        $invoice = $repair->invoice;
        $summaryInvoice = SummaryInvoiceEntity::make()->fromJsonString($invoice->summary);

        $response = $this->actingAs($admin)->postJson(route('admin.repair.repair-invoice.send', $repair->id));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
            ]);
        $mailable = new InvoiceMail($summaryInvoice);
        $mailable->assertTo($carOwner->email);
    }
}
