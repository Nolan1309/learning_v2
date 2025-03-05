<?php
interface IValidate
{
    public function validate($value): bool;
}

class User
{
    protected $validators = [];

    public function __construct(array $validators)
    {
        $this->validators = $validators;
    }

    public function login($value)
    {
        foreach ($this->validators as $validator) {
            if (!$validator->validate($value)) {
                echo "Lỗi rồi!";
                return;
            }
        }
        echo "Đăng nhập thành công";
    }
}

class UsernameValidator implements IValidate
{
    public function validate($value): bool
    {
        if (isset($value['username']) && trim($value['username']) !== '')
            return true;
        return false;
    }
}

class PasswordValidator implements IValidate
{
    public function validate($value): bool
    {
        if (isset($value['password']) && strlen($value['password']) >= 8)
            return true;
        return false;
    }
}


class ValidatorFactory
{
    public function createValidator($type): IValidate
    {
        if ($type === 'username') {
            return new UsernameValidator();
        } elseif ($type === 'password') {
            return new PasswordValidator();
        }
        throw new Exception("Validator không hợp lệ");
    }
}


$factory = new ValidatorFactory();
$user = new User([$factory->createValidator('username'), $factory->createValidator('password')]);
$user->login(['username' => 'Thanh1309', 'password' => '12345678']);