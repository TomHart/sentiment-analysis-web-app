<?php
declare(strict_types=1);

namespace App\Http\Livewire\Brain;

use App\Http\Livewire\BaseComponent;
use App\Models\Brain;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Class UsagePanel
 * @property array monthlyUsage
 * @package App\Http\Livewire\Brain
 */
class UsagePanel extends BaseComponent
{
    public Brain $brain;

    /**
     * @return array
     */
    public function getMonthlyUsageProperty(): array
    {
        $dateClause = env('DB_CONNECTION') === 'sqlite' ? 'strftime("%m %Y", created_at)' : 'date_format(created_at, "%m %Y")';

        return $this->brain
            ->results()
            ->select(
                DB::raw('count(analysis_results.id) as total'),
                DB::raw("$dateClause as months")
            )
            ->groupBy('months')
            ->orderByDesc('created_at')
            ->get()
            ->pluck('total', 'months')
            ->toArray();
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.brain.usage-panel');
    }
}
