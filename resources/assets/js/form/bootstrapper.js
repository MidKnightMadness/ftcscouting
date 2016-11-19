/**
 * Load the form instance
 */
require('./form');

/**
 * Add http helpers to the main instance
 */
$.extend(Scouting, require('./http'));

/**
 * Load form components
 */
require('./components');