<?php
declare(strict_types=1);
namespace Chat\Message;

use Chat\Service\User;
use Chat\Generic\Constants;
#[Chat\Message\Validate]
class Validate
{
    public static function validateFromUser(array $data, array &$message = [])
    {
        $found = TRUE;
        if (empty($data['from'])) {
            $message[] = Constants::ERR_FROM_USER;
            $found = FALSE;
        } else {
            $user = new User();
            $result = $user->findByUserName($data['from']);
            if (!$result || $data['from'] !== $result['username']) {
                $message[] = Constants::ERR_NOT_USER . ' [from]';
                $found = FALSE;
            }
        }
        return $found;
    }
    public static function validateToUser(array $data, array &$message = [])
    {
        $found = TRUE;
        if (!empty($data['to'])) {
            $user = new User();
            $result = $user->findByUserName($data['to']);
            if (!$result || $data['to'] !== $result['username']) {
                $message[] = Constants::ERR_NOT_USER . ' [to]';
                $found = FALSE;
            }
        }
        return $found;
    }
    public static function validateMessage(array &$data, array &$message = [])
    {
        $errors = 0;
        if (empty($data['msg'])) {
            $message[] = Constants::ERR_MSG_NOT;
            $errors++;
        } else {
            $data['msg'] = strip_tags($data['msg']);
            if (strlen($data['msg']) > Constants::DEFAULT_MSG_LEN) {
                $errors++;
                $message[] = Constants::ERR_MSG_LEN;
            }
        }
        return ($errors === 0);
    }
    public static function validatePost(array &$data, array &$message = [])
    {
        $valid = 0;
        $valid += (int) self::validateFromUser($data, $message);
        $valid += (int) self::validateToUser($data, $message);
        $valid += (int) self::validateMessage($data, $message);
        return ($valid === 0);
    }
    public static function validateGet(array $data, array &$message = [])
    {
        return self::validateFromUser($data, $message);
    }
}
