<?php

namespace App\Http\Livewire\Connect\Badge;

use App\Models\Badge;
use App\Models\Profile;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ManageBadges extends Component
{
    public $badgable;
    public $badge = ['for' => '', 'description' => '', 'label' => ''];
    public Profile $credit;
    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public function mount()
    {
        $this->badge['for'] = $this->badgable->getBadgeCanUse();
    }

    public function toggle(Badge $badge)
    {
        if ($badge) {
            $this->badgable->badges()->toggle($badge->id);
            if (($this->badgable->primaryBadge) === $badge && (!$this->exists($badge))) {
                $this->badgable->setPrimaryBadge($this->badgable->getDefaultBadge());
            }
        }
    }

    public function add(Badge $badge): bool
    {
        if ($badge && !$this->exists($badge)) {
            $this->badgable->badges()->attach($badge->id);
            $this->badgable->flushQueryCache();
            $this->emitSelf('refresh');
            return true;
        }
        return false;
    }

    public function makePrimary(Badge $badge)
    {
        if ($badge) {
            $this->badgable->primary_badge_id = $badge->id;
            $this->badgable->setRelation('primaryBadge', $badge);
            $this->badgable->save();
        }
    }

    public function createBadge()
    {
        $this->validate([
            'badge.for' => ['required', 'string', Rule::in(['user', 'business'])],
            'badge.description' => ['required', 'string'],
            'badge.label' => ['required', 'string', Rule::unique('badges', 'label')]
        ]);
        (new Badge())->forceFill([
            'label' => $this->badge['label'],
            'description' => $this->badge['description'],
            'canuse' => $this->badge['for'],
            'credit' => $this->credit->id
        ])->save();
        $this->emitSelf('refresh');
        return true;
    }

    public function exists(Badge $badge)
    {
        return $this->badgable->badges()->where('label', $badge->label)->exists();
    }

    public function getInfo(Badge $badge)
    {
        return $badge?->description;
    }

    public function render()
    {
        return view('livewire.connect.badge.manage-badges', [
            'attachedBadges' => $this->badgable->badges->sortBy('label'),
            'primaryBadge' => $this->badgable->primaryBadge,
            'detachedBadges' => Badge::whereNotIn('id', $this->badgable->badges->pluck('id'))->where('canuse', $this->badgable->getBadgeCanUse())->get()
        ]);
    }
}
