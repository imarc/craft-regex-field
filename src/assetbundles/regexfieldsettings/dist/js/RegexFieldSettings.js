/**
 * Regex Field plugin for Craft CMS 4.x
 *
 * A field type for Craft CMS that validates input values against a regular expression.
 *
 * @link     https://www.imarc.com
 * @copyright Copyright (c) 2023 Linnea Hartsuyker
 */

(function ( $ ) {

    if (typeof Craft.Regex === 'undefined') {
        Craft.Regex = {};
    }

    Craft.Regex.RegexField = {
        init: function() {
            var self = this
            console.log('RegexField init')
            $('#main-form').on('submit', function(e) {
                if (!self.validate()) {
                    e.preventDefault();
                }
            });
        },

        toggleInputState: function(el, valid, message) {
            var $el = $(el);
            var $input = $el.closest('.input');
            var $errors = $input.find('ul.errors');

            $el.toggleClass('error', !valid);
            $input.toggleClass('errors', !valid);

            if (valid) {
                $errors.remove();
            } else if ($errors.length === 0) {
                $('<ul>', {'class': 'errors'})
                    .appendTo($input)
                    .append($('<li>', {'html': message}));
            }
        },

        validate: function() {
            let hasRegex = $('#types-imarc-regexfield-fields-RegexField-pattern').val().length > 0
            if (!hasRegex) {
                this.toggleInputState($('#types-imarc-regexfield-fields-RegexField-pattern'), false, 'Please enter a regular expression.')
            } else {
                this.toggleInputState($('#types-imarc-regexfield-fields-RegexField-pattern'), true)
            }
            return hasRegex
        }
    }

    $(function() {
        Craft.Regex.RegexField.init();
    })

})( jQuery)

