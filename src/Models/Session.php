<?php
namespace App\Models;
/**
 * @Table("sessions")
 */
class Session extends \Aternos\Model\GenericModel
{
    // use model registry (default: true)
    protected static bool $registry = true;

    // cache the model for 60 seconds (default: null)
    protected static ?int $cache = 60;

    // the name of your model (and table)
    public static function getName() : string
    {
        return "sessions";
    }

    protected static array $drivers = [
        \Aternos\Model\Driver\Mysqli\Mysqli::ID
    ];

    public mixed $session_id;

    public mixed $user_id;

    public mixed $data;

    public mixed $ip_address;

    public mixed $last_activity;

    public mixed $expires_at;
}
