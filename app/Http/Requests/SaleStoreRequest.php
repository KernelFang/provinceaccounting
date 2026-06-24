<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'issue_date' => ['required','date'],
            'issued_portal' => ['required','string','exists:portals,name'],
            'service_type' => ['required','string','exists:service_types,name'],
            'gds_pnr' => ['nullable','string','max:191'],
            'airline_pnr' => ['nullable','string','max:191'],
            'agent_fare' => ['required','numeric','regex:/^\d{1,8}(\.\d{1,2})?$/','min:0'],
            'customer_fare' => ['required','numeric','regex:/^\d{1,8}(\.\d{1,2})?$/','min:0'],
            'customer_payment' => ['nullable','numeric'],
            'segment' => ['nullable','string','max:191'],
            'last_date_of_payment' => ['nullable','date'],
            'airline' => ['nullable','string','exists:airlines,name'],
            'flight_type' => ['nullable','string','exists:flight_types,name'],
            'trip' => ['nullable','string','exists:trips,name'],
            'pax_name' => ['nullable','string','max:191'],
            'tkt_number' => ['nullable','string','max:191'],
            'passport_nid' => ['nullable','string','max:191'],
            'flight_date' => ['nullable','date'],
            'return_date' => ['nullable','date','after_or_equal:flight_date'],
            'flight_status' => ['nullable', 'string', 'in:pending,inprogress,completed,reissued,refunded,cancelled'],
            'top_balance' => ['nullable','numeric'],
            'current_balance' => ['nullable','numeric'],
            'agent_price' => ['nullable','numeric'],
            'sell_price' => ['nullable','numeric'],
            'profit' => ['nullable','numeric'],
            'segment_fare' => ['nullable','numeric'],
            'contact_no' => ['nullable','string','max:50'],
            'customer_name' => ['nullable','string','max:191'],
            'customer_phone' => ['nullable','string','max:50'],
            'customer_due' => ['nullable','numeric'],
            'description' => ['nullable','string','max:1000'],
            'images' => ['nullable','array'],
            'images.*' => ['file','image','max:5120'],
            'videos' => ['nullable','array'],
            'videos.*' => ['file','mimetypes:video/mp4,video/quicktime,video/x-msvideo','max:51200'],
            'documents' => ['nullable','array'],
            'documents.*' => ['file','mimes:pdf,doc,docx,xls,xlsx','max:10240'],
            'links' => ['nullable','string','max:2000'],
        ];
    }
}
