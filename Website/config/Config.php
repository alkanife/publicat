<?php

// PUBLICAT
const PUBLICAT_LANG = 'fr';

const PICTURE_SIZE = 2000000; // In bytes (= 2MB)
const PICTURE_EXTENSIONS = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
];

// USER
const MIN_EMAIL_SIZE = 6;
const MAX_EMAIL_SIZE = 200;

const MIN_USERNAME_SIZE = 5;
const MAX_USERNAME_SIZE = 30;

const MIN_PASSWORD_SIZE = 10;
const MAX_PASSWORD_SIZE = 258;

const MIN_DISPLAY_NAME_SIZE = 2;
const MAX_DISPLAY_NAME_SIZE = 50;

const MIN_ABOUT_ME_SIZE = 5;
const MAX_ABOUT_ME_SIZE = 160;

// REGEX
const REGEX_EMAIL = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{0,15})$/';
const REGEX_USERNAME = '/^(?=.{3,25}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/';
const REGEX_DATE = '/^[0-9]{4}(-[0-9]{2}){2}$/';