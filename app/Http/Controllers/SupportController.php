<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Redirect;
use GuzzleHttp\Client;
use Mail;
class SupportController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}
	
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
			return view('support.create',['title'=>'Create a new Ticket']);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//
		$ticket_title = $request->input('ticket_title');
		$ticket_message = $request->input('ticket_message');
		 $this->validate($request, [
        'ticket_title' => 'required|max:255|min:4',
        'ticket_message' => 'required',
    ]);
		$this->send_email($ticket_title,$ticket_message);

		
		return Redirect::to('support/create')->with('message', 'Ticket created: '.$ticket_title);
	}
	private function send_email($ticket_title,$ticket_message){
				Mail::send('emails.ticket_create', ['ticket_message'=>$ticket_message], function($message) use ($ticket_title, $ticket_message)
					{
						$value = session('user');
						$message->from($value['email'], $value['username']);
						$message->to('support@dragplus.com')->subject($ticket_title);
					});
	}

	
}
