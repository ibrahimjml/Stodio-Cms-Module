<?php

namespace Modules\Auditlog\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Acl\Models\User;
use Modules\Auditlog\Enums\AuditPeriod;

#[Fillable([
  'user_agent', 'ip_address', 'module', 'action', 'user_id',
  'reference_user', 'reference_id', 'reference_name', 'type', 'request']
  )]
class AuditLog extends Model
{
    use HasFactory, MassPrunable;

    protected function casts(): array
    {
        return [
            'request' => 'array',
        ];
    }
    
 /**
  * @return BelongsTo<User, $this>
  */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function prunable(): EloquentBuilder
    {
        $days = setting('audit_log_clear_period');

        if ($days === AuditPeriod::NEVER) {
            return $this->query()->where('id', '<', 0);
        }

        return $this->query()->where('created_at', '<', Carbon::now()->subDays($days));
    }
}
