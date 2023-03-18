<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    protected $table = "users";

    public function getTable(): string
    {
        return $this->table;
    }

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function setId($id)
    {
        $this->attributes['id'] = $id;
    }
    public function getFirstName()
    {
        return $this->attributes['first_name'];
    }
    public function setFirstName($first_name)
    {
        $this->attributes['first_name'] = $first_name;
    }

    public function getSurname()
    {
        return $this->attributes['surname'];
    }
    public function setSurname($surname)
    {
        $this->attributes['surname'] = $surname;
    }
    public function getOtherName()
    {
        return $this->attributes['other_name'];
    }
    public function setOtherName($other_name)
    {
        $this->attributes['other_name'] = $other_name;
    }
    public function getEmail()
    {
        return $this->attributes['email'];
    }
    public function setEmail($email)
    {
        $this->attributes['email'] = $email;
    }
    public function getPhoneNumber()
    {
        return $this->attributes['phone_number'];
    }
    public function setPhoneNumber($phone_number)
    {
        $this->attributes['phone_number'] = $phone_number;
    }

    public function getPassword()
    {
        return $this->attributes['password'];
    }

    public function setPassword($password)
    {
        $this->attributes['password'] = $password;
    }
}