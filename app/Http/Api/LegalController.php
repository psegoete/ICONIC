<?php

namespace CreatyDev\Http\api;
use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Company\Models\Company;
use CreatyDev\Domain\LegalDocument;


class LegalController extends Controller
{
    public function disclaimer(){
        $legalDocument = LegalDocument::where('company_id', '=', checkDomain())->firstOrFail();
        return view('legal_documents.disclaimer', compact('legalDocument'));
    }

    public function privacy_policy(){
        $legalDocument = LegalDocument::where('company_id', '=', checkDomain())->firstOrFail();
        return view('legal_documents.privacy_policy', compact('legalDocument'));
    }

    public function refund_policy(){
        $legalDocument = LegalDocument::where('company_id', '=', checkDomain())->firstOrFail();
        return view('legal_documents.refund_policy', compact('legalDocument'));
    }
    public function terms_and_conditions(){
        $legalDocument = LegalDocument::where('company_id', '=', checkDomain())->firstOrFail();
        return view('legal_documents.terms_and_conditions', compact('legalDocument'));
    }
}
