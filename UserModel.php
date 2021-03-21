<?php

namespace alucardthefish\framvcwork;

use alucardthefish\framvcwork\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName();
}
