
var InputsCheckboxesRadios = function () {

    // Uniform
    var _componentUniform = function() {
        if (!$().uniform) {
            console.warn('Warning - uniform.min.js is not loaded.');
            return;
        }

        $('.form-check-input-styled').uniform();

        $('.form-check-input-styled-primary').uniform({
            wrapperClass: 'border-primary-600 text-primary-800'
        });

    };

    return {
        initComponents: function() {
            _componentUniform();
        }
    }
}();

document.addEventListener('DOMContentLoaded', function() {
    InputsCheckboxesRadios.initComponents();
});