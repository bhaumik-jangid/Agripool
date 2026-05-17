<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceProposalVote extends Model
{
    protected $fillable = ['price_proposal_id', 'user_id', 'vote'];

    public function proposal()
    {
        return $this->belongsTo(PriceProposal::class, 'price_proposal_id');
    }

    public function farmer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}