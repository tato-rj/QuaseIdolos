<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Song;

class ChangeSongRequestForm extends FormRequest
{
    protected $liveGig, $message, $selectedSong;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $songRequest = $this->route('songRequest');
        $this->user()->can('update', $songRequest) || abort(403);

        if ($songRequest->isOver())
            return $this->failWithMessage('Esse pedido já foi completado');

        // FormRequest authorization runs before rules; validate before loading the song.
        $this->getSong();

        if (auth()->user()->admin()->exists())
            return true;
        
        $this->liveGig = auth()->user()->liveGig;

        return $this->gigIsLive() && 
               $this->gigIsNotPaused() && 
               $this->votingHasNotFinished() && 
               $this->songNotYetRequestedByUser() &&
               $this->songCanBeRequestedAgain() &&
               $this->songIsKnownByTheBand();
    }

    public function gigIsLive()
    {
        return $this->liveGig && $this->liveGig->isLive()
            && $this->route('songRequest')->gig_id == $this->liveGig->id ? true
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
        return ! auth()->user()->requestedTonight($this->getSong()) ? true 
             : $this->failWithMessage('Você já escolheu essa música');
    }

    public function songCanBeRequestedAgain()
    {
        $message = $this->liveGig->repeat_limit == 0 
            ? 'Essa música já foi escolhida 1 vez' 
            : 'Essa música já foi escolhida ' . ($this->liveGig->repeat_limit + 1) . ' vezes';

        return ! $this->liveGig->repeatLimitReachedFor($this->getSong()) ? true
             : $this->failWithMessage($message);
    }

    public function rules()
    {
        return ['new_song_id' => 'required|integer|exists:songs,id'];
    }

    public function songIsKnownByTheBand()
    {
        return ! $this->liveGig->unknown_songs->contains($this->getSong()->id) ? true
            : $this->failWithMessage('Essa música não está disponível hoje');
    }

    public function failWithMessage($message)
    {
        $this->message = $message;

        return false;
    }

    public function failedAuthorization() {
        throw new \App\Exceptions\SetlistException($this->message, 403);
    }

    public function getSong()
    {
        if (! $this->selectedSong) {
            $this->validate($this->rules());
            $this->selectedSong = Song::findOrFail($this->new_song_id);
        }

        return $this->selectedSong;
    }
}
