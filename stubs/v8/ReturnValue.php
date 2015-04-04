<?php

/*
  +----------------------------------------------------------------------+
  | This file is part of the pinepain/php-v8 PHP extension.              |
  |                                                                      |
  | Copyright (c) 2015-2016 Bogdan Padalko <pinepain@gmail.com>          |
  |                                                                      |
  | Licensed under the MIT license: http://opensource.org/licenses/MIT   |
  |                                                                      |
  | For the full copyright and license information, please view the      |
  | LICENSE file that was distributed with this source or visit          |
  | http://opensource.org/licenses/MIT                                   |
  +----------------------------------------------------------------------+
*/


namespace v8;


class ReturnValue
{
    /**
     * @param \v8\Value $value
     */
    public function Set(Value $value)
    {
    }

    public function SetNull()
    {
    }

    public function SetUndefined()
    {
    }

    public function SetEmptyString()
    {
    }

    /**
     * @param bool $value
     */
    public function SetBool(bool $value)
    {
    }

    /**
     * @param int $i
     */
    public function SetInteger(int $i)
    {
    }

    /**
     * @param float $i
     */
    public function SetFloat(float $i)
    {
    }

    /**
     * @return \v8\Isolate
     */
    public function GetIsolate() : Isolate
    {
    }

    /**
     * @return \v8\Context
     */
    public function GetContext() : Context
    {
    }
}
