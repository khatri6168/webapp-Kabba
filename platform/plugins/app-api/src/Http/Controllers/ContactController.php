<?php

namespace Botble\AppApi\Http\Controllers;

use App\Imports\BulkImports;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Facades\Assets;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\Contact\Enums\ContactStatusEnum;
use Botble\Contact\Forms\ContactForm;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Botble\Contact\Models\ContactNote;
use Botble\Contact\Http\Requests\ContactReplyRequest;
use Botble\Contact\Http\Requests\EditContactRequest;
use Botble\Contact\Http\Requests\CreateContactRequest;
use Botble\Contact\Models\Contact;
use Botble\Contact\Repositories\Interfaces\ContactReplyInterface;
use Botble\Contact\Tables\ContactTable;
use Botble\Contact\Tables\ContactTags;
use Botble\Contact\Tables\CompanyList;
use Botble\Contact\Repositories\Interfaces\ContactInterface;
use Botble\Base\Facades\EmailHandler;
use Exception;
use Illuminate\Http\Request;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Contact\Exports\ContactExport;
use Botble\Contact\Models\Company;
use Botble\Ecommerce\Exports\TemplateProductExport;
use Twilio\Rest\Client;
use Botble\Ecommerce\Forms\CustomerForm;
use Illuminate\Support\Facades\Redirect;
use DB;
use File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Response;

class ContactController extends BaseController
{
    use HasDeleteManyItemsTrait;

    public function __construct(protected ContactInterface $contactRepository)
    {
    }

    public function AdminLogin(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(
                [
                    'message' => 'Invalid login details',
                ],
                401,
            );
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        //return $user;
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function CreateContactTags(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = $request->all();

        DB::table('contacttags')->insert($data);

        return response()->json([
            'errors' => [],
            'data' => $data,
            'message' => 'Tag Created successfully..',
            'success' => true,
        ], 200);

    }

    public function ContactTags()
    {
        $contacttags = DB::select('select * from contacttags');
        if (count($contacttags) > 0) {
            return response()->json(
                [
                    'errors' => [],
                    'data' => $contacttags,
                    'message' => 'Tags found successfully..',
                    'success' => true,
                ],
                200,
            );
        }

        return response()->json(
            [
                'errors' => [],
                'message' => 'Tags not found.',
                'data' => [],
                'success' => false,
            ],
            404,
        );
    }
}
