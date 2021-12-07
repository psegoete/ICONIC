<?php

namespace CreatyDev\Http\api;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\tuningType;
use CreatyDev\Domain\ReadMethod;
use CreatyDev\Domain\FileService;
use CreatyDev\Domain\Gearboxe;
use CreatyDev\Domain\FileShareCredit;
use CreatyDev\Domain\TuningOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Domain\UserTuningCredit;
use Symfony\Component\DomCrawler\Form;
use Illuminate\Support\Facades\Mail;
use CreatyDev\Domain\Company\Models\Company;
use CreatyDev\Domain\Transaction;
use CreatyDev\Domain\UserDevice;
use CreatyDev\Domain\DeliveryTime;
use CreatyDev\Domain\MailHistory;
use CreatyDev\Domain\UserCompanyCredit;
use CreatyDev\Domain\Ticket\Models\Ticket;
use Illuminate\Support\Facades\Validator;




class FileServicesController extends Controller
{
    public function index(Request $request)
    {
        if (auth('api')->user()->role == 'admin') {
            $open = FileService::where([['status', '=', 'open'], ['company_id', '=', auth('api')->user()->company_id]])->count();
            $waiting = FileService::where([['status', '=', 'waiting'], ['company_id', '=', auth('api')->user()->company_id]])->count();
            $completed = FileService::where([['status', '=', 'completed'], ['company_id', '=', auth('api')->user()->company_id]])->count();
            $all = FileService::where([['company_id', '=', auth('api')->user()->company_id]])->count();
            if ($request->input('search')) {
                $file_services =  FileService::where([['file_services.company_id', '=', auth('api')->user()->company_id], ['file_services.status', '=', $request->input('search')]])
                    ->leftJoin('tickets', 'tickets.file_service_id', '=', 'file_services.id')
                    ->select(
                        'file_services.id',
                        'file_services.make',
                        'file_services.model',
                        'file_services.generation',
                        'file_services.engine',
                        'file_services.id',
                        'file_services.ecu',
                        'file_services.status',
                        'file_services.timeframe',
                        'file_services.created_at',
                        'file_services.updated_at',
                        'tickets.file_service_id'
                    )
                    ->orderByRaw('file_services.updated_at desc')
                    ->get();
            } else {
                $file_services =  FileService::where([['file_services.company_id', '=', auth('api')->user()->company_id]])
                    ->leftJoin('tickets', 'tickets.file_service_id', '=', 'file_services.id')
                    ->select(
                        'file_services.id',
                        'file_services.make',
                        'file_services.model',
                        'file_services.generation',
                        'file_services.engine',
                        'file_services.id',
                        'file_services.ecu',
                        'file_services.status',
                        'file_services.timeframe',
                        'file_services.created_at',
                        'file_services.updated_at',
                        'tickets.file_service_id'
                    )
                    ->orderByRaw('file_services.updated_at desc')
                    ->get();
            }

            return response()->json(['file_services' => $file_services, 'open_file_services' => $open, 'wating_file_services' => $waiting, 'completed_file_services' => $completed, 'all_file_services' => $all], 200);
        }

        if (auth('api')->user()->role == 'customer') {
            $open = FileService::where([['status', '=', 'open'], ['company_id', '=', auth('api')->user()->company_id], ['file_services.user_id', '=', auth('api')->user()->id]])->count();
            $waiting = FileService::where([['status', '=', 'waiting'], ['company_id', '=', auth('api')->user()->company_id], ['file_services.user_id', '=', auth('api')->user()->id]])->count();
            $completed = FileService::where([['status', '=', 'completed'], ['company_id', '=', auth('api')->user()->company_id], ['file_services.user_id', '=', auth('api')->user()->id]])->count();
            $all = FileService::where([['company_id', '=', auth('api')->user()->company_id], ['file_services.user_id', '=', auth('api')->user()->id]])->count();
            if ($request->input('search')) {
                $file_services =  DB::table('file_services')->where([['file_services.company_id', '=', auth('api')->user()->company_id], ['file_services.user_id', '=', auth('api')->user()->id], ['file_services.status', '=', $request->input('search')]])
                    ->leftJoin('tickets', 'tickets.file_service_id', '=', 'file_services.id')
                    ->select(
                        'file_services.id',
                        'file_services.make',
                        'file_services.model',
                        'file_services.generation',
                        'file_services.engine',
                        'file_services.id',
                        'file_services.ecu',
                        'file_services.status',
                        'file_services.timeframe',
                        'file_services.created_at',
                        'file_services.updated_at',
                        'tickets.ticket_id',
                        'file_services.vin',
                        'file_services.dynograph',
                        'file_services.dynograph_title',
                        'file_services.modified',
                        'file_services.modified_title',
                        'file_services.status'
                    )
                    ->get();
            } else {

                $file_services =  DB::table('file_services')->where([['file_services.company_id', '=', auth('api')->user()->company_id], ['file_services.user_id', '=', auth('api')->user()->id]])
                    ->leftJoin('tickets', 'tickets.file_service_id', '=', 'file_services.id')
                    ->select(
                        'file_services.id',
                        'file_services.make',
                        'file_services.model',
                        'file_services.generation',
                        'file_services.engine',
                        'file_services.id',
                        'file_services.ecu',
                        'file_services.status',
                        'file_services.timeframe',
                        'file_services.created_at',
                        'file_services.updated_at',
                        'tickets.ticket_id',
                        'file_services.vin',
                        'file_services.dynograph',
                        'file_services.dynograph_title',
                        'file_services.modified',
                        'file_services.modified_title',
                        'file_services.status'
                    )
                    ->get();

                    $file_services1 =  DB::table('file_services')->where([['file_services.company_id', '=', auth('api')->user()->company_id], ['file_services.status', '=', 'Completed'],['file_services.user_id', '=', auth('api')->user()->id]])
            ->select(DB::raw("CONCAT_WS('-',MONTH(file_services.created_at),YEAR(file_services.created_at)) as monthyear"), DB::raw('COUNT(file_services.id) as total_files'))
            ->groupBy('monthyear')
            ->get();

            $category = [];
            $data = [];

            for ($i = 0; $i < $file_services1->count(); $i++) {
                $category[$i] = \Carbon\Carbon::parse()->month(explode("-",$file_services1[$i]->monthyear)[0])->format('M').'-'.\Carbon\Carbon::parse()->year(explode("-",$file_services1[$i]->monthyear)[1])->format('Y');
                $data[$i] = $file_services1[$i]->total_files;
            }

            }
            return response()->json(['file_services' => $file_services, 'open_file_services' => $open, 'wating_file_services' => $waiting, 'completed_file_services' => $completed, 'all_file_services' => $all,'category' => $category,'data' => $data], 200);
        }
    }

