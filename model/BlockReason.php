<?php


class BlockReason implements JsonSerializable
{
    private $blocked_user;
    private $date;
    private $blockee;
    private $reason;

    /**
     * BlockReason constructor.
     * @param $blocked_user
     * @param $date
     * @param $blockee
     * @param $reason
     */
    public function __construct($blocked_user, $date, $blockee, $reason)
    {
        $this->blocked_user = $blocked_user;
        $this->date = $date;
        $this->blockee = $blockee;
        $this->reason = $reason;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return json_encode(get_object_vars($this));
    }
}