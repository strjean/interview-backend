<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use App\Traits\CacheTrait;
use App\Traits\RecordSignature;
use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;
use Chelout\RelationshipEvents\Traits\HasRelationshipObservables;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasFactory,
        HasBelongsToManyEvents,
        HasRelationshipObservables,
        Notifiable,
        RecordSignature,
        QueryCacheable,
        CacheTrait;

    protected $table = 'user';

    public $timestamps = true;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'hashed_password',
        'language_id',
        'hubspot_id',
        'phone_number',
        'is_active',
        'email_verified_at',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'uuid',
        'ambassador_id',
        'role_id',
    ];

    protected $hidden = [
        'old_password',
        'hashed_password',
        'farmCount',
        'email_verified_at',
        'is_active',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    protected $with = [];

    protected $appends = [];

    public static bool $flushCacheOnUpdate = true;

    public int $cacheFor = 3600; // cache time, in seconds - cfr. Eloquent Query Cache https://leqc.renoki.org/cache-tags/query-caching

    protected function cacheTagsValue(): ?array
    {
        return [$this->table];
    }

    protected function cachePrefixValue(): string
    {
        return $this->table.'_';
    }

    protected $casts = ['email_verified_at' => 'datetime'];

    protected int $email_verification_delay = 3; // in days

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope('hashed_password_check', function (Builder $builder) {
            $builder->where('hashed_password', '!=', '');
        });
    }

    /**
     * Getting the email address
     *
     * @param $value
     * @return void
     */
    public function setEmailAttribute($value): void
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * Getting the password
     *
     * @return string
     */
    public function getAuthPassword(): string
    {
        return (string) $this->hashed_password;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
