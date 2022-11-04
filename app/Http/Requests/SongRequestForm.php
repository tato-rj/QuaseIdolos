<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SongRequestForm extends FormRequest
{
    protected $liveGig, $message;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->liveGig = liveGig();

        return $this->isLive() && $this->isNotPaused() && $this->isNotFull() && $this->userCanMakeRequests();
    }

    public function isLive()
    {
        return $this->liveGig ? true 
             : $this->failWithMessage('Não estamos recebendo pedidos agora');
    }

    public function isNotPaused()
    {
        return ! $this->liveGig->isPaused() ? true 
             : $this->failWithMessage('Paramos por um momento, voltamos já');
    }

    public function isNotFull()
    {
        return ! $this->liveGig->isFull() ? true 
             : $this->failWithMessage('O limite de músicas desse set foi alcançado');
    }

    public function userCanMakeRequests()
    {
        return ! $this->liveGig->userLimitReached() ? true 
             : $this->failWithMessage('O seu limite de músicas foi alcançado');
    }

    public function rules()
    {
        return [];
    }

    public function failWithMessage($message)
    {
        $this->message = $message;

        return false;
    }

    public function failedAuthorization() {
        throw new \App\Exceptions\SetlistException($this->message, 403);
    }
}
