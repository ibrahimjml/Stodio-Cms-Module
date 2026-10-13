<?php

namespace Modules\Auditlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Acl\Models\User;


#[Fillable([
  'user_agent', 'ip_address', 'module', 'action', 'user_id',
  'reference_user', 'reference_id', 'reference_name', 'type', 'request']
  )]
class AuditLog extends Model
{
    use HasFactory;

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
}
