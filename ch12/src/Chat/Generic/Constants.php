<?php
namespace Chat\Generic;

class Constants
{
    public const USAGE = <<<EOT
POST:
    "from" : "string: valid username of sender",
    "to"   : "string: valid username; if omitted: goes to all users",
    "msg"  : "string: message body (max 4096 chars)"
GET:
    "from"   : "valid username of sender",
    "limit"  : "int: how many messages to get; default: 100",
    "offset" : "int: how many messages to skip; default: 0",
    "days"   : "int: returns messages more recent that this many days ago; default: 7"
EOT;
    public const DATE_FORMAT     = 'Y-m-d H:i:s';
    public const DEFAULT_LIMIT   = 100;
    public const DEFAULT_OFFSET  = 0;
    public const DEFAULT_DAYS    = 7;
    public const DEFAULT_MSG_LEN = 4096;
    public const ERR_SQL_FROM    = 'ERROR: missing table name';
    public const ERR_NOT_USER    = 'ERROR: user not found';
    public const ERR_FROM_USER   = 'ERROR: "from" username is required';
    public const ERR_MSG_NOT     = 'ERROR: no message';
    public const ERR_MSG_LEN     = 'ERROR: message must be ' . self::DEFAULT_MSG_LEN . ' chars or less';
}
