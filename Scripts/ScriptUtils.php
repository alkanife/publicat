<?php

// Reset
const COLOR_RESET = "\e[0m";  // Text Reset

// Regular Colors
const COLOR_BLACK = "\e[0;30m";
const COLOR_RED = "\e[0;31m";
const COLOR_GREEN = "\e[0;32m";
const COLOR_YELLOW = "\e[0;33m";
const COLOR_BLUE = "\e[0;34m";
const COLOR_PURPLE = "\e[0;35m";
const COLOR_CYAN = "\e[0;36m";
const COLOR_WHITE = "\e[0;37m";

// Bold
const COLOR_BLACK_BOLD = "\e[1;30m";
const COLOR_RED_BOLD = "\e[1;31m";
const COLOR_GREEN_BOLD = "\e[1;32m";
const COLOR_YELLOW_BOLD = "\e[1;33m";
const COLOR_BLUE_BOLD = "\e[1;34m";
const COLOR_PURPLE_BOLD = "\e[1;35m";
const COLOR_CYAN_BOLD = "\e[1;36m";
const COLOR_WHITE_BOLD = "\e[1;37m";

// Underline
const COLOR_BLACK_UNDERLINED = "\e[4;30m";
const COLOR_RED_UNDERLINED = "\e[4;31m";
const COLOR_GREEN_UNDERLINED = "\e[4;32m";
const COLOR_YELLOW_UNDERLINED = "\e[4;33m";
const COLOR_BLUE_UNDERLINED = "\e[4;34m";
const COLOR_PURPLE_UNDERLINED = "\e[4;35m";
const COLOR_CYAN_UNDERLINED = "\e[4;36m";
const COLOR_WHITE_UNDERLINED = "\e[4;37m";

// Background
const COLOR_BLACK_BACKGROUND = "\e[40m";
const COLOR_RED_BACKGROUND = "\e[41m";
const COLOR_GREEN_BACKGROUND = "\e[42m";
const COLOR_YELLOW_BACKGROUND = "\e[43m";
const COLOR_BLUE_BACKGROUND = "\e[44m";
const COLOR_PURPLE_BACKGROUND = "\e[45m";
const COLOR_CYAN_BACKGROUND = "\e[46m";
const COLOR_WHITE_BACKGROUND = "\e[47m";

// High Intensity
const COLOR_BLACK_BRIGHT = "\e[0;90m";
const COLOR_RED_BRIGHT = "\e[0;91m";
const COLOR_GREEN_BRIGHT = "\e[0;92m";
const COLOR_YELLOW_BRIGHT = "\e[0;93m";
const COLOR_BLUE_BRIGHT = "\e[0;94m";
const COLOR_PURPLE_BRIGHT = "\e[0;95m";
const COLOR_CYAN_BRIGHT = "\e[0;96m";
const COLOR_WHITE_BRIGHT = "\e[0;97m";

// Bold High Intensity
const COLOR_BLACK_BOLD_BRIGHT = "\e[1;90m";
const COLOR_RED_BOLD_BRIGHT = "\e[1;91m";
const COLOR_GREEN_BOLD_BRIGHT = "\e[1;92m";
const COLOR_YELLOW_BOLD_BRIGHT = "\e[1;93m";
const COLOR_BLUE_BOLD_BRIGHT = "\e[1;94m";
const COLOR_PURPLE_BOLD_BRIGHT = "\e[1;95m";
const COLOR_CYAN_BOLD_BRIGHT = "\e[1;96m";
const COLOR_WHITE_BOLD_BRIGHT = "\e[1;97m";

// High Intensity backgrounds
const COLOR_BLACK_BACKGROUND_BRIGHT = "\e[0;100m";
const COLOR_RED_BACKGROUND_BRIGHT = "\e[0;101m";
const COLOR_GREEN_BACKGROUND_BRIGHT = "\e[0;102m";
const COLOR_YELLOW_BACKGROUND_BRIGHT = "\e[0;103m";
const COLOR_BLUE_BACKGROUND_BRIGHT = "\e[0;104m";
const COLOR_PURPLE_BACKGROUND_BRIGHT = "\e[0;105m";
const COLOR_CYAN_BACKGROUND_BRIGHT = "\e[0;106m";
const COLOR_WHITE_BACKGROUND_BRIGHT = "\e[0;107m";

/**
 * Print value and reset color after
 *
 * @param mixed $value
 * @return void
 */
function printr(mixed $value): void {
    echo $value . COLOR_RESET;
}

/**
 * Print value, reset color, and skip a line
 *
 * @param mixed $value
 * @return void
 */
function printrl(mixed $value): void {
    printr($value);
    echo PHP_EOL;
}

/**
 * Clear terminal
 *
 * @return void
 */
function clear(): void {
    echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
}