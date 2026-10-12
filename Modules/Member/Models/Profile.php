<?php

namespace Modules\Member\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('profiles')]
#[Fillable(['member_id', 'is_public', 'github', 'twitter', 'linkedin', 'cover_photo', 'bio', 'aboutme'])]
class Profile extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo<Member, $this>
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }
}