    public function tickitFileService()
    {
        if (auth('api')->user()->role == 'customer') {
            $file_services =  FileService::where([['company_id', '=', auth('api')->user()->company_id]])->whereIn('user_id', [auth('api')->user()->id])->orderBy('updated_at', 'desc')->get();
            return response()->json(['file_services' => $file_services]);
        }
    }

    public function customerFileservice(Request $request, $id)
    {


        if (auth('api')->user()->role == 'admin') {
            $file_services =  DB::table('file_services')->where([['file_services.user_id', '=', $id], ['file_services.company_id', '=', auth('api')->user()->company_id]])
                ->leftJoin('tickets', 'tickets.file_service_id', '=', 'file_services.id')
                ->select(
                    'file_services.id',
                    'file_services.make',
                    'file_services.model',
                    'file_services.generation',
                    'file_services.engine',
                    'file_services.id',
                    'file_services.ecu',
                    'file_services.status',
                    'file_services.timeframe',
                    'file_services.created_at',
                    'tickets.file_service_id',
                    'file_services.vin',
                    'file_services.dynograph',
                    'file_services.dynograph_title',
                    'file_services.modified',
                    'file_services.modified_title',
                    'file_services.status'
                )
                ->get();

            $customer = User::where([['id', '=', $id], ['company_id', '=', checkDomain()]])->firstOrFail();

            return response()->json(['file_services' => $file_services, 'customer' => $customer, 'user_id' => $id], 200);
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tuning_types =  tuningType::where('company_id', '=', auth('api')->user()->company_id)->get();
        $readmethods =  ReadMethod::where('company_id', '=', auth('api')->user()->company_id)->get();
        $gearboxes =  Gearboxe::where('company_id', '=', auth('api')->user()->company_id)->get();

        if (DeliveryTime::where('company_id', '=', auth('api')->user()->company_id)->count()) {
            $deliveryTime = DeliveryTime::where('company_id', '=', auth('api')->user()->company_id)->firstOrFail();
        } else {
            $deliveryTime = 0;
        }
        return response()->json(['tuning_types' => $tuning_types, 'readmethods' => $readmethods, 'gearboxes' => $gearboxes, 'deliveryTime' => $deliveryTime], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json($request->input());

        $validate = Validator::make($request->all(), [
            'make' => 'required',
            'model' => 'required',
            'generation' => 'required',
            'engine' => 'required',
            'ecu' => 'required',
            'engine_hp' => 'required',
            'engine_kw' => 'required',
            'year' => 'required',
            'gearbox' => 'required',
            'license_plate' => 'required',
            'vin' => 'required',
            'read_method' => 'required',
            'tuning_type' => 'required',
            'timeframe' => 'required',
            'dyno' => 'required',
            'file_to_modify' => 'required',

        ]);

        if ($validate->errors()->count()) {
            return response()->json(['errors' => $validate->errors()], 401);
        }

        // return response()->json($request->input('tuning_options'), 200);

        $tuning_options = '';

        // if ($request->input('tuning_options')) {
        //     $tuning_options = implode(', ', $request->input('tuning_options'));
        // }

        $chargedCredits = 0;
        $tuningType = tuningType::where([['id', '=', $request->input('tuning_type')], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $gearbox = Gearboxe::where([['id', '=', $request->input('gearbox')], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $chargedCredits = $chargedCredits + $tuningType->credits;

        if ($request->input('tuning_options')) {
            foreach ($request->input('tuning_options') as $key => $value) {
                $tuningOption = TuningOption::where([['id', '=', $value], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
                $chargedCredits = $chargedCredits + $tuningOption->credits;
                $tuning_options = $tuning_options . ',' . $value;
            }
        }

        $file_service = new FileService([
            'make' => $request->input('make'),
            'model' => preg_split("/--/", $request->input('model'))[0],
            'generation' => preg_split("/--/", $request->input('generation'))[0],
            'engine' => preg_split("/\//", $request->input('engine'))[0],
            'ecu' => $request->input('ecu'),
            'engine_hp' => $request->input('engine_hp'),
            'engine_kw' => $request->input('engine_kw'),
            'year' => $request->input('year'),
            'gearbox' => $gearbox->id,
            'license_plate' => $request->input('license_plate'),
            'vin' => $request->input('vin'),
            'fuel_octane_rating' => $request->input('fuel_octane_rating'),
            'read_method' => $request->input('read_method'),
            'tuning_type' => $request->input('tuning_type'),
            'tuning_options' => $request->input('tuning_options'),
            'file_to_modify' => $request->file('file_to_modify')->hashName(),
            'file_to_modify_title' => $request->file('file_to_modify')->getClientOriginalName(),
            'timeframe' => $request->input('timeframe'),
            'dyno' => $request->input('dyno'),
            'dyno' => $request->input('timeframe'),
            'info' => $request->input('info'),
            'company_id' => auth('api')->user()->company_id,
            'user_id' => auth('api')->user()->id,
            'status' => 'Open',
            'credits' => $chargedCredits,
            'tuning_options' => $tuning_options,
        ]);



        if ($request->file('file_to_modify')) {
            // $request->file('file_to_modify')->store('public/uploads');
            $name = $request->file('file_to_modify')->hashName();
            $request->file('file_to_modify')->move(base_path('public/uploads'), $name);
            $file_service->file_to_modify = $name;
            $file_service->file_to_modify_title = $request->file('file_to_modify')->getClientOriginalName();
        } else {
            return response()->json(['error' => 'The file is required.'], 401);
        }

        $userCredits = UserTuningCredit::where([['company_id', '=', auth('api')->user()->company_id], ['user_id', '=', auth('api')->user()->id]])->firstOrFail();

        if ($userCredits->credits >= $chargedCredits) {
            $userCredits->credits = $userCredits->credits - $chargedCredits;
        } else {
            return response()->json(['error' => 'You have insufficient credits. Please buy credits.'], 401);
        }

        if (companyPlan() != 'enterprice') {
            $credits = UserCompanyCredit::where([['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
            $credits->credits = $credits->credits - 1;
            $credits->save();
        }

        $file_service->save();
        $userCredits->save();

        $transaction = new Transaction([
            'credits' => '-' . $chargedCredits,
            'description' => 'File-service ' . $file_service->make . ' ' . $file_service->model . ' ' . $file_service->generation . ' ' . $file_service->engine,
            'status' => 'Completed',
            'user_id' => auth('api')->user()->id,
            'company_id' => auth('api')->user()->company_id,
        ]);
        $transaction->save();

        $company = Company::where('id', '=', auth('api')->user()->company_id)->firstOrFail();
        $customer = User::where([['id', '=', auth('api')->user()->id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $admin = User::where([['role', '=', 'admin'], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();

        $data = [
            'company_name' => $company->company_name,
            'admin_name' =>  $admin->name,
            'admin_email' =>  $admin->email,
            'name' =>  $customer->name,
            'email' =>  $customer->email,
            'id' =>  $file_service->id,
            'from' => $company->company_email,
            'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
            'car' =>  $file_service->make . ' ' . $file_service->model . ' ' . $file_service->generation . ' ' . $file_service->engine,
        ];



        Mail::send('emails.new_file_service', ['data' => $data], function ($m) use ($data) {
            $m->from($data['from'], $data['company_name']);

            $m->to($data['admin_email'], $data['company_name'])->subject('New file service has been submitted');
        });

        $devices = UserDevice::where([['user_id', '=', $admin->id], ['company_id', '=', checkDomain()]])->get();

        foreach ($devices as $key => $value) {
            pushNotification($value->device_id, 'New file service has been submitted', auth()->user()->name . ' - ' . $data['car']);
        }

        $mail_history = new MailHistory([
            'seen' => 0,
            'from' => $company->company_email,
            'user_id' => $admin->id,
            'file_service_id' => $file_service->id,
            // 'ticket_id' => checkDomain(),
            'subject' => 'New file service has been submitted',
            'email_type' => 'new_file_service',
            // 'sent' => checkDomain(),
            // 'amount' => checkDomain(),
            'company_id' => auth('api')->user()->company_id,
            // 'token' => checkDomain(),
        ]);
        $mail_history->save();



        return response()->json(['success' => 'Successfully created new file service'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file_service = FileService::where([['id', '=', $id], ['user_id', auth('api')->user()->id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        return response()->json(['file_service' => $file_service], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $file_servic = FileService::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $customer = User::where([['id', '=', $file_servic->user_id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $tuning_type =  tuningType::where([['id', '=', $file_servic->tuning_type]])->first();
        $tuning_optionsArray = array();

        if ($file_servic->tuning_options) {
            foreach (explode(',', $file_servic->tuning_options) as $array) {
                array_push($tuning_optionsArray, (int)$array);
            }
        }

        $tuning_options =  DB::table('tuning_options')->whereIn('id', $tuning_optionsArray)->get();

        $readmethod =  ReadMethod::where([['id', '=', $file_servic->read_method]])->first();
        $gearbox =  Gearboxe::where([['id', '=', $file_servic->gearbox]])->first();
        $gearboxes = Gearboxe::where([['company_id', '=', auth('api')->user()->company_id]])->get();
        $readmethods =  ReadMethod::where([['company_id', '=', auth('api')->user()->company_id]])->get();
        $tuning_types =  tuningType::where([['company_id', '=', auth('api')->user()->company_id]])->get();
        // $tuning_options =  TuningOption::all();

        if (auth('api')->user()->role == 'admin') {
            $file_service = FileService::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
            // return response()->json(['tuning_types' => $tuning_types,'tuning_type' => $tuning_type,'readmethods' => $readmethods,'readmethod' => $readmethod,'gearboxes' => $gearboxes,'gearbox' => $gearbox,'file_service' => $file_service,'customer' => $customer,'tuning_options' => $tuning_options],200);
            // return view('file_services.edit',  compact(['tuning_types'], ['tuning_type'], ['readmethods'], ['readmethod'], ['gearboxes'], ['gearbox'], ['file_service'], ['customer'], ['tuning_options']));
        } else {
            $file_service = FileService::where([['id', '=', $id], ['user_id', auth('api')->user()->id]])->firstOrFail();
            // return view('file_services.customeredit',  compact(['tuning_types'], ['tuning_type'], ['readmethods'], ['readmethod'], ['gearboxes'], ['gearbox'], ['file_service'], ['customer'], ['tuning_options']));
        }
        return response()->json(['tuning_types' => $tuning_types, 'tuning_type' => $tuning_type, 'readmethods' => $readmethods, 'readmethod' => $readmethod, 'gearboxes' => $gearboxes, 'gearbox' => $gearbox, 'file_service' => $file_service, 'customer' => $customer, 'tuning_options' => $tuning_options], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $file_service = FileService::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $file_service_test = FileService::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        if (Auth::user()->role == 'customer') {
            $validate = Validator::make($request->all(), [
                'make' => 'required',
                'model' => 'required',
                'generation' => 'required',
                'engine' => 'required',
                'ecu' => 'required',
                'engine_hp' => 'required',
                'engine_kw' => 'required',
                'year' => 'required',
                'gearbox' => 'required',
                'license_plate' => 'required',
                'vin' => 'required',
                'read_method' => 'required',
                'tuning_type' => 'required',
                'timeframe' => 'required',
                'dyno' => 'required',
            ]);

            if ($validate->errors()->count()) {
                return response()->json(['errors' => $validate->errors()], 401);
            }
        }

        $customer = User::where([['id', '=', $file_service->user_id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $company = Company::where('id', '=', auth('api')->user()->company_id)->firstOrFail();

        $file_service->fill($request->all());

        if ($request->file('file_to_modify')) {
            $name = $request->file('file_to_modify')->hashName();
            $request->file('file_to_modify')->move(base_path('public/uploads'), $name);
            $file_service->file_to_modify = $name;
            $file_service->file_to_modify_title = $request->file('file_to_modify')->getClientOriginalName();
        }

        if ($request->file('original_file')) {
            // $request->file('original_file')->store('public/uploads');
            $name = $request->file('original_file')->hashName();
            $request->file('original_file')->move(base_path('public/uploads'), $name);

            $file_service->file_to_modify = $name;
            $file_service->file_to_modify_title = $request->file('original_file')->getClientOriginalName();

            if (companyPlan() != 'enterprice') {
                $credits = FileShareCredit::where([['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
                if (Auth::user()->role == 'admin') {
                    if ($credits->credits < 1) {
                        return response()->json(['error' => 'Insufficient sharing credits. Please buy sharing credits.'], 401);
                    }
                }
                $credits->credits = $credits->credits - 1;
                $credits->save();
            }
        }

        if ($request->file('modified_file')) {
            $request->file('modified_file')->store('public/uploads');
            $name = $request->file('modified_file')->hashName();
            // $request->file('file_to_modify')->store('public/uploads');
            $request->file('modified_file')->move(base_path('public/uploads'), $name);
            $file_service->modified = $name;
            $file_service->modified_title = $request->file('modified_file')->getClientOriginalName();
            $file_service->status = 'Completed';
            $file_service->downloaded_file_service = 0;



            if (companyPlan() != 'enterprice') {
                $credits = FileShareCredit::where([['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
                if (Auth::user()->role == 'admin') {
                    if ($credits->credits < 1) {
                        return response()->json(['error' => 'Insufficient sharing credits. Please buy sharing credits.'], 401);
                    }
                }
                $credits->credits = $credits->credits - 1;
                $credits->save();
            }

            if ($request->file('dynograph_file')) {
                // $request->file('dynograph_file')->store('public/uploads');
                $name = $request->file('dynograph_file')->hashName();
                $request->file('dynograph_file')->move(base_path('public/uploads'), $name);
                $file_service->dynograph = $name;
                $file_service->dynograph_title = $request->file('dynograph_file')->getClientOriginalName();

                if (companyPlan() != 'enterprice') {
                    $credits = FileShareCredit::where([['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
                    if (Auth::user()->role == 'admin') {
                        if ($credits->credits < 1) {
                            return response()->json(['error' => 'Insufficient sharing credits. Please buy sharing credits.'], 401);
                        }
                    }
                    $credits->credits = $credits->credits - 1;
                    $credits->save();
                }
            }

            if (($request->input('status') == 'Open' || $request->input('status') == 'Waiting')) {
                $data = [
                    'company_name' => $company->company_name,
                    'name' =>  $customer->name,
                    'email' =>  $customer->email,
                    'from' => $company->company_email,
                    'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
                    'car' =>  $file_service->make . ' ' . $file_service->model . ' ' . $file_service->generation . ' ' . $file_service->engine,
                ];

                Mail::send('emails.completed_file_service', ['data' => $data], function ($m) use ($data) {
                    $m->from($data['from'], $data['company_name']);

                    $m->to($data['email'], $data['company_name'])->subject('Your file service is ready!');
                });

                $devices = UserDevice::where([['user_id', '=', $customer->id], ['company_id', '=', checkDomain()]])->get();

                foreach ($devices as $key => $value) {
                    pushNotification($value->device_id, 'Your file service is ready!', auth()->user()->ticket_display_name . ' - ' . $data['car']);
                }

                $mail_history = new MailHistory([
                    'seen' => 0,
                    'from' => $company->company_email,
                    'user_id' => $file_service->user_id,
                    'file_service_id' => $file_service->id,
                    // 'ticket_id' => checkDomain(),
                    'subject' => 'Your file service is ready!',
                    'email_type' => 'completed_file_service',
                    // 'sent' => checkDomain(),
                    // 'amount' => checkDomain(),
                    'company_id' => auth('api')->user()->company_id,
                    // 'token' => checkDomain(),
                ]);
                $mail_history->save();
            }
        }

        if (($file_service_test->status == 'Open' || $file_service_test->status == 'Waiting') && $request->input('status') == 'Completed') {
            $data = [
                'company_name' => $company->company_name,
                'name' =>  $customer->name,
                'email' =>  $customer->email,
                'from' => $company->company_email,
                'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
                'car' =>  $file_service->make . ' ' . $file_service->model . ' ' . $file_service->generation . ' ' . $file_service->engine,
            ];

            Mail::send('emails.completed_file_service', ['data' => $data], function ($m) use ($data) {
                $m->from($data['from'], $data['company_name']);

                $m->to($data['email'], $data['company_name'])->subject('Your file service is ready!');
            });

            $devices = UserDevice::where([['user_id', '=', $customer->id], ['company_id', '=', checkDomain()]])->get();

                foreach ($devices as $key => $value) {
                    pushNotification($value->device_id, 'Your file service is ready!', auth()->user()->ticket_display_name . ' - ' . $data['car']);
                }
            $mail_history = new MailHistory([
                'seen' => 0,
                'from' => $company->company_email,
                'user_id' => $file_service->user_id,
                'file_service_id' => $file_service->id,
                // 'ticket_id' => checkDomain(),
                'subject' => 'Your file service is ready!',
                'email_type' => 'completed_file_service',
                // 'sent' => checkDomain(),
                // 'amount' => checkDomain(),
                'company_id' => auth('api')->user()->company_id,
                // 'token' => checkDomain(),
            ]);
            $mail_history->save();
        }

        $file_service->save();

        return response()->json(['success' => 'file services updated successfully.'], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->role == 'admin') {
            $file_service = FileService::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();

            if ($file_service->status != 'Completed') {
                $userCredits = UserTuningCredit::where([['company_id', '=', auth('api')->user()->company_id], ['user_id', '=', $file_service->user_id]])->firstOrFail();
                $userCredits->credits = $userCredits->credits + $file_service->credits;
                $userCredits->save();

                $transaction = new Transaction([
                    'credits' => $file_service->credits,
                    'description' => 'Reversed credits',
                    'status' => 'Completed',
                    'user_id' => $file_service->user_id,
                    'company_id' => auth('api')->user()->company_id,
                ]);
                $transaction->save();
            }

            Ticket::where([['file_service_id', '=', $file_service->id], ['company_id', '=', auth('api')->user()->company_id]])->delete();
            $file_service->delete();

            return response()->json(['success' => 'file services deleted successfully.'], 403);
        }
    }
    public function refund($id)
    {
        if (Auth::user()->role == 'admin') {
            $file_service = FileService::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();


            $userCredits = UserTuningCredit::where([['company_id', '=', auth('api')->user()->company_id], ['user_id', '=', $file_service->user_id]])->firstOrFail();
            $userCredits->credits = $userCredits->credits + $file_service->credits;
            $userCredits->save();

            $transaction = new Transaction([
                'credits' => $file_service->credits,
                'description' => 'Reversed credits',
                'status' => 'Completed',
                'user_id' => $file_service->user_id,
                'company_id' => auth('api')->user()->company_id,
            ]);
            $transaction->save();

            Ticket::where([['file_service_id', '=', $file_service->id], ['company_id', '=', auth('api')->user()->company_id]])->delete();
            $file_service->delete();

            return response()->json(['success' => 'file services successfully refunded.'], 403);
        }
    }
}
