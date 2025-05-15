<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateEmailSenderRequest;
use App\Http\Requests\UpdateEmailSenderRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\EmailSender;
use Illuminate\Http\Request;
use Flash;
use Response;

class EmailSenderController extends AppBaseController
{
    /**
     * Display a listing of the EmailSender.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var EmailSender $emailSenders */
        $emailSenders = EmailSender::paginate(10);

        return view('email_senders.index')
            ->with('emailSenders', $emailSenders);
    }

    /**
     * Show the form for creating a new EmailSender.
     *
     * @return Response
     */
    public function create()
    {
        return view('email_senders.create');
    }

    /**
     * Store a newly created EmailSender in storage.
     *
     * @param CreateEmailSenderRequest $request
     *
     * @return Response
     */
    public function store(CreateEmailSenderRequest $request)
    {
        $input = $request->all();

        /** @var EmailSender $emailSender */
        $emailSender = EmailSender::create($input);

        Flash::success('Email Sender saved successfully.');

        return redirect(route('emailSenders.index'));
    }

    /**
     * Display the specified EmailSender.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var EmailSender $emailSender */
        $emailSender = EmailSender::find($id);

        if (empty($emailSender)) {
            Flash::error('Email Sender not found');

            return redirect(route('emailSenders.index'));
        }

        return view('email_senders.show')->with('emailSender', $emailSender);
    }

    /**
     * Show the form for editing the specified EmailSender.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var EmailSender $emailSender */
        $emailSender = EmailSender::find($id);

        if (empty($emailSender)) {
            Flash::error('Email Sender not found');

            return redirect(route('emailSenders.index'));
        }

        return view('email_senders.edit')->with('emailSender', $emailSender);
    }

    /**
     * Update the specified EmailSender in storage.
     *
     * @param int $id
     * @param UpdateEmailSenderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEmailSenderRequest $request)
    {
        /** @var EmailSender $emailSender */
        $emailSender = EmailSender::find($id);

        if (empty($emailSender)) {
            Flash::error('Email Sender not found');

            return redirect(route('emailSenders.index'));
        }

        $emailSender->fill($request->all());
        $emailSender->save();

        Flash::success('Email Sender updated successfully.');

        return redirect(route('emailSenders.index'));
    }

    /**
     * Remove the specified EmailSender from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var EmailSender $emailSender */
        $emailSender = EmailSender::find($id);

        if (empty($emailSender)) {
            Flash::error('Email Sender not found');

            return redirect(route('emailSenders.index'));
        }

        $emailSender->delete();

        Flash::success('Email Sender deleted successfully.');

        return redirect(route('emailSenders.index'));
    }
}
