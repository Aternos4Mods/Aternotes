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

    protected mixed $session_id;

    protected mixed $user_id;

    protected mixed $data;

    protected mixed $ip_address;

    protected mixed $last_activity;

    protected mixed $expires_at;

    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setIpAddress($ip_address)
    {
        $this->ip_address = $ip_address;
    }

    public function setLastActivity($last_activity)
    {
        $this->last_activity = $last_activity;
    }

    public function setExpiresAt($expires_at)
    {
        $this->expires_at = $expires_at;
    }

    public function getExpiresAt()
    {
        return $this->expires_at;
    }
}
