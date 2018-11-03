<?php
namespace CallOfDuty\Api;

use CallOfDuty\Client;

class Squad extends AbstractApi
{
    private $info;
    private $name;

    public function __construct(Client $client, string $name)
    {
        parent::__construct($client, 'https://squads.callofduty.com/api/v1/');
        $this->name = $name;
    }

    /**
     * Get squad information.
     *
     * @return object Squad information.
     */
    private function info() : object
    {
        if ($this->info === null) {
            $data = $this->get(sprintf("squad/lookup/name/%s/", $this->name));
            if ($data->status !== "success") {
                throw new Exception($data->data);
            }

            $this->info = $data->data;
        }

        return $this->info;
    }

    /**
     * Get group creator.
     *
     * @return User|null Group creator or null if the squad was auto-created.
     */
    public function creator() : ?User
    {
        if ($this->info()->creator === null) {
            return null;
        }

        return new User($this->client, $this->info()->creator->gamerTag, $this->info()->creator->platform);
    }

    /**
     * Get group id.
     *
     * @return integer Group Id.
     */
    public function id() : int
    {
        return $this->info()->id;
    }

    /**
     * Get group creation date.
     *
     * @return \DateTime Creation date.
     */
    public function createDate() : \DateTime
    {
        return new \DateTime($this->info()->createDate);
    }

    /**
     * Get group name.
     *
     * @return string Group name.
     */
    public function name() : string
    {
        return $this->info()->name;
    }

    /**
     * Get group description.
     *
     * @return string Group description.
     */
    public function description() : string
    {
        return $this->info()->description;
    }

    /**
     * Get group avatar URL.
     *
     * @return string Avatar URL.
     */
    public function avatarUrl() : string
    {
        return $this->info()->avatarUrl;
    }

    /**
     * Get group status.
     *
     * @return boolean Group closed?
     */
    public function closed() : bool
    {
        return $this->info()->closed;
    }

    /**
     * Get group points.
     *
     * Type is still unknown so for now, it's a float.
     *
     * @return float Group points.
     */
    public function points() : float
    {
        return $this->info()->points;
    }

    /**
     * Get group members.
     *
     * @return array Array of Api\User.
     */
    public function members() : array
    {
        $returnedMembers = [];

        if (count($this->info()->members) === 0) {
            return $returnedMembers;
        }

        foreach ($this->info()->members as $member) {
            $returnedMembers[] = new User($this->client, $member->gamerTag, $member->platform);
        }

        return $returnedMembers;
    }

    /**
     * Join the squad.
     *
     * @return Squad The joined squad.
     */
    public function join() : Squad
    {
        $this->get(sprintf("squad/join/%s", $this->name()));
        
        return $this;
    }

    /**
     * Leave the Squad.
     *
     * @return Squad The left Squad.
     */
    public function leave() : Squad
    {
        $this->get("squad/leave/");

        return $this;
    }
}