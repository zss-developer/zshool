<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Hash;

class Additional {

	/**
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @param $validator
	 * @return bool
	 */
	public function validatePhone($attribute, $value, $parameters, $validator)
    {
        return strlen(preg_replace('#^.*([0-9]{3})[^0-9]*([0-9]{3})[^0-9]*([0-9]{4})$#', '$1$2$3', $value)) == 10;
    }

	/**
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @param $validator
	 * @return mixed
	 */
	public function validateHash($attribute, $value, $parameters, $validator)
    {
        return Hash::check($value, $parameters[0]);
    }
}