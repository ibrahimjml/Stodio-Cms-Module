<?php
namespace Modules\Member\Enums;
enum LoginEnum: string
{
    case SUCCESS = 'success';
    case TWO_FACTOR_REQUIRED = 'two_factor_required';
}