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
        $this->liveGig = auth()->user()->liveGig;

        if (auth()->user()->isAdmin() && $this->gigIsLive())
            return true;        

        return $this->gigIsLive() && 
               $this->gigIsNotPaused() && 
               $this->gigIsNotFull() && 
               $this->votingHasNotFinished() && 
               $this->userCanMakeRequests() &&
               $this->songNotYetRequestedByUser() &&
               $this->songCanBeRequestedAgain();
    }

    public function gigIsLive()
    {
        return $this->liveGig ? true 
             : $this->failWithMessage('Não estamos recebendo pedidos agora');
    }

    public function gigIsNotPaused()
    {
        return ! $this->liveGig->isPaused() ? true 
             : $this->failWithMessage('Paramos por um momento, voltamos já');
    }

    public function gigIsNotFull()
    {
        return ! $this->liveGig->isFull() ? true 
             : $this->failWithMessage('O limite de músicas desse set foi alcançado');
    }

    public function votingHasNotFinished()
    {
        return ! $this->liveGig->winner()->exists() ? true 
             : $this->failWithMessage('Esse evento não está recebendo mais pedidos');
    }

    public function userCanMakeRequests()
    {
        return ! $this->liveGig->userLimitReached() ? true 
             : $this->failWithMessage('O seu limite de músicas foi alcançado');
    }

    public function songNotYetRequestedByUser()
    {
        return ! auth()->user()->requestedTonight($this->song) ? true 
             : $this->failWithMessage('Você já escolheu essa música');
    }

    public function songCanBeRequestedAgain()
    {
        $message = $this->liveGig->repeat_limit == 0 
            ? 'Essa música já foi escolhida 1 vez' 
            : 'Essa música já foi escolhida ' . $this->liveGig->repeat_limit + 1 . ' vezes';

        return ! $this->liveGig->repeatLimitReachedFor($this->song) ? true
             : $this->failWithMessage($message);
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
