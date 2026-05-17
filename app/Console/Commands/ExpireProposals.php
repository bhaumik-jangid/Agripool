<?php

namespace App\Console\Commands;

use App\Models\PriceProposal;
use App\Models\Notification;
use Illuminate\Console\Command;

class ExpireProposals extends Command
{
    protected $signature   = 'proposals:expire';
    protected $description = 'Expire pending price proposals older than 24 hours';

    public function handle(): void
    {
        $expired = PriceProposal::where('status', 'pending')
                                ->where('expires_at', '<', now())
                                ->get();

        foreach ($expired as $proposal) {
            $proposal->update(['status' => 'expired']);

            // Notify driver — proposal expired
            Notification::create([
                'user_id' => $proposal->driver_id,
                'title'   => '⏰ Price Proposal Expired',
                'message' => 'Your price proposal of ₹'
                             . number_format($proposal->proposed_cost, 0)
                             . ' for pool '
                             . $proposal->pool->pool_code
                             . ' expired without enough votes. '
                             . 'The pool is still available at the original price.',
                'type'    => 'proposal_expired',
                'link'    => '/driver/pools',
            ]);

            // Notify farmers
            foreach ($proposal->pool->members as $member) {
                Notification::create([
                    'user_id' => $member->user_id,
                    'title'   => '⏰ Price Proposal Expired',
                    'message' => 'The price proposal from '
                                 . $proposal->driver->name
                                 . ' has expired. '
                                 . 'Your pool is still open for drivers.',
                    'type'    => 'proposal_expired',
                    'link'    => '/farmer/pools',
                ]);
            }
        }

        $this->info('Expired ' . $expired->count() . ' proposals.');
    }
}