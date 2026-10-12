<?php

if(! function_exists('resolve_login_type')){
  function resolve_login_type(string $login): string {
    return filter_var($login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';
  }
}