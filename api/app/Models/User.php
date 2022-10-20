<?php

namespace App\Models;

use App\Notifications\EmailVerificationNotification;
use App\Notifications\MailResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Enums\UserRole;

/**
 * Class User
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $password
 */

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profile_image',
        'name',
        'last_name',
        'date_birth',
        'email',
        'phone',
        'password',
        'city',
        'university',
        'graduation_year',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_birth' => 'date:Y-m-d',
        'role' => UserRole::class,
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): string
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getAvatar(): ?string
    {
        return asset($this->profile_image);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getDateBirth(): ?Carbon
    {
        return $this->date_birth;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getCity(): ?int
    {
        return $this->city;
    }

    public function getUniversity(): ?int
    {
        return $this->university;
    }

    public function getGraduationYear(): ?int
    {
        return $this->graduation_year;
    }

    public function getVerifiedEmail(): ?Carbon
    {
        return $this->email_verified_at;
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new EmailVerificationNotification());
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new MailResetPasswordNotification($token));
    }

    public function lectures(): HasMany {
        return $this->hasMany(Lecture::class, 'author_id');
    }

    public function getUserRole(): ?UserRole
    {
        return $this->role;
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public static function getAuthUserId(): int
    {
        return \Auth::id();
    }

    public static function isUserLecturer(): ?bool
    {
        return \Auth::user()->role === UserRole::LECTURER;
    }

    public function courses(): HasMany {
        return $this->hasMany(Course::class, 'author_id');
    }

    public function course(): BelongsTo {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function getCourseTitle(): ?string {
        return $this->course ? $this->course->getTitle() : null;
    }

    public static function isUserLectionAuthor($id): ?bool
    {
        return \Auth::user()->lectures->contains('id', $id);
    }

    public static function isUserCourseAuthor($id): ?bool
    {
        return \Auth::user()->courses->contains('id', $id);
    }

    public function linkedLectures(): BelongsToMany {
        return $this->belongsToMany(Lecture::class);
    }

    public static function isUserAdmin(): ?bool
    {
        return \Auth::user()->role === UserRole::ADMIN;
    }

    public function tasks(): HasMany {
        return $this->hasMany(Task::class, 'author_id');
    }

    public function userTasks(): BelongsToMany {
        return $this->belongsToMany(Task::class)
            ->withPivot(['answer', 'rating']);
    }

    public static function isUserTaskAuthor($id): ?bool
    {
        return \Auth::user()->tasks->contains('id', $id);
    }

    public function getCourseId(): ?int {
        return $this->course ? $this->course->getId() : null;
    }
}
